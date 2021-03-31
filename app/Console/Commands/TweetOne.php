<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Traits\PublishRemjob;
use Illuminate\Support\Facades\Log;

class TweetOne extends Command
{
    use PublishRemjob;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:tweetOne';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Share one remjob every hour on twitter (Jobs shared once and older than 12 hr) ';

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
        $remjobs = \App\Remjob::where('active', 1)->where( 'id', '>', 2466 )->get();

        $foundRemjobToShare = false;

        foreach ( $remjobs as $remjob ) {

            $dt1 = Carbon::parse( $remjob->created_at );

            if( ( $remjob->twitterPosts()->count() == 2 and now()->diffInHours($remjob->created_at) > 12 ) ){

                $foundRemjobToShare = true;

                $this->info( $remjob->position.', posted on: '.$dt1.' set to be re-shared. Posted before: '.$remjob->twitterPosts()->count(). ' times.' );
                
                // Share remote job on Twitter
                $publish = $this->shareRemjobOnTwitter( $remjob );

                if( $publish ){
                    //Log::info( 'Remote Job id: ' .$remjob->id.' shared on Twitter for the '.$remjob->twitterPosts()->count().'th time.' );
                    $this->info( 'Remote Job id: ' .$remjob->id.' shared on Twitter for the '.$remjob->twitterPosts()->count().'th time.' );
                } else {
                    //Log::info( 'Remote Job id: ' .$remjob->id.' failed to share on Twitter. Current share count: '.$remjob->twitterPosts()->count().'' );
                    $this->info( 'Remote Job id: ' .$remjob->id.' failed to share on Twitter. Current share count: '.$remjob->twitterPosts()->count().'' );
                }

                // Allow only one share
                break;

            }

        }

        if( !$foundRemjobToShare ){
            $this->info( 'No remote job to share at this moment ...');
        }


    }
}
