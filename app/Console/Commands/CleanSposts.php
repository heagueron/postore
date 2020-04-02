<?php

namespace App\Console\Commands;

use App\Spost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use DB;

class CleanSposts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:clean-sposts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all sposts, their relations in pivots (with twitter_profiles) and their media files';

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
        $sposts= Spost::all();

        // Clean images
        foreach($sposts as $spost){
            if(\Storage::exists( 'public/' . $spost->media_1 )){
                \Storage::delete( 'public/' . $spost->media_1 );           
            }
            if(\Storage::exists( 'public/' . $spost->media_2 )){
                \Storage::delete( 'public/' . $spost->media_2 );           
            }
            if(\Storage::exists( 'public/' . $spost->media_3 )){
                \Storage::delete( 'public/' . $spost->media_3 );           
            }
            if(\Storage::exists( 'public/' . $spost->media_4 )){
                \Storage::delete( 'public/' . $spost->media_4 );           
            }
        }
        $this->info('All images cleared');


        // Clean pivot table Sposts-Twitter profiles
        DB::table('spost_twitter_profile')->delete();
        $this->info('Sposts-Twitter profiles table cleared');


        // Clean scheduled posts
        Spost::truncate();
        $this->info('All scheduled posts cleared');

    }
}
