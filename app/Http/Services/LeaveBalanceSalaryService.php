<?php
namespace App\Http\Services;
use App\Models\LeaveBalanceSalary;


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
}
