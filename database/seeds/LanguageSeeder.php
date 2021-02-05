<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id'            => 1,
                'name'          => 'English',
                'short_name'    => 'en',
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            1 => 
            array (
                'id'            => 2,
                'name'          => 'Spanish',
                'short_name'    => 'es',
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            
        ));
        
    }
}
