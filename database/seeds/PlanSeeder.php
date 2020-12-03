<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        \DB::table('plans')->delete();
        
        \DB::table('plans')->insert(array (
            0 => 
            array (
                'id'            => 1,
                'name'          => 'FREE',
                'value'         =>  0,
                'description'   => 'Free Plan',
                'show_logo'     => null,
                'yellow_background' => null,
                'main_front_page'   => null,
                'category_front_page'   => null,
                'gumroad_link'  => null,
                'gumroad_product_id'    => null,
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            1 => 
            array (
                'id'            => 2,
                'name'          => 'PRO',
                'value'         =>  19,
                'description'   => 'Standard Plan (Logo and yellow background )',
                'show_logo'     => 'on',
                'yellow_background' => 'on', 
                'main_front_page'   => null,
                'category_front_page'   => null,
                'gumroad_link'  => 'Link ST',
                'gumroad_product_id'    => 'Product Id ST', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),
            2 => 
            array (
                'id'            => 3,
                'name'          => 'PREMIUM',
                'value'         =>  29,
                'description'   => 'All in Standard + First On Main Page and Category Page',
                'show_logo'     => 'on',
                'yellow_background' => 'on',
                'main_front_page'   => 'on',
                'category_front_page'   => 'on',
                'gumroad_link'  => 'Link PR',
                'gumroad_product_id'    => 'Product Id PR', 
                'created_at'    => '2020-11-22 20:23:54',
                'updated_at'    => '2020-11-22 20:23:54',
            ),

        ));
        

    }


}
