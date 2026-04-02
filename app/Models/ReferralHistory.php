<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralHistory extends Model
{
    use HasFactory;

     protected $fillable = [
        'student_id',
        'referred_student_id',
        'points',
    ];

    // যে student points পেয়েছে
    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // যে student active হয়েছে
    public function referredStudent() {
        return $this->belongsTo(Student::class, 'referred_student_id');
}
}