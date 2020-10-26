<?php

use Illuminate\Database\Seeder;

class SpostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sposts')->delete();
        
        \DB::table('sposts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'text' => 'Sunny beach day. Enjoy.',
                'post_date' => '2020-10-27 16:23:00',
                'posted' => 0,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'video' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
        ));
        
        
    }
}