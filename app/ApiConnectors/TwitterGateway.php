<?php

namespace App\ApiConnectors;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\ApiConnectors\TwitterAPIExchange;


class TwitterGateway extends TwitterAPIExchange
{
    public $connection;

    public function __construct( $twitterProfileId=null, $creatingProfile=true )
    {
        if($creatingProfile){
            $this->connection = new TwitterAPIExchange( $this->get_tweeter_credentials( $twitterProfileId ) );
        } else {
            $credentials = $this->get_tweeter_credentials( $twitterProfileId );
            $this->connection = new TwitterOAuth( 
                $credentials['consumer_key'], 
                $credentials['consumer_secret'], 
                $credentials['oauth_access_token'], 
                $credentials['oauth_access_token_secret']  
            );
        }

    }

    public function get_tweeter_credentials( $twitterProfileId=null )
    {
        
        // Sending scheduled or inmediate posts 
        if ( !is_null($twitterProfileId) ){

            $twitter_profile=\App\TwitterProfile::findOrFail($twitterProfileId);
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
