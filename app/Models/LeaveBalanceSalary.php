<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalanceSalary extends Model
{
    protected $table = 'leave_balance';
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'total_leave',
        'used_leave',
        'remaining_leave',
    ];
    public function nghiPhep() {
        return $this->hasMany(LeaveBalance::class, 'employee_id', 'employee_id');
    }
}
