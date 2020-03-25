<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Stweet;


class TwitterProfile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stweets()
    {
        return $this->hasMany(Stweet::class);
    }

    public function sposts()
    {
        return $this->belongsToMany('App\Spost','spost_twitter_profile')->withTimestamps();
    }
    
}
