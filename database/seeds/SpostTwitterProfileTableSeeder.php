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
                'spost_id' => 2,
                'twitter_profile_id' => 1,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'spost_id' => 3,
                'twitter_profile_id' => 1,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'spost_id' => 4,
                'twitter_profile_id' => 12,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'spost_id' => 8,
                'twitter_profile_id' => 12,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'spost_id' => 10,
                'twitter_profile_id' => 1,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'spost_id' => 7,
                'twitter_profile_id' => 11,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'spost_id' => 5,
                'twitter_profile_id' => 8,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'spost_id' => 5,
                'twitter_profile_id' => 8,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'spost_id' => 2,
                'twitter_profile_id' => 12,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'spost_id' => 3,
                'twitter_profile_id' => 12,
                'twitter_status_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}