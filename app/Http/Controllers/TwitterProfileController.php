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

        // Ask for the Request Token:
        $request_token =  $twitter->connection->oauth(
            "oauth/request_token",
            ["oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2Fcreate"]
        );

        if ($twitter->connection->getLastHttpCode() == 200) {
            // Got request token
            dd($request_token);
            return view('twitter_profiles.create', compact('user', 'request_token'));
        } else {
            return redirect('/home')->with('message', 'Error in token request' );
        }


    }

}

    // https%3A%2F%2Fpostore.herokuapp.com
    // https%3A%2F%2Fpostore.herokuapp.com%2Ftwitter_profiles%2Fcreate
    // http%3A%2F%2F127.0.0.1%3A8000
    // http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2Fcreate
