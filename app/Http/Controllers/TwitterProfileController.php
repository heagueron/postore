<?php

namespace App\Http\Controllers;

use App\TwitterProfile;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\ApiConnectors\TwitterGateway;

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        // $connection = new TwitterOAuth(
        //     config('ttwitter.CONSUMER_KEY'), 
        //     config('ttwitter.CONSUMER_SECRET'), 
        //     config('ttwitter.ACCESS_TOKEN'), 
        //     config('ttwitter.ACCESS_TOKEN_SECRET')
        // );

        // // $content = $connection->get("account/verify_credentials");
        
        // $access_token = $connection->oauth("oauth/request_token", ["oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2FconvertToken"]);
        // //$resp = $connection->post("oauth/request_token", ["oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2FconvertToken"]);
        // dd('after token request');


        // STEP 1: POST oauth/request_token
        // Create a request for a consumer application to obtain a request token.
        $twitter1 = new TwitterGateway();
        $url = 'https://api.twitter.com/oauth/request_token';
        $requestMethod = 'POST';

        $postfields = array(
            "oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2FconvertToken"
        );

        $response1 = $twitter1->connection
            ->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();

        // Callback confirmation:
        if ( !Str::of($response1)->after('oauth_callback_confirmed=')->exactly('true')  ){
            dd('Callback function not confirmed in Step 1');
        }

        $oauth_token = Str::of($response1)
            ->after('oauth_token=')
            ->before('&oauth_token_secret');
        $oauth_token_secret = Str::of($response1)
            ->after('oauth_token_secret=')
            ->before('&oauth_callback_confirmed');

        // Store them in session:
        session([
            'oauth_token' => $oauth_token, 
            'oauth_token_secret' => $oauth_token_secret
        ]);


        // Step 2: GET oauth/authorize
        // Have the user authenticate, and send the consumer application a request token.
        $twitter2 = new TwitterGateway();
        $url = 'https://api.twitter.com/oauth/authorize';
        $getfield = Str::of('?oauth_token=')->append($oauth_token);
        $requestMethod = 'GET';

        echo $twitter2->connection
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();


    }


    public function convertToken()
    {
        // Check token
        $tokenFromStep2 = request()->oauth_token;
        $oauth_verifier = request()->oauth_verifier;



        if( !session()->get('oauth_token') == $tokenFromStep2 ){
            dd("Token mismatch. Please log out Postore, log in and try again.");
        }
        
        // Step 3: POST oauth/access_token
        // Convert the request token into a usable access token.

        $url = 'https://api.twitter.com/oauth/access_token';
        $requestMethod = 'POST';

        $postfields = array(
            "oauth_token" => $tokenFromStep2,
          "oauth_verifier" => $oauth_verifier
        );

        $twitter3 = new TwitterGateway();
        $response3 = $twitter3->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();
        
        // TODO: use json_decode instead of Str

        $oauth_token = Str::of($response3)
            ->after('oauth_token=')
            ->before('&oauth_token_secret');

        $oauth_token_secret = Str::of($response3)
            ->after('oauth_token_secret=')
            ->before('&user_id');

        $twitter_user_id = Str::of($response3)
            ->after('user_id=')
            ->before('&screen_name');

        $screen_name = Str::of($response3)
            ->after('screen_name=')
            ->before(' ◀');

 
        
        // Create the Twiter Profile
        \App\TwitterProfile::create(
            [
                'handler'               => $screen_name,
                'access_token'          => $oauth_token,
                'access_token_secret'   => $oauth_token_secret,
                'user_id'               => auth()->user()->id,
                'twitter_user_id'       => $twitter_user_id
            ]
        );

        return view('thanks', [
            'message'   => 'Now you can schedule tweets for your profile: ' .  $screen_name,
        ]);
    }

}
