<?php

namespace App\Http\Services;

use App\Models\Admin;
use App\Models\Payroll;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PayrollService
{
    // --- IMPORT EXCEL ---
    public function importFormExcel($file)
    {
        $data = Excel::toArray(null, $file);
        foreach ($data[0] as $key => $row) {
            if ($key === 0) continue;

            $employee = Admin::with('salaryPayments', 'attendances', 'leaveRequests')->find($row[0]);
            if (!$employee) continue;

            $calculated = $this->calculatePayrollFields($employee, $row);

            Payroll::updateOrCreate(
                ['employee_id' => $row[0], 'month' => $row[1]],
                $calculated
            );
        }
    }

    // --- HÀM TÍNH TOÁN CHUNG ---
    protected function calculatePayrollFields(Admin $employee, array $row = [])
    {
        // Lấy thông tin cơ bản theo tháng
        $month = $row['month'] ?? $row[1] ?? null;
        if (!$month) {
            throw new \Exception('Month is required for payroll calculation');
        }

        try {
            // ép string -> Carbon
            $monthCarbon = Carbon::parse($month);
        } catch (\Exception $e) {
            throw new \Exception('Invalid month format, expected YYYY-MM-DD');
        }

        $allWorkDays = $employee->attendances()
            ->whereMonth('check_in', $monthCarbon->month)
            ->orderByDesc('id')
            ->value('standard_working_days') ?? 1;
        $baseSalary = $employee->salaryPayments()->orderByDesc('id')->value('base_salary') ?? 0;
        $officialDays = $employee->attendances()
            ->whereMonth('check_in', $monthCarbon->month)
            ->orderByDesc('id')->value('official_days') ?? 0;

        $leaveRequests = $employee->leaveRequests()
            ->where('status', 'approved')
            ->where('leave_type', 'paid')
            ->where(function ($q) use ($monthCarbon) {
                // Chọn những đơn có khoảng nghỉ giao với tháng đang tính
                $q->whereMonth('leave_date_start', $monthCarbon->month)
                    ->whereYear('leave_date_start', $monthCarbon->year)
                    ->orWhereMonth('leave_date_end', $monthCarbon->month)
                    ->orWhereYear('leave_date_end', $monthCarbon->year);
            })
            ->get();

        foreach ($leaveRequests as $leave) {
            $start = Carbon::parse($leave->leave_date_start);
            $end   = Carbon::parse($leave->leave_date_end);

            // Nếu đơn nghỉ kéo dài sang tháng khác thì cắt khoảng ngày thuộc tháng cần tính
            $startOfMonth = $monthCarbon->copy()->startOfMonth();
            $endOfMonth   = $monthCarbon->copy()->endOfMonth();

            if ($start < $startOfMonth) {
                $start = $startOfMonth;
            }
            if ($end > $endOfMonth) {
                $end = $endOfMonth;
            }

            $days = $start->diffInDays($end) + 1;
            $officialDays += $days;
        }

        $baseSalaryByDays = $baseSalary * $officialDays / $allWorkDays;

        // Các khoản thu nhập
        $competency_salary = $employee->salaryPayments()->orderByDesc('id')->value('competency_salary') ?? 0;
        $performance_salary = $employee->salaryPayments()->orderByDesc('id')->value('performance_salary') ?? 0;

        // Các khoản bổ sung từ Excel nếu có
        $late_sat_cost = $row[4] ?? 0;
        $travel_phone_ticket = $row[5] ?? 0;
        $multitask_allowance = $row[6] ?? 0;
        $saturday_meal_support = $row[7] ?? 0;
        $business_bonus = $row[8] ?? 0;
        $handover_support = $row[9] ?? 0;
        $adjustment = $row[10] ?? 0;
        $other_deductions = $row[19] ?? 0;
        $advance_payment = $row[21] ?? 0;

        $subtotal_Income = $baseSalaryByDays + $competency_salary + $performance_salary
            + $late_sat_cost + $travel_phone_ticket + $multitask_allowance
            + $saturday_meal_support + $business_bonus + $handover_support + $adjustment;

        $non_Taxable_Income = $late_sat_cost + $travel_phone_ticket + $saturday_meal_support;

        // Giảm trừ gia cảnh
        $Dependents = $employee->dependents ?? 0;
        $personal_Deduction = 11000000 + ($Dependents * 4400000);

        // BHXH và quỹ công đoàn
        $social_Insurance_Salary = $employee->salaryPayments()->orderByDesc('id')->value('social_insurance_salary') ?? 0;
        $union_Fee = $social_Insurance_Salary * 0.01;
        $social_Insurance = $social_Insurance_Salary * 0.105;

        // Thu nhập chịu thuế
        $taxable_Income = $subtotal_Income - $non_Taxable_Income;
        $taxable_Base = max(0, $taxable_Income - $personal_Deduction);
        $income_Tax = $this->calculatePersonalIncomeTax($taxable_Base);

        // Tổng khấu trừ
        $total_deductions = $union_Fee + $social_Insurance + $income_Tax + $other_deductions;

        // Lương thực lĩnh
        $net_income = $subtotal_Income - $total_deductions - $advance_payment;

        return [
            'base_salary_by_days' => $baseSalaryByDays,
            'subtotal_income' => $subtotal_Income,
            'late_sat_cost' => $late_sat_cost,
            'travel_phone_ticket' => $travel_phone_ticket,
            'multitask_allowance' => $multitask_allowance,
            'saturday_meal_support' => $saturday_meal_support,
            'business_bonus' => $business_bonus,
            'handover_support' => $handover_support,
            'adjustment' => $adjustment,
            'total_income' => $subtotal_Income,
            'non_taxable_income' => $non_Taxable_Income,
            'taxable_income' => $taxable_Income,
            'personal_deduction' => $personal_Deduction,
            'taxable_base' => $taxable_Base,
            'union_fee' => $union_Fee,
            'social_insurance' => $social_Insurance,
            'income_tax' => $income_Tax,
            'other_deductions' => $other_deductions,
            'total_deductions' => $total_deductions,
            'advance_payment' => $advance_payment,
            'net_income' => $net_income,
        ];
    }

    // --- HÀM THUẾ ---
    public function calculatePersonalIncomeTax($taxable_Base)
    {
        if ($taxable_Base <= 5000000) {
            return $taxable_Base * 0.05;
        } elseif ($taxable_Base <= 10000000) {
            return $taxable_Base * 0.1 - 250000;
        } elseif ($taxable_Base <= 18000000) {
            return $taxable_Base * 0.15 - 750000;
        } elseif ($taxable_Base <= 32000000) {
            return $taxable_Base * 0.2 - 1650000;
        } elseif ($taxable_Base <= 52000000) {
            return $taxable_Base * 0.25 - 3250000;
        } elseif ($taxable_Base <= 80000000) {
            return $taxable_Base * 0.3 - 5850000;
        } else {
            return $taxable_Base * 0.35 - 9850000;
        }
    }

    // --- CREATE / UPDATE THỦ CÔNG ---
    public function createOrUpdatePayroll(array $data, $id = null)
    {
        $employee = Admin::with('salaryPayments', 'attendances', 'leaveRequests')->find($data['employee_id']);
        if (!$employee) {
            throw new \Exception("Employee not found");
        }

        $calculated = $this->calculatePayrollFields($employee, $data);

        if ($id) {
            // Update bản ghi theo id
            $payroll = Payroll::findOrFail($id);
            $payroll->update(array_merge($data, $calculated));
            return $payroll;
        } else {
            // Create mới
            return Payroll::create(array_merge($data, $calculated));
        }
    }


    public function deletePayroll(int $id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
    }
}
