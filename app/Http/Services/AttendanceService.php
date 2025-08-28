<?php


namespace App\Http\Services;

use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Request;

class AttendanceService
{
    /**
     * Import attendance data from Excel file.
     */
    public function importFromExcel($file)
    {
        $data = Excel::toArray(null, $file);

        foreach ($data[0] as $key => $row) {
            if ($key === 0) continue; // bỏ dòng header

            $employeeId           = $row[0] ?? null;
            $checkInRaw           = $row[1] ?? null;
            $checkOutRaw          = $row[2] ?? null;
            $standardWorkingDays  = $row[4] ?? null;
            $probationDays        = $row[5] ?? 0;
            $json_params          = $row[6] ?? null;
            $status               = $row[7] ?? null;

            // convert giờ checkin - checkout
            $checkInObj  = $this->convertExcelDate($checkInRaw);
            $checkOutObj = $this->convertExcelDate($checkOutRaw);

            $checkIn  = $checkInObj ? $checkInObj->format('Y-m-d H:i:s') : null;
            $checkOut = $checkOutObj ? $checkOutObj->format('Y-m-d H:i:s') : null;

            // kiểm tra bản ghi đã có chưa
            $existingAttendance = AttendanceEmployee::where('employee_id', $employeeId)
                ->whereDate('check_in', $checkInObj ? $checkInObj->format('Y-m-d') : null)
                ->first();

            $attendanceData = [
                'employee_id'           => $employeeId,
                'check_in'              => $checkIn,
                'check_out'             => $checkOut,
                'standard_working_days' => $standardWorkingDays,
                'probation_days'        => $probationDays,

            ];

            if ($existingAttendance) {
                $this->createOrUpdateAttendance($attendanceData, $existingAttendance->id);
            } else {
                $this->createOrUpdateAttendance($attendanceData);
            }
        }
    }

    /**
     * Convert Excel datetime to PHP DateTime
     */
    protected function convertExcelDate($excelValue)
    {
        if (is_numeric($excelValue) && $excelValue > 0) {
            return ExcelDate::excelToDateTimeObject($excelValue);
        }
        return null;
    }

    /**
     * Tính số giờ làm (trừ 1 tiếng nghỉ trưa)
     */
    protected function calculateWorkHours($checkIn, $checkOut)
    {
        if ($checkIn && $checkOut) {
            $in  = Carbon::parse($checkIn);
            $out = Carbon::parse($checkOut);
            $intervalSeconds = $out->getTimestamp() - $in->getTimestamp() - 3600;
            $workHours = round($intervalSeconds / 3600, 2);
            return $workHours > 0 ? $workHours : 0;
        }
        return 0;
    }

    /**
     * Tính số công chính thức của nhân viên
     */
    protected function calculateOfficialDays($employeeId, $date = null)
    {
        $date = $date ? Carbon::parse($date) : now();

        return AttendanceEmployee::where('employee_id', $employeeId)
            ->where('work_hours', '>', 0)
            ->whereMonth('check_in', $date->month)
            ->whereYear('check_in', $date->year)
            ->count();
    }


    /**
     * Dùng chung cho thêm mới hoặc cập nhật attendance
     */
    public function createOrUpdateAttendance(array $data, $id = null)
    {

        // tính work_hours
        $data['work_hours'] = $this->calculateWorkHours($data['check_in'] ?? null, $data['check_out'] ?? null);

        if (!empty($data['employee_id'])) {
            // lấy số công trong tháng của ngày check_in
            $officialDays = $this->calculateOfficialDays(
                $data['employee_id'],
                $data['check_in'] ?? now()
            );

            // nếu là tạo mới & có work_hours > 0 thì +1 công
            if (is_null($id) && $data['work_hours'] > 0) {
                $officialDays++;
            }

            $data['official_days'] = $officialDays;
        }


        if ($id) {
            $attendance = AttendanceEmployee::findOrFail($id);
            $attendance->update($data);
            return $attendance;
        }

        return AttendanceEmployee::create($data);
    }

    public function filter(Request $request)
    {
        $query = AttendanceEmployee::query();
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('check_in', $month->month)
                ->whereYear('check_in', $month->year);
        }

        // lọc theo mã nhân viên
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // lọc theo khoảng ngày
        if ($request->filled('form_date')) {
            $query->whereDate('check_in', '>=', $request->form_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('check_in', '<=', $request->to_date);
        }

        //sắp xếp
        $sort = $request->get('sort', 'asc');
        $query->orderBy('check_in', $sort);

        return $query->paginate(10)->appends($request->all());
    }
}
