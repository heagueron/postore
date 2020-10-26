<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    
    public function remjobs()
    {
        return $this->belongsToMany('App\Remjob', 'remjob_tag')
            ->withTimestamps();
    }
}
