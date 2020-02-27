<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterProfileController extends Controller
{
    public function create()
    {
        $user = \Auth::user();
        return view('stweets.create', compact('user'));
    }
}
