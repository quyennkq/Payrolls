<?php
namespace App\Http\Services;
use App\Models\LeaveBalanceSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveBalanceSalaryService{

    public function createOrUpdateLeaveBalanceSalary(array $data, $id = null)
    {
        if ($id) {
            $leave_balance = LeaveBalanceSalary::findOrFail($id);
            $leave_balance->update($data);
            return $leave_balance;
        }

        return LeaveBalanceSalary::create($data);
    }

    public function filter(Request $request)
    {
        $query = LeaveBalanceSalary::query();

        // lọc theo mã nhân viên
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('updated_at', $month->month)
                ->whereYear('updated_at', $month->year);
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
        return $query->paginate(10);
    }
}
