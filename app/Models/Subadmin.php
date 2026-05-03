<?php

namespace App\Models;

// এই নিচের লাইনগুলো ঠিকভাবে থাকা জরুরি
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subadmin extends Authenticatable // এখানে Model এর বদলে Authenticatable হবে
{
    use HasFactory, Notifiable;

    protected $table = 'subadmins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // টিচার প্রোফাইলের সাথে রিলেশন
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'subadmin_id', 'id');
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'subadmin_id', 'id');
    }

    public function helpline()
    {
        return $this->hasOne(Helpline::class, 'subadmin_id', 'id');
    }

    // Counsellor প্রোফাইলের সাথে রিলেশন
    public function counsellor()
    {
        return $this->hasOne(Counsellor::class, 'subadmin_id', 'id');
    }

    public function manager()
    {
        return $this->hasOne(Manager::class, 'subadmin_id', 'id');
    }
}
