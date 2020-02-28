<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterProfileController extends Controller
{
    public function create(TwitterGateway $twitter)
    {
        $user = \Auth::user();

        // Ask for the Request Token:
        $request_token =  $twitter->connection->oauth("oauth/request_token");

        if ($twitter->connection->getLastHttpCode() == 200) {
            return view('twitter_profiles.create', compact('user', 'request_token'));
        } else {
            return redirect('/home')->with('message', 'Error: No request_token received!');
        }    
        
    }
}
