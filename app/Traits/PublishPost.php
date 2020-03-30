<?php namespace App\Traits;

use App\Spost;
use App\ApiConnectors\TwitterGateway;

trait PublishPost
{
    protected $mediaIds = [];
    protected $profileIds = [];

    public function publishTwitter(Spost $spost, $ids)
    {   
        $this->profileIds = $ids;

        // Check and register media files
        $this->checkRegisterMedia();

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

            // Attach twitter status id in pivot table 'spost_twitter_profile'
            $spost->twitter_profiles()->syncWithoutDetaching([
                $value => [ 'twitter_status_id' => $decodedResponse['id'] ]
            ]);
            
        }
        
        $spost->update([
            'posted'                => true,
        ]);
        
    }

    private function checkRegisterMedia()
    {
        // Build the twitter connection class
        $url = 'https://upload.twitter.com/1.1/media/upload.json';
        $requestMethod = 'POST';

        // Use first profile, then will authorize others for the media
        $twitter = new TwitterGateway( $this->profileIds[0] );

        if ( !is_null( request()->media_1 )) {
            $this->registerMedia( $twitter, $requestMethod, $url, request()->media_1);
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

    private function registerMedia($twitter, $requestMethod, $url, $media)
    {
        $postfields = array(
            "media"        => $media,
        );
        
        //dd('about to request media id');
        
        $response = $twitter->connection
            ->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();
        
        $decodedResponse = json_decode($response, true);
        dd($decodedResponse);
    }
    
}