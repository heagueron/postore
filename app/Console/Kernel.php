<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
//use App\Console\Commands\PostTweets;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\PostTweets::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('postore:ptweets')->everyTenMinutes();
                
                // ->when(function () {
                //     if ( DB::table('stweets')
                //         ->where([
                //             [ 'posted', '=', 0 ],
                //             [ 'post_date', '<=', $userDate ]
                //             ])
                //         ->count() > 0) { 

                //         return true;

                //     } 

                //     return false;
                // });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
