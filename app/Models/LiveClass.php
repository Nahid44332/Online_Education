<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'meeting_link',
        'status', // যদি স্ট্যাটাস কলাম থাকে
    ];
}
