<?php

namespace App;

use App\Remjob;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function remjobs()
    {
        return $this->hasMany(\App\Remjob::class);
    }
    
}
