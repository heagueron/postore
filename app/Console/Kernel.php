<?php

namespace App\Console;

use DB;
use App\Console\Commands\PostTweets;
use App\Console\Commands\CleanRemjobs;
use App\Console\Commands\HourlyTwitter;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PostTweets::class,
        CleanRemjobs::class,
        HourlyTwitter::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('postore:post')->everyMinute();
        $schedule->command('postore:clean-sposts')->daily();
        $schedule->command('postore:hourlyTwitter')->hourly();
        
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
