<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remjob extends Model
{
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(\App\Company::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Category::class);
    }

    public function plan()
    {
        return $this->belongsTo(\App\Plan::class);
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'remjob_tag')
            ->withTimestamps();
    }

    public function twitterPosts()
    {
        return $this->hasMany('App\TwitterPost');
    }

    

}
