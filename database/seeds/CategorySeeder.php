<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Remote Jobs',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Software Developers',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Client Service',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Marketing',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Design',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Others',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
        ));
        
    }


}
