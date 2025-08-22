<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $table = 'tb_health';
    protected $fillable = ['height', 'weight', 'health_rate', 'blood_pressure'];

    // Mối quan hệ với bảng Student

    public function tb_students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
