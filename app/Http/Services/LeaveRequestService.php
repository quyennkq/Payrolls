<?php

namespace App\Http\Services;

use App\Models\LeaveBalanceSalary;
use App\Models\LeaveRequestSalary;
use Carbon\Carbon;

class LeaveRequestService
{
    // public function createOrUpdateLeaveRequest(array $data, $id = null)
    // {
    //     if ($id) {
    //         $leave_request = LeaveRequestSalary::findOrFail($id);
    //         $leave_request->update($data);
    //         return $leave_request;
    //     }

    //     return LeaveRequestSalary::create($data);
    // }

    /**
     * Handle the creation of a new leave request.
     *
     * @param array $data
     * @return LeaveRequestSalary
     */
    public function createOrUpdateLeaveRequest(array $data, $id = null)
    {
        if ($id) {
            $leaveRequest = LeaveRequestSalary::findOrFail($id);

            // 1. Tính số ngày nghỉ cũ
            $oldStart = Carbon::parse($leaveRequest->leave_date_start);
            $oldEnd   = Carbon::parse($leaveRequest->leave_date_end);
            $oldDays  = $oldEnd->diffInDays($oldStart) + 1;

            // 2. Update request
            $leaveRequest->update($data);

            // 3. Tính số ngày nghỉ mới
            $newStart = Carbon::parse($leaveRequest->leave_date_start);
            $newEnd   = Carbon::parse($leaveRequest->leave_date_end);
            $newDays  = $newEnd->diffInDays($newStart) + 1;

            // 4. Cập nhật lại leave balance dựa trên chênh lệch
            $this->adjustLeaveBalance($leaveRequest->employee_id, $oldDays, $newDays, $leaveRequest);

            return $leaveRequest;
        }


        // Trường hợp tạo mới
        $leaveRequest = LeaveRequestSalary::create($data);
        $this->updateLeaveBalance($leaveRequest->employee_id, $leaveRequest);

        return $leaveRequest;
    }

    protected function adjustLeaveBalance(int $employeeId, int $oldDays, int $newDays, LeaveRequestSalary $leaveRequest)
    {
        $leaveBalance = LeaveBalanceSalary::where('employee_id', $employeeId)->first();

        if (!$leaveBalance) {
            return;
        }

        $diff = $newDays - $oldDays;

        if ($diff > 0) {
            // Tăng số ngày nghỉ → trừ thêm
            $leaveBalance->used_leave += $diff;
            $leaveBalance->remaining_leave = max(0, $leaveBalance->remaining_leave - $diff);
        } elseif ($diff < 0) {
            // Giảm số ngày nghỉ → cộng lại số dư
            $leaveBalance->used_leave += $diff; // diff < 0 nên sẽ trừ đi
            $leaveBalance->remaining_leave -= $diff; // diff < 0 nên sẽ cộng lại
        }

        $leaveBalance->save();
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
                $leaveBalance->used_leave += $days;
                $leaveBalance->remaining_leave -= $days;
                $leaveBalance->save();
            } else {
                // Không đủ phép → tách ra
                $paidDays   = $leaveBalance->remaining_leave; // số ngày còn lại
                $unpaidDays = $days - $paidDays;

                // Nếu còn ngày phép thì tạo record "paid"
                if ($paidDays > 0) {
                    $paidEnd = $start->copy()->addDays($paidDays - 1); // ngày cuối phần có phép

                    $leaveBalance->used_leave += $paidDays;
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
