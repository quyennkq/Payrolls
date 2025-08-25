<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    protected $table = 'salary_payment';
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'employee_id', 'id');
    }
    protected $fillable = [
        'employee_id',
        'base_salary',
        'competency_salary',
        'performance_salary',
        'position_income',
        'social_insurance_salary',
    ];
}
