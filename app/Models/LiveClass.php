<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    use HasFactory;

    protected $guarded = [];

   // এই অংশটুকু নিশ্চিত করুন
    protected $fillable = [
        'course_id', 
        'title', 
        'meeting_link', 
        'status'
    ];
    
    // রিলেশনশিপ (যদি না থাকে যোগ করে নিন)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
