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
                'tag'  => '', 
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Software Development',
                'tag'   => 'dev',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Client Service',
                'tag' => 'customer-support',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Marketing',
                'tag' => 'marketing',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Design',
                'tag' => 'design',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Non Tech',
                'tag' => 'non-tech',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
        ));
        

    }


}
