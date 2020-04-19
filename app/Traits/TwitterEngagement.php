<?php namespace App\Traits;


use App\Spost;

use App\ApiConnectors\TwitterGateway;


trait TwitterEngagement
{
    /**
     * Get Twitter engagement data for a post
     *
     * @param  Spost $spost
     * @return void
     */
    public function getEngagement(Spost $spost)
    {
        $engagement = [];

        foreach($spost->twitter_profiles as $tp){

            $twitter_status_id = $tp->pivot->twitter_status_id;

            $twitter = new TwitterGateway( $tp->id, false);
            $response = $twitter->connection
                ->get( "statuses/show", ["id" => $twitter_status_id] );

            if ( $twitter->connection->getLastHttpCode() == 200 ) {
                $engagement[$tp->id] = [
                    'retweet_count'     => $response->retweet_count,
                    'favorite_count'    => $response->favorite_count,
                ];
            } else {
                return null;
            }
        }
        return $engagement;
    }
}