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
                'remember_token' => NULL,
                'created_at' => '2020-03-04 10:41:31',
                'updated_at' => '2020-03-04 06:41:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Maria Isabel',
                'email' => 'mifa_13@hotmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$rj/XR8FMfqCYnYPVh9McceK5/BOrkv8WtFl0K3JkbVOYWs5Cigw8i',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-04 11:22:10',
                'updated_at' => '2020-03-04 07:22:10',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'luis',
                'email' => 'luis@postore.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$a69pAW8Z4eclchdlxZz8L.jGQZCyNcQttMUYm1f40Ol/mrQ6gzD4e',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-05 09:01:13',
                'updated_at' => '2020-03-05 05:01:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'pepo',
                'email' => 'jm@hotmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$rrBCF/vk3jvNFsp.Khwln.vFp.K1zXCVWiJTBHLQq9y1RLN1Ed50C',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-05 11:43:56',
                'updated_at' => '2020-03-05 07:43:56',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'peter',
                'email' => 'peter@peter.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$CftiRFlkW3HYkvTyoNVnbu7SfxZPB5lWjuuVX2yqWWn9QaD6p3EWy',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-07 09:33:54',
                'updated_at' => '2020-03-07 05:33:54',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Professor Homework',
                'email' => 'jmservca@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$vnSbjtW8qW2pIe.mfFZZq.9YOKC5m4FtJbGCzL88dL4D3QbN5/MU6',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-21 16:12:55',
                'updated_at' => '2020-03-21 12:12:55',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Virtual Assistant',
                'email' => 'awerosolutions@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$wbqu7ItELQ8Rc8YxUyPUQuw5AL0AObhktw4tGba7ugFvF1HAIkJ72',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-21 19:09:43',
                'updated_at' => '2020-03-21 15:09:43',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Professor Second',
                'email' => 'professor.hean@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$0R3FKtStltmra.rMYL9W8OdRkehv4qK5OyBhTEo.KrO79/BWdGwtq',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-22 16:17:27',
                'updated_at' => '2020-03-22 12:17:27',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Web Developer',
                'email' => 'professor.developer@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$.eenko9kecTbJHi6LdDMH.qx4qO20DGDLOtZxHWyjFwCGrEu3W9OS',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-22 16:36:57',
                'updated_at' => '2020-03-22 12:36:57',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Ben Gil',
                'email' => 'bengil.wealth@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$F7.KPIXXspBTnSkFcBUPoOXJj0P7eN7rgr2JuXzp4jGvB7A2ZdFi2',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-22 16:57:34',
                'updated_at' => '2020-03-22 12:57:34',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Gato con Botas',
                'email' => 'gato@postore.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$zNYFPaJgWHSHKdM90IfgveX0A0yDHqPirX0j.45bmCAonTIPy3jB.',
                'timezone' => 'America/Caracas',
                'remember_token' => NULL,
                'created_at' => '2020-03-24 17:38:59',
                'updated_at' => '2020-03-24 13:38:59',
            ),
        ));
        
        
    }
}