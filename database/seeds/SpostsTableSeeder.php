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
                'id' => 2,
                'text' => 'Machine Learning
Check out this free computer science courses at CSEdu4All csedu4all.org/courses/',
                'post_date' => '2020-03-04 10:58:00',
                'posted' => 1,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 10:51:58',
                'updated_at' => '2020-03-04 10:51:58',
            ),
            1 => 
            array (
                'id' => 3,
                'text' => 'Machine learning
Machine learning for everyone teachablemachine.withgoogle.com',
                'post_date' => '2020-03-04 11:05:00',
                'posted' => 1,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 10:53:35',
                'updated_at' => '2020-03-04 10:53:35',
            ),
            2 => 
            array (
                'id' => 4,
                'text' => '#MachineLearning 
Forecasting volcano eruptions is notoriously tricky, but machine learning might be inching researchers a little closer 

Unlock the Potential of Machine Learning. Spell.run

Source: Science Daily',
                'post_date' => '2020-03-05 11:14:00',
                'posted' => 1,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 11:15:47',
                'updated_at' => '2020-03-05 11:31:35',
            ),
            3 => 
            array (
                'id' => 5,
                'text' => 'Laravel Job: Programador Laravel chiletrabajos.cl/trabajo/2110836 ciudad Puerto Montt #trabajo #empleo',
                'post_date' => '2020-03-04 13:56:00',
                'posted' => 1,
                'user_id' => 6,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 13:56:51',
                'updated_at' => '2020-03-04 13:57:19',
            ),
            4 => 
            array (
                'id' => 6,
                'text' => '#Notifications
How to add Real-Time Notifications to Laravel with Pusher

hackernoon.com/how-to-add-rea…',
                'post_date' => '2020-03-04 16:00:00',
                'posted' => 1,
                'user_id' => 6,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 15:56:56',
                'updated_at' => '2020-03-04 17:25:27',
            ),
            5 => 
            array (
                'id' => 7,
                'text' => 'Laravel
5 ways to write Laravel code that scales (sponsor) 

laravel-news.com/5-ways-to-writ…',
                'post_date' => '2020-03-04 16:02:00',
                'posted' => 1,
                'user_id' => 11,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 15:58:04',
                'updated_at' => '2020-03-04 17:25:27',
            ),
            6 => 
            array (
                'id' => 8,
                'text' => 'React.js job

Senior ReactJS Developer 

#MT - Palermo, Ciudad de Buenos Aires, Buenos Aires careers.deviget.com/careers/33298-…',
                'post_date' => '2020-03-04 18:00:00',
                'posted' => 1,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-04 17:30:33',
                'updated_at' => '2020-03-05 11:31:35',
            ),
            7 => 
            array (
                'id' => 10,
                'text' => 'Django:
Pytest Django and Django Rest Framework: 10 – Testing Create, Details and DestroyAPIViews trumpathon.com/pytest-django-…',
                'post_date' => '2020-03-05 13:35:00',
                'posted' => 0,
                'user_id' => 1,
                'media_1' => NULL,
                'media_2' => NULL,
                'media_3' => NULL,
                'media_4' => NULL,
                'media_files_count' => 0,
                'created_at' => '2020-03-05 13:34:38',
                'updated_at' => '2020-03-05 17:34:38',
            ),
        ));
        
        
    }
}