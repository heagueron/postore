<?php namespace App\Traits;

use App\Remjob;
//use App\TwitterProfile;
use Illuminate\Support\Str;

use App\ApiConnectors\TwitterGateway;
//use Illuminate\Support\Facades\Storage;


trait PublishRemjob
{

    /**
     * Publish the post.
     *
     * @param  Remjob $remjob
     * @return void
     */
    
    public function shareRemjobOnTwitter(Remjob $remjob)
    {   
        $link = $remjob->apply_link != null ? $remjob->apply_link : $remjob->apply_email;

        $text = $remjob->company->name;
        $text .= ', is looking for a '.$remjob->position;
        $text .= '. Find more through '.$remjob->link;

        $twitterProfile = \App\TwitterProfile::where('handler','JMServca');
        dd( $twitterProfile );
        $twitter = new TwitterGateway( $twitterProfile->id, false );

        // Post with TwitterOAuth library
        $response = $twitter->connection->post(
            "statuses/update",
            [
                "status"    => $text,
            ]
        );
        //dd('$response: ',$response);

        if ( $twitter->connection->getLastHttpCode() == 200 ) {
            // Success. Store the twitter status id received in pivot 'spost_twitter_profile'
            return true; 

        } else {
            // Failure
            return false;
        }    
        
        // $spost->update( [ 'posted' => true ] );

    }
   
}