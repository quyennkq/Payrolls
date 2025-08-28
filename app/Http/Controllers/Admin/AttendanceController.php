<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;
    public function __construct(AttendanceService $attendanceService)
    {
        parent::__construct();
        $this->routeDefault  = 'attendance';
        $this->viewPart = 'admin.pages.V_attendance';
        $this->responseData['module_name'] = 'Quản lý bảng chấm công';
        $this->attendanceService = $attendanceService;
    }
    public function index(Request $request)
    {
        $rows = $this->attendanceService->filter($request);
        $attendances = AttendanceEmployee::with('admin')->get();
        $this->responseData['rows'] = $rows;
        $this->responseData['attendances'] = $attendances;
        return  $this->responseView($this->viewPart . '.index', $this->responseData);
    }

    public function import(Request $request)
    {
        $file = $request->file('excel_file');
        $this->attendanceService->importFromExcel($file);

        return redirect()->route('attendance.index')->with('successMessage', 'Thêm dữ liệu chấm công thành công.');
    }

    public function create()
    {
        return $this->responseView($this->viewPart . '.create', $this->responseData);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'standard_working_days' => 'nullable|integer',
            'probation_days' => 'nullable|integer',
        ]);

        $this->attendanceService->createOrUpdateAttendance($data);
        return redirect()->route('attendance.index')->with('successMessage', 'Thêm chấm công thành công.');
    }

    public function edit($id)
    {
        $attendance = AttendanceEmployee::findOrFail($id);
        $this->responseData['attendance'] = $attendance;
        return $this->responseView($this->viewPart . '.edit', $this->responseData);
    }

    public function update(Request $request, $id)
    {
        $attendance = AttendanceEmployee::findOrFail($id);
        $data = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'standard_working_days' => 'nullable|integer',
            'probation_days' => 'nullable|integer',
        ]);

        $this->attendanceService->createOrUpdateAttendance($data, $attendance->id);
        return redirect()->route('attendance.index')->with('successMessage', 'Cập nhật chấm công thành công.');
    }
    public function destroy($id)
    {
        $attendance = AttendanceEmployee::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('successMessage', 'Xóa chấm công thành công.');
    }
}
