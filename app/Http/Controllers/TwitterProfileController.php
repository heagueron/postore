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
        // dd($user, $twitter);

        // Ask for the Request Token:
        try {

            $request_token =  $twitter->connection->oauth(
                "oauth/request_token",
                ["oauth_callback" => "https%3A%2F%2Fpostore.herokuapp.com%2F"]
            );
            
            return view('twitter_profiles.create', compact('user', 'request_token'));

        } catch (Exception $e) {
            return redirect('/home')->with('message', $e->getMessage() );
        }

    }

    // https%3A%2F%2Fpostore.herokuapp.com%2Ftwitter_profiles%2Fcreate

}
