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

            return new TwitterGateway( $this->get_tweeter_keys() );

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

        if( empty($user) ){ // Accesing from an artisan command. TODO: Build the TwitterGateway class on same command, not here.
            return array(
                config('ttwitter.CONSUMER_KEY'),
                config('ttwitter.CONSUMER_SECRET'),
                config('ttwitter.ACCESS_TOKEN'),
                config('ttwitter.ACCESS_TOKEN_SECRET')
            );
        };

        /*****************************************
         * ADMIN Keys
         *
         ******************************************/

        if( $user->email == 'heagueron@gmail.com')
        {
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

        else if ( !empty($user->twitter_profiles->all() )){

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
            config('ttwitter.ACCESS_TOKEN'),
            config('ttwitter.ACCESS_TOKEN_SECRET')
        );
        
    }

}
