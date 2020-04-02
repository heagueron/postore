<?php namespace App\Traits;

use App\Spost;
use App\ApiConnectors\TwitterGateway;
use Abraham\TwitterOAuth\TwitterOAuth;


trait PublishPost
{
    protected $mediaIds = [];
    protected $profileIds = [];

    public function publishTwitter(Spost $spost, $ids)
    {   
        $this->profileIds = $ids;

        // Check and register media files
        $this->checkRegisterMedia($spost);

        // Send the post
        $url = 'https://api.twitter.com/1.1/statuses/update.json';
        $requestMethod = 'POST';

        $postfields = array(
            "status"        => $spost->text,
        );

        foreach( $this->profileIds as $key => $value){

            $twitter = new TwitterGateway($value);
            
            $response = $twitter->connection
                ->buildOauth($url, $requestMethod)
                ->setPostfields($postfields)
                ->performRequest();
            
            $decodedResponse = json_decode($response, true);

            if ( !array_key_exists("errors",$decodedResponse) ) 
            {   
                // Tweet posted succesfully
                // dd("posted succesfully", $decodedResponse );
                
                // Attach twitter status id in pivot table 'spost_twitter_profile'
                $spost->twitter_profiles()->syncWithoutDetaching([
                    $value => [ 'twitter_status_id' => $decodedResponse['id'] ]
                ]);
                
            } 
            else 
            {   // TODO: handle error.
                dd("Tweet not published. Contact site administration", $decodedResponse);
            }
    
        }
        
        $spost->update([
            'posted'                => true,
        ]);
        
    }

    private function checkRegisterMedia($spost)
    {
        // Build the twitter connection class
        $url = 'https://upload.twitter.com/1.1/media/upload.json';
        $requestMethod = 'POST';

        // Use first profile, then will authorize others for the media
        $twitter = new TwitterGateway( $this->profileIds[0] );

        if ( !is_null( request()->media_1 )) {
            $this->registerMedia( $twitter, $requestMethod, $url, $spost);
        }
        if ( !is_null( request()->media_2 )) {
            $this->registerMedia( $twitter, $requestMethod, $url, request()->media_2);
        }
        if ( !is_null( request()->media_3 )) {
            $this->registerMedia( $twitter, $requestMethod, $url, request()->media_3);
        }
        if ( !is_null( request()->media_4 )) {
            $this->registerMedia( $twitter, $requestMethod, $url, request()->media_4);
        }

    }

    private function registerMedia($twitter, $requestMethod, $url, $spost)
    {
        $connection = new TwitterOAuth(
            config('ttwitter.CONSUMER_KEY'), 
            config('ttwitter.CONSUMER_SECRET'), 
            config('ttwitter.ACCESS_TOKEN'), 
            config('ttwitter.ACCESS_TOKEN_SECRET')
        );

        $media1Response = $connection->upload(
            'media/upload', 
            ['media' => request()->media_1 ]
        );
        dd('media1Response: ', $media1Response);

        $postfields = array(
            "media"         => $media,
            "command"       => "INIT",
            "total_bytes"   => filesize( $media ),
            "media_type"    => 'image/' . $media->extension()
        );
        
        
        $response = $twitter->connection
            ->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();

        
        $decodedResponse = json_decode($response, true);
        
        if ( !array_key_exists("errors",$decodedResponse) ) 
        {
            dd("success registering", $decodedResponse );
        } 
        else 
        {   // TODO: handle error.
            dd("failed registering", $decodedResponse);
        }

    }
    
}