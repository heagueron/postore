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
    public function getHighlightYellowAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

    /**
     * front_page_2w.
     *
     * @param  string  $value
     * @return string
     */
    public function getFrontPage2wAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

    /**
     * front_category_2w.
     *
     * @param  string  $value
     * @return string
     */
    public function getFrontCategory2wAttribute($value)
    {
        return $value == 'on' ? 1 : 0;
    }

}
