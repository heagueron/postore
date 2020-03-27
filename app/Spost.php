<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spost extends Model
{
    protected $guarded = [];

    /**
     * Convert the created_at to user's timezone.
     *
     * @param  string  $value
     * @return void
     */
    // public function setCreatedAtAttribute($value)
    // {
    //     $user = \Auth::user();
    //     $this->attributes['created_at'] = $value->timezone($user->timezone)->toDateTimeString();
    // }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function twitter_profiles()
    {
        return $this->belongsToMany('App\TwitterProfile', 'spost_twitter_profile')
            ->withPivot(['twitter_status_id'])
            ->withTimestamps();
    }

}
