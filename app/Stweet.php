<?php

namespace App;
use App\TwitterProfile;


use Illuminate\Database\Eloquent\Model;

class Stweet extends Model
{
    protected $guarded = [];

    /**
     * Convert the created_at to user's timezone.
     *
     * @param  string  $value
     * @return void
     */
    public function setCreatedAtAttribute($value)
    {
        $user = \Auth::user();
        $this->attributes['created_at'] = $value->timezone($user->timezone)->toDateTimeString();
    }



    public function twitter_profile()
    {
        return $this->belongsTo(TwitterProfile::class);
    }

}
