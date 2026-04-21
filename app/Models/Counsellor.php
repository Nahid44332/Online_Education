<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counsellor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subadmin()
    {
        return $this->belongsTo(Subadmin::class, 'subadmin_id', 'id');
    }
}
