<?php

namespace App\Http\Controllers\Admin;
use App\Http\Services\AttendanceService;
use App\Models\Attendance;
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
        $query = Attendance::query();

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

        //$attendances = $query->paginate(20);
        $rows = $query->paginate(10)->appends($request->all());
        $attendances = Attendance::with('user')->get();
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
        $attendance = Attendance::findOrFail($id);
        $this->responseData['attendance'] = $attendance;
        return $this->responseView($this->viewPart . '.edit', $this->responseData);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
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
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('successMessage', 'Xóa chấm công thành công.');
    }
}
