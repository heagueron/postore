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
        
        $spost->update([
            'posted'                => true,
        ]);

    }

    private function checkRegisterMedia($spost)
    {
        // Build the twitter connection class
        $twitter = new TwitterGateway( $this->profileIds[0], false);

        // Media 1
        if( !is_null( $spost->media_1 ) ){

            $media1 = Storage::get( 'public/' . $spost->media_1 );

            $response = $twitter->connection
                ->upload( 'media/upload', [ 'media' => $media1 ] );
            array_push( $this->mediaIds, $response->media_id ); 
        } 

        // Media 2
        if( !is_null( $spost->media_2 )){

            $media2 = Storage::get( 'public/' . $spost->media_2 );

            $response = $twitter->connection
                ->upload( 'media/upload', [ 'media' => $media2 ] );
            array_push( $this->mediaIds, $response->media_id ); 
        }

        // Media 3
        if( !is_null( $spost->media_3 )){

            $media3 = Storage::get( 'public/' . $spost->media_3 );

            $response = $twitter->connection
                ->upload( 'media/upload', [ 'media' => $media3 ] );
            array_push( $this->mediaIds, $response->media_id ); 
        }

        // Media 4
        if( !is_null( $spost->media_4 )){

            $media4 = Storage::get( 'public/' . $spost->media_4 );

            $response = $twitter->connection
                ->upload( 'media/upload', [ 'media' => $media4 ] );
            array_push( $this->mediaIds, $response->media_id ); 
        }

    }


   
}