<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class LeaveRequestSalary extends Model
{
    protected $table = 'leave_request';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'employee_id', 'id');
    }
    protected $fillable = ['employee_id', 'leave_date_start','leave_date_end', 'leave_type', 'reason', 'status'];
}
