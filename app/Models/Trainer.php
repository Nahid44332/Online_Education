<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subadmin()
    {
        return $this->belongsTo(Subadmin::class, 'subadmin_id');
    }

    public function teamLeader()
{
    return $this->belongsTo(TeamLeader::class, 'team_leader_id');
}
}
