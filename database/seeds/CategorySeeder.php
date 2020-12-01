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

            // SPANISH CATEGORIES:
            6 => 
            array (
                'id' => 7,
                'name' => 'Trabajos Remotos',
                'tag'  => '', 
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Desarrollo de Software',
                'tag'   => 'desarrollo',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Servicios al Cliente',
                'tag' => 'customer-support',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Mercadotecnia',
                'tag' => 'mercadotecnia',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Diseño',
                'tag' => 'diseño',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Otros',
                'tag' => 'otros',
                'created_at' => '2020-10-26 20:23:54',
                'updated_at' => '2020-10-26 20:23:54',
            ),
        ));
        

    }


}
