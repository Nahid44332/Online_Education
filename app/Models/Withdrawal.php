<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'amount', 'method', 'account_details', 'status'];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function subadmin()
    {
        return $this->belongsTo(Subadmin::class, 'subadmin_id');
    }

    // টিম লিডার রিলেশন
    public function team_leader() {
        return $this->belongsTo(Subadmin::class, 'team_leader_id');
    }

    // ট্রেইনার রিলেশন
    public function trainer() {
        return $this->belongsTo(Subadmin::class, 'trainer_id');
    }

    // হেল্পলাইন রিলেশন
    public function helpline() {
        return $this->belongsTo(Subadmin::class, 'helpline_id');
    }

    // কাউন্সিলর রিলেশন
    public function counsellor() {
        return $this->belongsTo(Subadmin::class, 'counsellor_id');
    }
}
