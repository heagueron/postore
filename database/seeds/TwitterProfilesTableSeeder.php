<?php

use Illuminate\Database\Seeder;

class TwitterProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('twitter_profiles')->delete();
        
        \DB::table('twitter_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'handler' => 'heagueron',
                'access_token' => '42450712-YpZMaj6f9HBsxyedo70oLYR78nhB1ky4rRSKnZHLS',
                'access_token_secret' => 'JU7g03RemnFDFu7NkSaN6v8Ng4H4kVpOUQeWSVFoF6yHp',
                'user_id' => 1,
                'twitter_user_id' => 112000112000112000,
                'created_at' => '2020-03-04 14:41:49',
                'updated_at' => '2020-03-04 14:41:49',
            ),
            1 => 
            array (
                'id' => 7,
                'handler' => 'AssistantSuppo1',
                'access_token' => '1200017560093253634-f0pqsHjQwuQJ4rEY25Jm5Q5D5YRNyQ',
                'access_token_secret' => '4aMPW5KETdM27rEgvQb8t5vcYm2gTprr2lDlDQMT6zdkF',
                'user_id' => 7,
                'twitter_user_id' => 1200017560093253634,
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
            2 => 
            array (
                'id' => 8,
                'handler' => 'JMServca',
                'access_token' => '389702185-Cq4XVXP4rAuO3K3DspCq2t8khpVp8UWHHflMU1Ff',
                'access_token_secret' => 'UG6BuulBrc7rnYnhySzwpRu9H0iSr8kJsIxrzQ1DCwmTm',
                'user_id' => 6,
                'twitter_user_id' => 389702185,
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
            3 => 
            array (
                'id' => 9,
                'handler' => 'ProfessorHomew1',
                'access_token' => '1188077876354211840-BvuH1wl3EdtqOapLRxKQBmdUVzseOp',
                'access_token_secret' => 'k3K7hEiFWWZ3uIYosbJasKcGUiZ5zYvmzYoJ0sm0pJuwJ',
                'user_id' => 8,
                'twitter_user_id' => 1188077876354211840,
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
            4 => 
            array (
                'id' => 10,
                'handler' => 'WebDeve94055211',
                'access_token' => '1219267404129349633-XwQCL8Rjmu6mDD8NOTzxH5Tru3oEu0',
                'access_token_secret' => 'N0nozcwWAoPkvt46MTyOgjHDmxY8Zt0sWZU4UBI94fSJz',
                'user_id' => 9,
                'twitter_user_id' => 1219267404129349633,
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
            5 => 
            array (
                'id' => 11,
                'handler' => 'BenGilWealth',
                'access_token' => '1179475211407826946-08XP9qPgvWMu8TZIreOT9B6f4nR3ON',
                'access_token_secret' => 'Dkd4GISxKZeg9drKhZwTuGEjXT0XxfdrRngVcOLwS5dJx',
                'user_id' => 11,
                'twitter_user_id' => 112000112000112001,
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
        ));
        
        
    }
}