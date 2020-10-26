<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Hector Aguero',
                'email' => 'heagueron@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$WtVUlKM0LmPyQsSh4JCgpeD1ZK7avpJROFQ5WcLn.68ovhE2WVtdG',
                'timezone' => 'America/Caracas',
                'category' => 'pro',
                'remember_token' => NULL,
                'created_at' => '2020-10-04 10:41:31',
                'updated_at' => '2020-10-04 06:41:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Maria Isabel',
                'email' => 'mifa_13@hotmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$rj/XR8FMfqCYnYPVh9McceK5/BOrkv8WtFl0K3JkbVOYWs5Cigw8i',
                'timezone' => 'America/Caracas',
                'category' => 'basic',
                'remember_token' => NULL,
                'created_at' => '2020-10-04 11:22:10',
                'updated_at' => '2020-10-04 07:22:10',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'luis',
                'email' => 'luis@postore.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$a69pAW8Z4eclchdlxZz8L.jGQZCyNcQttMUYm1f40Ol/mrQ6gzD4e',
                'timezone' => 'America/Caracas',
                'category' => 'basic',
                'remember_token' => NULL,
                'created_at' => '2020-03-05 09:01:13',
                'updated_at' => '2020-03-05 05:01:13',
            ),

        ));
        
        
    }
}