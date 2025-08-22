<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\LeaveBalanceSalaryService;
use App\Models\LeaveBalance;
use App\Models\LeaveBalanceSalary;
use Illuminate\Http\Request;
use App\Models\LeaveRequestSalary;
use App\Models\User;

class LeaveBalanceController extends Controller
{
    protected $leaveBalanceSalaryService;
    public function __construct(LeaveBalanceSalaryService $leaveBalanceSalaryService)
    {
        parent::__construct();
        $this->routeDefault  = 'leave_balance';
        $this->viewPart = 'admin.pages.leave_balance';
        $this->responseData['module_name'] = 'Quản lý số đơn xin nghỉ phép';
        $this->leaveBalanceSalaryService = $leaveBalanceSalaryService;
    }

    public function index(Request $request)
    {
        $query = LeaveBalanceSalary::query();

        // lọc theo mã nhân viên
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        //lọc theo khoảng ngày
        if ($request->filled('date')) {
            $query->whereDate('leave_date', '=', $request->form_date);
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
        $users = User::all();
        $this->responseData['users'] = $users;
        return $this->responseView($this->viewPart . '.create', $this->responseData);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|string',
            'total_leave' => 'required|integer',
            'used_leave' => 'required|integer',
            'remaining_leave' => 'required|integer',
        ]);
        $this->leaveBalanceSalaryService->createOrUpdateLeaveBalanceSalary($request->all());
        return redirect()->route('leave_balance.index')->with('successMessage','Thêm mới thành công');
    }
    public function edit($id)
    {
        $users = User::all();
        $leave_balance = LeaveBalanceSalary::findOrFail($id);
        $this->responseData['users'] = $users;
        $this->responseData['leave_balance'] = $leave_balance;
        return $this->responseView($this->viewPart . '.edit', $this->responseData);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|string',
            'total_leave' => 'required|integer',
            'used_leave' => 'required|integer',
            'remaining_leave' => 'required|integer',
        ]);
        $this->leaveBalanceSalaryService->createOrUpdateLeaveBalanceSalary($request->all(), $id);
        return redirect()->route('leave_balance.index')->with('successMessage','Sửa thành công');
    }
    public function destroy($id)
    {
        $leave_balance = LeaveBalanceSalary::findOrFail($id);
        $leave_balance->delete();
        return redirect('leave_balance.index')->with('successMessage','Xóa thành công');
    }
}
