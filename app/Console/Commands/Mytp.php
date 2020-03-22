<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;

use Illuminate\Support\Str;


class Mytp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:mytp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete tweeter profile for user heagueron@gmail.com, if exists';

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
        // heagueron
        if( User::where('email','heagueron@gmail.com')-> exists() ){
            $user = User::where('email','heagueron@gmail.com')->first();
            if ( !$user->twitter_profiles()->exists() ){
                \App\TwitterProfile::create(
                [
                    'handler'               => 'heagueron',
                    'access_token'          => config('ttwitter.ACCESS_TOKEN'),
                    'access_token_secret'   => config('ttwitter.ACCESS_TOKEN_SECRET'),
                    'user_id'               => $user->id
                ]
            );

            $this->info('User "heagueron@gmail.com" twitter profile completed');
            } else {
                $this->info('User "heagueron@gmail.com" already has a twitter profile');
            }

        } else {
            $this->info('User "heagueron@gmail.com" not yet created');
        }
    }
}
