<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Traits\PublishRemjob;
use Illuminate\Support\Facades\Log;

class HourlyTwitter extends Command
{
    use PublishRemjob;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:hourlyTwitter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Share remjobs on twitter 1 and 3 hours after activation';

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
        if( \App\Remjob::where('active', 1)->exists() ){

            // Get active remote jobs
            $remjobs = \App\Remjob::where('active', 1)->get();

            $sharedRemjobs = 0;

            foreach ( $remjobs as $remjob ) {

                $dt1 = Carbon::parse( $remjob->created_at );

                if( ( $remjob->twitterPosts()->count() == 1 and now()->diffInHours($remjob->created_at) > 1 ) 
                    or 
                    ($remjob->twitterPosts()->count() == 2 and now()->diffInHours($remjob->created_at) > 3) ){

                    $this->info( $remjob->position.', posted on: '.$dt1.' set to be re-shared. Posted before: '.$remjob->twitterPosts()->count(). ' times.' );
                    
                    // Share new posted remote job on Twitter
                    $publish = $this->shareRemjobOnTwitter( $remjob );
                    
                    if( $publish ){
                        $sharedRemjobs += 1;
                        Log::info( 'Remote Job id: ' .$remjob->id.' shared on Twitter for the '.$remjob->twitterPosts()->count().'th time.' );
                        $this->info( 'Remote Job id: ' .$remjob->id.' shared on Twitter for the '.$remjob->twitterPosts()->count().'th time.' );
                    } else {
                        Log::info( 'Remote Job id: ' .$remjob->id.' failed to share on Twitter. Current share count: '.$remjob->twitterPosts()->count().'' );
                        $this->info( 'Remote Job id: ' .$remjob->id.' failed to share on Twitter. Current share count: '.$remjob->twitterPosts()->count().'' );
                    }

                } 

            }

            $this->info( ' Total remote jobs shared: '.$sharedRemjobs );

        } else {
            $this->info( ' No remote jobs on active state ' );
        }
    }
}
