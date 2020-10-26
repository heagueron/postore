<?php namespace App\Traits;

use App\Spost;
use App\TwitterProfile;
use Illuminate\Support\Str;

use App\ApiConnectors\TwitterGateway;
use Illuminate\Support\Facades\Storage;


trait PublishPost
{
    protected $mediaIds;
    protected $profileIds;
    protected $mediaIdsList;
    protected $registerMediaResult;
    protected $twitter;
    protected $additionalOwnersList;

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
        $this->additionalOwnersList = null;

        if( count($ids)>1 and ($spost->media_files_count > 0 or !is_null( $spost->video ))  ){
            $this->additionalOwnersList = implode( ',', $this->getAdditionalOwners() );
        }
        
        // Check and register media files
        // Build the twitter connection class
        $this->twitter = new TwitterGateway( $this->profileIds[0], false);
     
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
        if( !is_null( $spost->video ) ){
            if( ! $this->registerVideo( 'public/' . $spost->video ) ) {
                return 'There was a problem uploading your video. Contact support.';
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
                // Success. Store the twitter status id received in pivot 'spost_twitter_profile'
                $spost->twitter_profiles()->syncWithoutDetaching([
                    $value => [ 'twitter_status_id' => $response->id ]
                ]); 

            } else {
                // Failure
                $twitter_profile = \App\TwitterProfile::findOrFail($value);
                return 'Your account @' .$twitter_profile->handler. ' is probably not authorized. Contact support.';
            }
                         
        }
        
        $spost->update( [ 'posted' => true ] );

        return 'success';

    }


    private function registerMedia($media){
        
        $strFile = Storage::get( $media );

        if( is_null($this->additionalOwnersList)){
            $parameters = [ 'media' => $strFile ];
        } else {
            $parameters = [
                'media'             => $strFile,
                'additional_owners' => $this->additionalOwnersList
            ];
        }
        $response = $this->twitter->connection->upload('media/upload', $parameters);

        if ( $this->twitter->connection->getLastHttpCode() == 200 ) {
            array_push( $this->mediaIds, $response->media_id );
            return  true;
        } else { 
            return false;
        }

    }

    private function registerVideo( $videoPath ){
        
        Storage::setVisibility( $videoPath, 'public' );
        
        if( is_null($this->additionalOwnersList)){
            $parameters = [ 
                'media'         => $videoPath,
                'media_type'    => 'video/mp4' // TODO: dynamic!
            ];
        } else {
            $parameters = [
                'media'             => $videoPath,
                'media_type'        => 'video/mp4',
                'additional_owners' => $this->additionalOwnersList
            ];
        }

        // upload signature: public function upload($path, array $parameters = [], $chunked = false)
        $response = $this->twitter->connection->upload('media/upload', $parameters, true);

        if ( $this->twitter->connection->getLastHttpCode() == 200 ) {
            array_push( $this->mediaIds, $response->media_id );
            return  true;
        } else { 
            return false;
        }

    }

    private function getAdditionalOwners() {

        $additionalOwnersArray = [];    // Will hold the profiles twitter ids

        $otherProfiles = array_slice($this->profileIds,1);  // All profiles but the first.

        foreach( $otherProfiles as $oP ) {

            $tp = TwitterProfile::where('id', '=', $oP)->first();
            if ($tp != null) {
                array_push( $additionalOwnersArray, $tp->twitter_user_id);
            }

        }

        return $additionalOwnersArray;

    }








   
}