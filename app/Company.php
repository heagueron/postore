<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function remjobs()
    {
        return $this->hasMany(\App\Remjob::class);
    }
    
}
