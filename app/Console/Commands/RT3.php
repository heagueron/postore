<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\ApiConnectors\TwitterGateway;


class RT3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:rt3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-tweet a job post past at least 3 hours after first publication.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        $twitterProfile = \App\TwitterProfile::where('handler','BenGilWealth')->first();

        $twitter = new TwitterGateway( $twitterProfile->id, false );

        $text = 'Let us pray for the health of us all ... ';

        try {
            $response = $twitter->connection->post( "statuses/update", [ "status"    => $text,] );

            if ( $twitter->connection->getLastHttpCode() == 200 ) { 

                // register the social share
                // $tweetPost = new \App\TwitterPost();
                // $tweetPost->remjob_id = $remjob->id;
                // $tweetPost->save();
                // return true;
                $this->info( 'Tweet Id: ' . $response->id );

            } else {
                $this->info( 'Something went wrong ... ' );
            } 

        } catch (TwitterOAuthException $exception) {
            $this->info( 'Something went wrong ... an exception was thrown.' );
        }
    }
}
