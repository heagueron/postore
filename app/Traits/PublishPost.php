<?php namespace App\Traits;

use App\Spost;
use App\ApiConnectors\TwitterGateway;

trait PublishPost
{
    public function publishTwitter(Spost $spost, $ids)
    {   dd( request() );
        $url = 'https://api.twitter.com/1.1/statuses/update.json';
        $requestMethod = 'POST';

        $postfields = array(
            "status"        => $spost->text,
        );

        foreach( $ids as $key => $value){

            $twitter = new TwitterGateway($value);
            //dd($url, $requestMethod, $postfields, $value, $twitter);
            $response = $twitter->connection
                ->buildOauth($url, $requestMethod)
                ->setPostfields($postfields)
                ->performRequest();
            
            $decodedResponse = json_decode($response, true);

            // Attach twitter status id in pivot table 'spost_twitter_profile'
            $spost->twitter_profiles()->syncWithoutDetaching([
                $value => [ 'twitter_status_id' => $decodedResponse['id'] ]
            ]);
            
        }
        
        $spost->update([
            'posted'                => true,
        ]);
        
    }
}