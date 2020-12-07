<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('logs:clear', function() {

    if( \Storage::exists( 'logs/laravel.log' )){
        \Storage::delete( 'logs/laravel.log' );           
    }
    //exec('rm ' . storage_path('logs/*.log'));

    $this->comment('Logs have been cleared!');

})->describe('Clear log files');
