<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'subadmin_id', 'name', 'designation', 'phone', 'profile_image', 
        'about', 'achievements', 'objective', 'facebook_link', 
        'twitter_link', 'google_link', 'linkedin_link', 'short_description',
        'points',
    ];

    // রিলেশনশিপ: এই প্রোফাইলটি কোন সাব-অ্যাডমিনের তা জানার জন্য
    public function loginInfo()
    {
        return $this->belongsTo(Subadmin::class, 'subadmin_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }

    public function subadmin()
{
    // টিচার টেবিলের 'subadmin_id' এর সাথে 'subadmins' টেবিলের 'id' এর সম্পর্ক
    return $this->belongsTo(Subadmin::class, 'subadmin_id', 'id');
}
}

