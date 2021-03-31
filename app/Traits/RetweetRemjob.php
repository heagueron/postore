<?php namespace App\Traits;

use App\Remjob;
use Illuminate\Support\Str;

use App\ApiConnectors\TwitterGateway;


trait RetweetRemjob
{

    /**
     * Retweet the post.
     *
     * @param  Remjob $remjob
     * @return void
     */
    
    public function retweetRemjobOnTwitter(Remjob $remjob)
    {   
        // Share on Twitter with TwitterOAuth library
        $twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        $twitter = new TwitterGateway( $twitterProfile->id, false );

        // Get tweet id:
        $tweetId = $remjob->twitterPosts->first()->tweet_id;

        try {
            $response = $twitter->connection->post( "statuses/retweet", [ "id"    => $tweetId,] );

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
            $this->info( 'Something went wrong ... an exception was thrown and failed to retweet remjob id: ' . $remjob->id );
            return false;
        }
        
    }
   
}