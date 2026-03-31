<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- এখানে
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guard = 'student';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id'); 
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function getTotalPaidAttribute() {
        return $this->payments->sum('amount');
    }

    public function getDueAmountAttribute() {
        return $this->total_fee - $this->total_paid;
    }

    public function admitCards()
    {
        return $this->hasMany(AdmitCard::class, 'student_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(Student::class, 'student_id', 'id');
    }

    public function lock()
    {
        return $this->hasOne(Lock::class, 'student_id');
    }
}