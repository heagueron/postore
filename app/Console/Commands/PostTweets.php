<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\spost;
use Carbon\Carbon;

use App\ApiConnectors\TwitterGateway;
use App\Traits\PublishPost;

class PostTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:post';

    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post scheduled messages';

    /**
     * The trait to publish twitter posts
     *
     */
    use PublishPost;

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
     * @return mixed
     */
    public function handle()
    {
        $sent = 0;
        
        // Twitter posts
        $twitter_profiles = \App\TwitterProfile::all();
        foreach ($twitter_profiles as $tp) {
            $userDate = Carbon::now()->timezone($tp->user->timezone)->toDateTimeString();

            $sposts = $tp->sposts()->where([
                [ 'posted', '=', 0 ],
                [ 'post_date', '<=', $userDate ]
            ])->get();

            //$this->info('Profile ' . $tp->handler . ' has ' . $sposts->count() . ' posts.');

            if( $sposts->count() > 0 ){

                $this->info('Will send ' . $sposts->count() . ' posts on behalf of: @' .$tp->handler. ' at ' .$userDate);

                // $twitter = new TwitterGateway( $tp->id, false);

                foreach ($sposts as $spost) {
                    //dd($spost);
                   // Trait to publish a post to a set of social profiles (one in this case)
                    $publish = $this->publishTwitter( $spost, array($tp->id) );
                    if($publish != 'success'){
                        dd('register a job failure');
                    }
                    $this->info('.');
                }
                $sent += $sposts->count();    
            }

        }
        if( $sent > 0 ){
           $this->info('Total posts sent: ' . $sent); 
        } else {
            $this->info('No post scheduled for current datetime'); 
        }  
    }
}
