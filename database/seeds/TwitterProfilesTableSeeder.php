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
                'twitter_user_id' => 42450712,
                'avatar' => 'https://pbs.twimg.com/profile_images/1200821951046017025/iBSoeYvt_normal.jpg',
                'created_at' => '2020-03-04 14:41:49',
                'updated_at' => '2020-03-04 14:41:49',
            ),
            1 => 
            array (
                    'id' => 8,
                    'handler' => 'JMServca',
                    'access_token' => '389702185-Cq4XVXP4rAuO3K3DspCq2t8khpVp8UWHHflMU1Ff',
                    'access_token_secret' => 'UG6BuulBrc7rnYnhySzwpRu9H0iSr8kJsIxrzQ1DCwmTm',
                    'user_id' => 1,
                    'twitter_user_id' => 389702185,
                    'avatar' => 'https://pbs.twimg.com/profile_images/1195504818590244864/SfiowUwE_normal.jpg',
                    'created_at' => '2020-03-22 20:58:05',
                    'updated_at' => '2020-03-22 20:58:05',
                ),
            2 => 
            array (
                'id' => 11,
                'handler' => 'BenGilWealth',
                'access_token' => '1179475211407826946-08XP9qPgvWMu8TZIreOT9B6f4nR3ON',
                'access_token_secret' => 'Dkd4GISxKZeg9drKhZwTuGEjXT0XxfdrRngVcOLwS5dJx',
                'user_id' => 1,
                'twitter_user_id' => 1179475211407826946,
                'avatar' => 'https://pbs.twimg.com/profile_images/1182379633146249216/I9oztAww_normal.jpg',
                'created_at' => '2020-03-22 20:58:05',
                'updated_at' => '2020-03-22 20:58:05',
            ),
            // 3 => 
            // array (
            //     'id' => 13,
            //     'handler' => 'AssistantSuppo1',
            //     'access_token' => '1200017560093253634-JFCJfAKybyTeJTTODutQG5uiOr5y3T',
            //     'access_token_secret' => 'NciKHSZAMH6rJNYexQOukBTOfaIZldRemqVFZOGcrNO25',
            //     'user_id' => 7,
            //     'twitter_user_id' => 1200017560093253634,
            //     'avatar' => 'https://pbs.twimg.com/profile_images/1202626328882757632/GOmgnbLN_normal.jpg',
            //     'created_at' => '2020-04-10 17:48:38',
            //     'updated_at' => '2020-04-10 17:48:38',
            // ),
            // 4 => 
            // array (
            //     'id' => 14,
            //     'handler' => 'ProfessorHomew1',
            //     'access_token' => '1188077876354211840-jnLlDl45huhuKDT9QVBf4D9QZQBfBB',
            //     'access_token_secret' => 'RPGuJf88GBbLaJ3LsRyj0IMmrM655jCpBEnbjWsQwwOmF',
            //     'user_id' => 8,
            //     'twitter_user_id' => 1188077876354211840,
            //     'avatar' => 'https://pbs.twimg.com/profile_images/1195515032135704581/Nw33y1G4_normal.jpg',
            //     'created_at' => '2020-04-10 18:55:59',
            //     'updated_at' => '2020-04-10 18:55:59',
            // ),
            // 5 => 
            // array (
            //     'id' => 15,
            //     'handler' => 'WebDeve94055211',
            //     'access_token' => '1219267404129349633-IhAUWydzvSO9nJInAVxryBCBq4eYKt',
            //     'access_token_secret' => '6c3eAwROK0hggPAvWFKuchY8zQ8IJhl6l5P41qpIFWas1',
            //     'user_id' => 1,
            //     'twitter_user_id' => 1219267404129349633,
            //     'avatar' => 'https://pbs.twimg.com/profile_images/1249391156162695168/2nJj9ZL7_normal.jpg',
            //     'created_at' => '2020-04-10 19:03:27',
            //     'updated_at' => '2020-04-10 19:03:28',
            // ),
        ));
        
        
    }
}