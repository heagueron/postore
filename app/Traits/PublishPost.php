<?php namespace App\Traits;

use finfo;
use App\Spost;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\ApiConnectors\TwitterGateway;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Storage;

trait PublishPost
{
    protected $mediaIds;
    protected $profileIds;
    protected $mediaIdsList;

    /**
     * Publish the post.
     *
     * @param  Spost $spost, array $ids
     * @return void
     */
    public function publishTwitter(Spost $spost, $ids)
    {   
        $this->mediaIds     = [];
        $this->profileIds   = $ids;
        //$this->mediaIdsList = null;

        // Check and register media files
        if( !is_null($spost->media_1) || !is_null($spost->media_2) || !is_null($spost->media_3) || !is_null($spost->media_4) ){
            $this->checkRegisterMedia($spost);
            $this->mediaIdsList = implode(',', $this->mediaIds);
        }

        // Post with TwitterOAuth library
        foreach( $this->profileIds as $key => $value){

            $twitter = new TwitterGateway( $value, false);

            $response = $twitter->connection->post(
                "statuses/update",
                [
                    "status"    => $spost->text,
                    "media_ids" => $this->mediaIdsList 
                ]
            );
            $spost->twitter_profiles()->syncWithoutDetaching([
                $value => [ 'twitter_status_id' => $response->id ]
            ]);              
        }

        // Post with TwitterAPIExchange library
        // Send the post
        // $url = 'https://api.twitter.com/1.1/statuses/update.json';
        // $requestMethod = 'POST';

        // $postfields = array(
        //     "status"    => $spost->text,
        //     "media_ids" => $mediaIdsList
        // );

        // foreach( $this->profileIds as $key => $value){
        //     $twitter = new TwitterGateway($value);           
        //     $response = $twitter->connection
        //         ->buildOauth($url, $requestMethod)
        //         ->setPostfields($postfields)
        //         ->performRequest();           
        //     $decodedResponse = json_decode($response, true);
        //     if ( !array_key_exists("errors",$decodedResponse) ) 
        //     {   
        //         // Tweet posted succesfully
        //         // dd("posted succesfully", $decodedResponse );
                
        //         // Attach twitter status id in pivot table 'spost_twitter_profile'
        //         $spost->twitter_profiles()->syncWithoutDetaching([
        //             $value => [ 'twitter_status_id' => $decodedResponse['id'] ]
        //         ]);              
        //     } 
        //     else 
        //     {   // TODO: handle error.
        //         dd("Tweet not published. Contact site administration", $decodedResponse);
        //     }   
        // }
        
        $spost->update([
            'posted'                => true,
        ]);
        //dd($this->mediaIds, $mediaIdsList);
    }

    private function checkRegisterMedia($spost)
    {
        //dd(  request()->file(asset('storage/' . $spost->media_1)), request()->media_1 );

        // Build the twitter connection class
        $twitter = new TwitterGateway( $this->profileIds[0], false);

        if( Storage::exists( 'public/' . $spost->media_1 )){
            $response = $twitter->connection
                ->upload( 'media/upload', ['media' => 'C:\Users\USUARIO\laravel\postore\public\storage\uploads\6ByMWXLeFe2E4kxbV8OB8TfZ76Poaw8MXG76cuxw.jpeg' ] );
            array_push( $this->mediaIds, $response->media_id );  
        } 

        if( Storage::exists( 'public/' . $spost->media_2 )){
            $response = $twitter->connection
                ->upload( 'media/upload', ['media' =>  asset('storage/' . $spost->media_1) ] );
            array_push( $this->mediaIds, $response->media_id );  
        }




        // if ( !is_null($spost->media_1) ) { 
        //     //dd( asset('storage/' . $spost->media_1) );
        //     $response = $twitter->connection
        //         ->upload( 'media/upload', ['media' => request()->media_1 ] );
        //     array_push( $this->mediaIds, $response->media_id );
        // }
        // if ( !is_null($spost->media_2) ) { 
        //     $response = $twitter->connection
        //         ->upload( 'media/upload', ['media' => request()->media_2 ] );
        //     array_push( $this->mediaIds, $response->media_id );
        // }
        // if ( !is_null($spost->media_3) ) { 
        //     $response = $twitter->connection
        //         ->upload( 'media/upload', ['media' => request()->media_3 ] );
        //     array_push( $this->mediaIds, $response->media_id );
        // }
        // if ( !is_null($spost->media_4) ) { 
        //     $response = $twitter->connection
        //         ->upload( 'media/upload', ['media' => request()->media_4 ] );
        //     array_push( $this->mediaIds, $response->media_id );
        // }
        // TODO: request()->media_x should be replaced when dispatching scheduled ...storage
    }

 

    
}