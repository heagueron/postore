<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('viewDatabaseSchedule', function ($user) {
            return in_array($user->email, [
                'heagueron@gmail.com',
            ]);
        });

    }

    public function get_tweeter_keys()
    {
 
    }

}
