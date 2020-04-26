<?php

use Illuminate\Database\Seeder;

class SpostTwitterProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('spost_twitter_profile')->delete();
        
        \DB::table('spost_twitter_profile')->insert(array (
            0 => 
            array (
                'id' => 1,
                'spost_id' => 1,
                'twitter_profile_id' => 15,
                'twitter_status_id' => NULL,
                'created_at' => '2020-04-26 20:23:54',
                'updated_at' => '2020-04-26 20:23:54',
            ),
        ));
        
        
    }
}