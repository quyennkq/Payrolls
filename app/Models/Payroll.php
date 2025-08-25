<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll';
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'employee_id', 'id');
    }
    protected $fillable = [
        'employee_id',
        'month',
        'base_salary_by_days',
        'subtotal_income',
        'late_sat_cost',
        'travel_phone_ticket',
        'multitask_allowance',
        'saturday_meal_support',
        'business_bonus',
        'handover_support',
        'adjustment',
        'total_income',
        'non_taxable_income',
        'taxable_income',
        'personal_deduction',
        'taxable_base',
        'union_fee',
        'social_insurance',
        'income_tax',
        'other_deductions',
        'total_deductions',
        'advance_payment',
        'net_income'
    ];
    public function employee()
    {
        return $this->belongsTo(User::class);
    }


    public function setMonthAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['month'] = null;
            return;
        }
        // Payroll.php

        try {
            // Nếu value là số (Excel date serial)
            if (is_numeric($value) && $value > 0) {
                $date = Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                );
            } else {
                // Chuỗi ngày/tháng/năm bất kỳ
                $date = Carbon::parse($value);
            }

            //Lưu thành ngày đầu tháng
            $this->attributes['month'] = $date->startOfMonth()->format('Y-m-d');
        } catch (\Exception $e) {
            $this->attributes['month'] = null;
        }
    }
}
