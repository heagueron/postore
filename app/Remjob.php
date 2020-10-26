<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remjob extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(\App\Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'remjob_tag')
            ->withTimestamps();
    }

}
