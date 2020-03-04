<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Stweet;
use Carbon\Carbon;

use App\ApiConnectors\TwitterGateway;


class PostTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:ptweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post scheduled tweets';

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
    public function handle( TwitterGateway $twitter )
    {
        $users = \App\User::has('twitter_profiles')->get();
        $sent = 0;

        foreach ($users as $user){ // TODO: Build a different TwitterGateway class for everyuser! 
            $userDate = Carbon::now()->timezone($user->timezone)->toDateTimeString();

            $stweets = DB::table('stweets')->where([
                [ 'twitter_profile_id', '=', $user->id ],
                [ 'posted', '=', 0 ],
                [ 'post_date', '<=', $userDate ]
            ])->get();

            foreach($stweets as $stweet){
                $twitter->connection->post("statuses/update", ["status" => $stweet->text]);
                $model = Stweet::find($stweet->id);
                $model->posted = 1;
                $model->updated_at = $userDate;
                $model->save();
            }
            $sent = count($stweets);
        }
        $this->info('Total pending tweets posted: ' . $sent);
        
    }
}
