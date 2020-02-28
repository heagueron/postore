<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiConnectors\TwitterGateway;


class TwitterProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(TwitterGateway $twitter)
    {
        $user = \Auth::user();
        dd($user, $twitter);

        // Ask for the Request Token:
        $request_token =  $twitter->connection->oauth("oauth/request_token");

        if ($twitter->connection->getLastHttpCode() == 200) {
            return view('twitter_profiles.create', compact('user', 'request_token'));
        } else {
            return redirect('/home')->with('message', 'Error: No request_token received');
        }    
        
    }
}
