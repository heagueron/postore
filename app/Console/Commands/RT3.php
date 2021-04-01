<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Traits\RetweetRemjob;


class RT3 extends Command
{
    use RetweetRemjob;

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
        // Get active remote jobs
        $remjobs = \App\Remjob::where('active', 1)->where( 'id', '>', 2489 )->get();

        $foundRemjobToShare = false;

        foreach ( $remjobs as $remjob ) {
            $dt1 = Carbon::parse( $remjob->created_at );
            if( ( $remjob->twitterPosts()->count() == 1 ) and ( now()->diffInHours( $remjob->twitterPosts->first()->created_at ) > 3 ) ){
                
                $foundRemjobToShare = true;

                $this->info( $remjob->position.', posted on: '.$dt1.' set to be re-tweeted. Posted before: '.$remjob->twitterPosts()->count(). ' times.' );
                
                // Share remote job on Twitter
                $publish = $this->retweetRemjobOnTwitter( $remjob );

                if( $publish ){
                    $this->info( ' RETWEETED REMJOB ID: ' . $remjob->id );
                } else {
                    $this->info( 'Something went wrong ... failed to retweet remjob id: ' . $remjob->id );
                }

                // Allow only one retweet
                break;
            }
        }

        if( !$foundRemjobToShare ){
            $this->info( 'No remote job to share at this moment ...');
        }

    }
}
