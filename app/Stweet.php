<?php

namespace App;
use App\TwitterProfile;


use Illuminate\Database\Eloquent\Model;

class Stweet extends Model
{
    protected $guarded = [];

    
    public function twitter_profile()
    {
        $this->belongsTo(TwitterProfile::class);
    }

}
