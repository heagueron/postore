<?php namespace App\Traits;

use App\Spost;
use App\ApiConnectors\TwitterGateway;

trait PublishPost
{
    public function publishTwitter(Spost $spost, $ids)
    {   //dd('spost ids: ',$spost->text, $ids);
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
        }
        
        $spost->update([
            'posted'                => true,
        ]);
    }


}