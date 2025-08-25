<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\LeaveRequestService;
use App\Models\Admin;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestSalary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    protected $leaveRequestService;
    public function __construct(LeaveRequestService $leaveRequestService)
    {
        parent::__construct();
        $this->routeDefault  = 'leave_request';
        $this->viewPart = 'admin.pages.leave_request';
        $this->responseData['module_name'] = 'Quản lý đơn xin nghỉ phép';
        $this->leaveRequestService = $leaveRequestService;
    }

    public function index(Request $request)
    {
        $query = LeaveRequestSalary::query();

        // lọc theo mã nhân viên
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('leave_date_start', $month->month)
                ->whereYear('leave_date_start', $month->year);
        }
          if ($request->filled('form_date')) {
            $query->whereDate('created_at', '>=', $request->form_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //sắp xếp
        // $sort = $request->get('sort', 'asc');
        // $query->orderBy('leave_date', $sort);

        $rows = $query->paginate(10);
        $this->responseData['rows'] = $rows;
        return $this->responseView($this->viewPart . '.index', $this->responseData);
    }
    public function create()
    {
        $users = Admin::all();
        $this->responseData['users'] = $users;
        return $this->responseView($this->viewPart . '.create', $this->responseData);
    }
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'leave_date_start' => 'required|date|max:255',
            'leave_date_end' => 'required|date|after_or_equal:leave_date_start',
            'leave_type' => 'required|string|max:50',
            'reason' => 'nullable|string|max:100',
            'status' => 'nullable|string',
        ]);

        $this->leaveRequestService->createLeaveRequest($request->all());
        return redirect()->route('leave_request.index')->with('success', 'Thêm đơn xin nghỉ phép thành công');
    }
    public function edit($id)
    {
        $users = Admin::all();
        $leave_request = LeaveRequestSalary::findOrFail($id);
        $this->responseData['leave_request'] = $leave_request;
        $this->responseData['users'] = $users;
        return $this->responseView($this->viewPart . '.edit', $this->responseData);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'leave_date_start' => 'required|date|max:255',
            'leave_date_end' => 'required|date|after_or_equal:leave_date_start',
            'leave_type' => 'required|string|max:50',
            'reason' => 'nullable|string|max:100',
            'status' => 'nullable|string',
        ]);
        $this->leaveRequestService->createOrUpdateLeaveRequest($request->all(), $id);
        return redirect()->route('leave_request.index')->with('successMessage', 'Sửa đơn xin nghỉ phép thành công');
    }
    public function destroy($id)
    {
        $leave_request = LeaveRequestSalary::findOrFail($id);
        $leave_request->delete();
        return redirect()->route('leave_request.index')->with('successMessage', 'Xóa thành công');
    }
}
