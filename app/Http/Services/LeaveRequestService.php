<?php
namespace App\Http\Services;

use App\Models\LeaveBalanceSalary;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestSalary;
use App\Models\SalaryPayment;
use Maatwebsite\Excel\Facades\Excel;

class LeaveRequestService{

    public function createOrUpdateLeaveRequest(array $data, $id = null)
    {
        if ($id) {
            $leave_request = LeaveRequestSalary::findOrFail($id);
            $leave_request->update($data);
            return $leave_request;
        }

        return LeaveRequestSalary::create($data);
    }

    /**
     * Handle the creation of a new leave request.
     *
     * @param array $data
     * @return leave_requests
     */
    public function createLeaveRequest(array $data)
    {
        $leaveRequest = LeaveRequestSalary::create($data);

        // Update leave balance after creating a leave request
        $this->updateLeaveBalance($leaveRequest->employee_id);

        return $leaveRequest;
    }

    /**
     * Update the leave balance for an employee.
     *
     * @param int $employeeId
     */
    protected function updateLeaveBalance(int $employeeId)
    {
        $leaveBalance = LeaveBalanceSalary::where('employee_id', $employeeId)->first();
        if ($leaveBalance) {
            $leaveBalance->used_leave += 1;
            $leaveBalance->remaining_leave -= 1;
            $leaveBalance->save();
        }
    }
}
