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

        $request_token =  $twitter->connection->oauth(
            "oauth/request_token",
            ["oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%"]
        );

        if ($twitter->connection->getLastHttpCode() == 200) {
            // Got request token
            dd($request_token);
            return view('twitter_profiles.create', compact('user', 'request_token'));
        } else {
            return redirect('/home')->with('message', 'Error in token request' );
        }



        /* CRUDE */
        // $url = 'https://api.twitter.com/oauth/request_token';
        // //$data = array('key1' => 'value1', 'key2' => 'value2');

        // // use key 'http' even if you send the request to https://...
        // $options = array(
        //     'http' => array(
        //         'oauth_nonce'=>"K7hy27JTpKVsgdioLdDfmQQWVLER234AK5BslRsqyw", 
        //         'oauth_callback'=>"http%3A%2F%2F127.0.0.1%3A8000%", 
        //         'oauth_signature_method'=>"HMAC-SHA1", 
        //         'oauth_timestamp'=>"1300228849", 
        //         'oauth_consumer_key'=>"ghe3TkwpJPmXJ2wW2ziz4dcOf", 
        //         'oauth_signature'=>"Pc%2BMLdv028fxCErFyi8KXFM%2BddU%3D", 
        //         'oauth_version'=>"1.0",
        //         //'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        //         //'method'  => 'POST',
        //         //'content' => http_build_query($data)
        //     )
        // );
        // $context  = stream_context_create($options);
        // $result = file_get_contents($url, false, $context);
        // if ($result === FALSE) { /* Handle error */ }

        // dd($result);
        /* ENDCRUDE */


    }

}

    // https%3A%2F%2Fpostore.herokuapp.com%
    // https%3A%2F%2Fpostore.herokuapp.com%2Ftwitter_profiles%2Fcreate%
    // http%3A%2F%2F127.0.0.1%3A8000%
    // http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2Fcreate%
