<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subadmin()
{
    return $this->belongsTo(Subadmin::class, 'subadmin_id');
}
    

    protected $fillable = [
        'name',
        'phone',
        'dob',
        'blood',
        'profile_image', // এই কলামটি অবশ্যই থাকতে হবে
        'facebook_link'
    ];
}
