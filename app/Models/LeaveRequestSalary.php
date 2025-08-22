<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class LeaveRequestSalary extends Model
{
    protected $table = 'leave_request';

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
    protected $fillable = ['employee_id', 'leave_date', 'leave_type', 'reason', 'status'];
}
