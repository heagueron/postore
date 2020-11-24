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

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'remjob_tag')
            ->withTimestamps();
    }

    public function twitterPosts()
    {
        return $this->hasMany('App\TwitterPost');
    }

    // Accesors

    /**
     * show logo.
     *
     * @param  string  $value
     * @return string
     */
    public function getShowLogoAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

    /**
     * highlight_yellow.
     *
     * @param  string  $value
     * @return string
     */
    public function getYellowBackgroundAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

    /**
     * front_page_2w.
     *
     * @param  string  $value
     * @return string
     */
    public function getMainFrontPageAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

    /**
     * front_category_2w.
     *
     * @param  string  $value
     * @return string
     */
    public function getCategoryFrontPageAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

}
