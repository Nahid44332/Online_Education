<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'course_id', 'id');
    }

}
