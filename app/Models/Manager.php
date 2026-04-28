<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function manager()
    {
        return $this->hasOne(Manager::class, 'subadmin_id', 'id');
    }
}
