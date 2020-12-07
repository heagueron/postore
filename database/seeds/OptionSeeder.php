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
                'name'          => 'Active Duration (days)',
                'value'         =>  30,
                'description'   => 'Duration of the remote job publication as active', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            
        ));
        

    }


}
