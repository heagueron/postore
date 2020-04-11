<?php namespace App\Traits;

use finfo;
use App\Spost;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\ApiConnectors\TwitterGateway;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

trait PublishPost
{
    protected $mediaIds;
    protected $profileIds;
    protected $mediaIdsList;
    protected $registerMediaResult;
    protected $twitter;

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
        
        // Check and register media files
        // Build the twitter connection class
        $this->twitter = new TwitterGateway( $this->profileIds[0], false);
        //dd($spost,$this->profileIds,$this->twitter);
        if( !is_null( $spost->media_1 ) ){
            if( ! $this->registerMedia( 'public/' . $spost->media_1 ) ) {
                return 'There was a problem uploading your media files. Contact support.';
            } 
        }
        if( !is_null( $spost->media_2 ) ){
            if( ! $this->registerMedia( 'public/' . $spost->media_2 ) ) {
                return 'There was a problem uploading your media files. Contact support.';
            } 
        }
        if( !is_null( $spost->media_3 ) ){
            if( ! $this->registerMedia( 'public/' . $spost->media_3 ) ) {
                return 'There was a problem uploading your media files. Contact support.';
            } 
        }
        if( !is_null( $spost->media_4 ) ){
            if( ! $this->registerMedia( 'public/' . $spost->media_4 ) ) {
                return 'There was a problem uploading your media files. Contact support.';
            } 
        }
        $this->mediaIdsList = implode(',', $this->mediaIds);

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
            //dd('$response: ',$response);

            if ( $twitter->connection->getLastHttpCode() == 200 ) {
                // Success
                $spost->twitter_profiles()->syncWithoutDetaching([
                    $value => [ 'twitter_status_id' => $response->id ]
                ]); 

            } else {
                // Failure
                $twitter_profile = \App\TwitterProfile::findOrFail($value);
                return 'Your account @' .$twitter_profile->handler. ' is probably not authorized. Contact support.';
            }
                         
        }
        
        $spost->update([
            'posted'                => true,
        ]);

        return 'success';

    }


    public function registerMedia($media){

        $strFile = Storage::get( $media );
        $response = $this->twitter->connection
                ->upload( 'media/upload', [ 'media' => $strFile ] );

        //dd($response);
        if ( $this->twitter->connection->getLastHttpCode() == 200 ) {
            array_push( $this->mediaIds, $response->media_id );
            return  true;
        } else { 
            return false;
        }

    }



    // private function checkRegisterMedia($spost)
    // {
    //     // Build the twitter connection class
    //     $twitter = new TwitterGateway( $this->profileIds[0], false);

    //     // Media 1
    //     if( !is_null( $spost->media_1 ) ){

    //         $media1 = Storage::get( 'public/' . $spost->media_1 );

    //         $response = $twitter->connection
    //             ->upload( 'media/upload', [ 'media' => $media1 ] );

    //         if ( $twitter->connection->getLastHttpCode() == 200 ) {
    //             array_push( $this->mediaIds, $response->media_id ); 
    //         } else { return 'Upload media failed';}
             
    //     } 

    //     // Media 2
    //     if( !is_null( $spost->media_2 )){

    //         $media2 = Storage::get( 'public/' . $spost->media_2 );

    //         $response = $twitter->connection
    //             ->upload( 'media/upload', [ 'media' => $media2 ] );

    //         if ( $twitter->connection->getLastHttpCode() == 200 ) {
    //             array_push( $this->mediaIds, $response->media_id ); 
    //         } else { return 'Upload media failed';}

    //     }

    //     // Media 3
    //     if( !is_null( $spost->media_3 )){

    //         $media3 = Storage::get( 'public/' . $spost->media_3 );

    //         $response = $twitter->connection
    //             ->upload( 'media/upload', [ 'media' => $media3 ] );
            
    //         if ( $twitter->connection->getLastHttpCode() == 200 ) {
    //             array_push( $this->mediaIds, $response->media_id ); 
    //         } else { return 'Upload media failed';}
      
    //     }

    //     // Media 4
    //     if( !is_null( $spost->media_4 )){

    //         $media4 = Storage::get( 'public/' . $spost->media_4 );

    //         $response = $twitter->connection
    //             ->upload( 'media/upload', [ 'media' => $media4 ] );
            
    //         if ( $twitter->connection->getLastHttpCode() == 200 ) {
    //             array_push( $this->mediaIds, $response->media_id ); 
    //         } else { return 'Upload media failed';}
      
    //     }

    //     return 'success';

    // }


   
}