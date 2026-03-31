<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    
    protected $guarded = [];

      // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

      public function result()
    {
        return $this->hasOne(Result::class, 'student_id', 'student_id');
    }

}
