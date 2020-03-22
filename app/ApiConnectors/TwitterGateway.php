<?php

namespace App\ApiConnectors;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\ApiConnectors\TwitterAPIExchange;


class TwitterGateway extends TwitterAPIExchange
{
    public $connection;

    public function __construct()
    {
        $this->connection = new TwitterAPIExchange( $this->get_tweeter_keys() );
    }

    public function get_tweeter_keys()
    {
        $user = \Auth::user();

        if( empty($user) ){ 
            dd('Trying to create TwitterGateway in AUTO mode, no user authed');
        };

        /*****************************************
         * ADMIN Keys
         *
         ******************************************/

        if( $user->email == 'heagueron@gmail.com')
        {
            return array(
                'oauth_access_token' => config('ttwitter.ACCESS_TOKEN'),
                'oauth_access_token_secret' => config('ttwitter.ACCESS_TOKEN_SECRET'),
                'consumer_key' => config('ttwitter.CONSUMER_KEY'),
                'consumer_secret' => config('ttwitter.CONSUMER_SECRET')
            );
        }

        /*****************************************
         * CLIENT Keys
         *
         ******************************************/

        else if ( !empty($user->twitter_profiles->all() )){

            $twitter_profile = $user->twitter_profiles->first();

            return array(
                'oauth_access_token' => $twitter_profile->access_token,
                'oauth_access_token_secret' => $twitter_profile->access_token_secret,
                'consumer_key' => config('ttwitter.CONSUMER_KEY'),
                'consumer_secret' => config('ttwitter.CONSUMER_SECRET')
            );

        }
        
        // Client user is trying to build a twitter_profile
        return array(
            'oauth_access_token' => config('ttwitter.ACCESS_TOKEN'),
            'oauth_access_token_secret' => config('ttwitter.ACCESS_TOKEN_SECRET'),
            'consumer_key' => config('ttwitter.CONSUMER_KEY'),
            'consumer_secret' => config('ttwitter.CONSUMER_SECRET')
        );
        
    }

}
