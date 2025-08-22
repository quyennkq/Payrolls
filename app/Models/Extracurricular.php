<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $table = 'extracurricular';
    protected $fillable = ['id','name', 'description', 'first_date', 'last_date','start_time','end_time','location','form_participation','form_organizational', 'expense'];
    public function tb_students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
