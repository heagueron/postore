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
        $this->belongsTo(User::class);
    }

    public function stweets()
    {
        $this->hasMany(Stweet::class);
    }
    
}
