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
        $remjobLink = 'https://remjob.io';

        // Select ramdom template:
        $template = mt_rand(1,4);

        if( $template == 1 ){
            $text = trim( $remjob->company->name );
            $text .= ' is looking for a '.trim( $remjob->position );
            //$text .= '. Find more through '.$link; 
        } elseif( $template == 2 ){
            $text = 'Want to work as '.trim( $remjob->position );
            $text .= ' at '.trim( $remjob->company->name ).'?';
            //$text .= 'Apply through '.$link;
        } elseif( $template == 3 ) {
            $text = trim( $remjob->company->name );
            $text .= ' is hiring: '.trim( $remjob->position );
            //$text .= '. Apply here: '.$link; 
        } else {
            $text = 'Apply for '.trim( $remjob->position );
            $text .= ' at '.trim( $remjob->company->name );
        }

        // Add locations
        if( $remjob->locations ){
            $text .= ' ['.$remjob->locations.']'; 
        }

        // Add tags
        if( $remjob->has('tags') ){
            foreach( $remjob->tags as $tag ){
                $text .= ' #'.str_replace(' ', '' , $tag->name); 
            }
        }

        // Add reference link
        $refLink = $remjob->plan ?  'https://remjob.io/remote_job/' .$remjob->slug : $link;
        $text .= ' '.$refLink;

        // Add client twitter handle to mention
        // if( $remjob->company->twitter ){
        //     $text .= ' @'.$remjob->company->twitter; 
        // }

        // Add remjob.io link
        $text .= ' More jobs ☛  '.$remjobLink;

        // dd($text);

        // Share on Twitter with TwitterOAuth library
        $twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        $twitter = new TwitterGateway( $twitterProfile->id, false );

        try {
            $response = $twitter->connection->post( "statuses/update", [ "status"    => $text,] );

            if ( $twitter->connection->getLastHttpCode() == 200 ) {          
                // register the social share
                $tweetPost = new \App\TwitterPost();
                $tweetPost->remjob_id = $remjob->id;
                $tweetPost->save();
                return true;
            } else {
                return false;
            } 

        } catch (TwitterOAuthException $exception) {
            return false;
        }

    }
   
}