<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        \DB::table('options')->delete();
        
        \DB::table('options')->insert(array (
            0 => 
            array (
                'id'            => 1,
                'name'          => 'base_price',
                'value'         =>  39,
                'description'   => 'base price to post a job', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            1 => 
            array (
                'id'            => 2,
                'name'          => 'show_logo',
                'value'         =>  19,
                'description'   => 'show company logo if it is available', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            2 => 
            array (
                'id'            => 3,
                'name'          => 'yellow_background',
                'value'         =>  29,
                'description'   => 'highlight post with yellow background', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            3 => 
            array (
                'id'            => 4,
                'name'          => 'main_front_page',
                'value'         =>  29,
                'description'   => 'show job in general front page', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            4 => 
            array (
                'id'            => 5,
                'name'          => 'category_front_page',
                'value'         =>  19,
                'description'   => 'show job in category front page', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            5 => 
            array (
                'id'            => 6,
                'name'          => 'remjob_active_duration',
                'value'         =>  30,
                'description'   => 'duration of the remote job publication', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),

        ));
        

    }


}
