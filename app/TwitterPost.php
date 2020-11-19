<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterPost extends Model
{
    protected $guarded = [];

    public function remjob()
    {
        return $this->belongsTo(\App\Remjob::class);
    }

}
