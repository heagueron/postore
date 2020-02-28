<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ApiConnectors\TwitterGateway;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwitterGateway::class, function($app) {
            return new TwitterGateway(
                $this->get_tweeter_keys()
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function get_tweeter_keys()
    {
        $user = \Auth::user();

        /*****************************************
         * ADMIN Keys
         *
         ******************************************/

        if( $user->email == 'heagueron@gmail.com'){
            return array(
                config('ttwitter.CONSUMER_KEY'),
                config('ttwitter.CONSUMER_SECRET'),
                config('ttwitter.ACCESS_TOKEN'),
                config('ttwitter.ACCESS_TOKEN_SECRET')
            );
        }

        /*****************************************
         * CLIENT Keys
         *
         ******************************************/

        $twitter_profiles = $user->twitter_profiles;

        if( $twitter_profiles->count() > 0)
        {
            // Here, in #developement, we are forcing first twitter profile.
            // In prod, there must be a way to select it.
            $twitter_profile = $user->twitter_profiles->first();
            return array(
                config('ttwitter.CONSUMER_KEY'),
                config('ttwitter.CONSUMER_SECRET'),
                $twitter_profile->access_token,
                $twitter_profile->access_token_secret 
            );
        }

        // Client user is trying to build a twitter_profile
        return array(
            config('ttwitter.CONSUMER_KEY'),
            config('ttwitter.CONSUMER_SECRET'),
            '',
            ''
        );
        
    }

}
