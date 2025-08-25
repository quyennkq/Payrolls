<?php

namespace App\Http\Services;

use App\Models\LeaveBalanceSalary;
use App\Models\LeaveRequestSalary;
use Carbon\Carbon;

class LeaveRequestService
{
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
     * @return LeaveRequestSalary
     */
    public function createLeaveRequest(array $data)
    {
        $leaveRequest = LeaveRequestSalary::create($data);

        // Update leave balance dựa trên số ngày nghỉ thực tế
        $this->updateLeaveBalance($leaveRequest->employee_id, $leaveRequest);

        return $leaveRequest;
    }

    /**
     * Update the leave balance for an employee.
     *
     * @param int $employeeId
     */
    protected function updateLeaveBalance(int $employeeId, ?LeaveRequestSalary $leaveRequest = null)
    {
        $leaveBalance = LeaveBalanceSalary::where('employee_id', $employeeId)->first();

        if ($leaveBalance && $leaveRequest) {
            $start = Carbon::parse($leaveRequest->leave_date_start);
            $end   = Carbon::parse($leaveRequest->leave_date_end);

            // Số ngày xin nghỉ
            $days = $end->diffInDays($start) + 1;

            if ($days <= $leaveBalance->remaining_leave) {
                // Đủ phép → trừ bình thường
                $leaveBalance->used_leave     += $days;
                $leaveBalance->remaining_leave -= $days;
                $leaveBalance->save();
            } else {
                // Không đủ phép → tách ra
                $paidDays   = $leaveBalance->remaining_leave; // số ngày còn lại
                $unpaidDays = $days - $paidDays;

                // Nếu còn ngày phép thì tạo record "paid"
                if ($paidDays > 0) {
                    $paidEnd = $start->copy()->addDays($paidDays - 1); // ngày cuối phần có phép

                    $leaveBalance->used_leave     += $paidDays;
                    $leaveBalance->remaining_leave = 0;
                    $leaveBalance->save();

                    // Cập nhật lại record gốc thành phần "paid"
                    $leaveRequest->update([
                        'leave_date_start' => $start,
                        'leave_date_end'   => $paidEnd,
                        'leave_type'       => 'paid',
                    ]);

                    // Tạo thêm record unpaid cho phần dư
                    LeaveRequestSalary::create([
                        'employee_id'      => $employeeId,
                        'leave_date_start' => $paidEnd->copy()->addDay(), // ngày sau ngày cuối của paid
                        'leave_date_end'   => $end,
                        'leave_type'       => 'unpaid',
                        'reason'           => $leaveRequest->reason,
                        'status'           => $leaveRequest->status,
                    ]);
                } else {
                    // Không còn ngày phép nào → toàn bộ là unpaid
                    $leaveRequest->update(['leave_type' => 'unpaid']);
                }
            }
        }
    }
}
