<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = [];

    public function remjobs()
    {
        return $this->hasMany(\App\Remjob::class);
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
