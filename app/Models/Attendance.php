<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'work_hours',
        'standard_working_days',
        'probation_days',
        'official_days',
        'leave_days'
    ];
}
