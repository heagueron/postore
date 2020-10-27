<?php

use App\ApiConnectors\TwitterAPIExchange;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('landing');
// })->name('landing');

Route::get('/', 'RemjobController@index')->name('landing');


// REMOTE JOBS
Route::get('/job_tags', 'RemJobController@job_tags')->name('remjobs.job_tags');
Route::get('/job_tags/{search_term}', 'RemJobController@search_job_tags_by_term')->middleware('cors');

Route::get('/post-a-job', 'RemJobController@create')->name('post-a-job');
Route::post('/remjobs', 'RemJobController@store')->name('remjobs.store');
Route::get('/{tags}', 'RemJobController@searchByTags')->name('remjobs.searchByTags');

Route::get('/post-a-job', 'RemJobController@create')->name('post-a-job');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home/check_avatars', 'HomeController@checkAvatars');

// Twitter Profiles
Route::get('/twitter_profiles', 'TwitterProfileController@index')->name('twitter_profiles.index')->middleware('auth');

Route::get('/twitter_profiles/create', 'TwitterProfileController@create')->name('twitter_profiles.create')->middleware('auth');

Route::post('/twitter_profiles', 'TwitterProfileController@store')->name('twitter_profiles.store')->middleware('auth');

// Callback for Twitter API
Route::get('/twitter_profiles/convertToken', 'TwitterProfileController@convertToken');

//Route::get('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@show');
//Route::get('/twitter_profiles/{twitter_profile}/edit', 'TwitterProfileController@edit')->name('twitter_profiles.edit')->middleware('auth');;
//Route::patch('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@update')->name('twitter_profiles.update')->middleware('auth');;
Route::delete('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@destroy')->name('twitter_profiles.destroy')->middleware('auth');



// Scheduled posts (Sposts)
Route::get('/sposts', 'SpostController@index')->name('sposts.index');
Route::get('/sposts/create', 'SpostController@create')->name('sposts.create');
Route::post('/sposts', 'SpostController@store');
Route::post('/sposts/{spost}', 'SpostController@sendNow')->name('sposts.send_now')->middleware('auth');
Route::get('/sposts/{spost}/edit', 'SpostController@edit')->name('sposts.edit')->middleware('auth');
Route::patch('/sposts/{spost}', 'SpostController@update')->name('sposts.update')->middleware('auth');
Route::delete('/sposts/{spost}', 'SpostController@destroy')->name('sposts.destroy')->middleware('auth');
Route::get('/sposts/detail/{spost}', 'SpostController@detail')->name('sposts.detail');

Route::post('/sposts/imageUpload', 'SpostController@imageUpload')->name('sposts.image');

Route::get('/sposts/schedule', 'SpostController@schedule')->name('sposts.schedule');
Route::get('/sposts/archive', 'SpostController@archive')->name('sposts.archive');


// Social Profiles
Route::get('/social_profiles', 'HomeController@socialProfilesIndex')->name('social_profiles.index')->middleware('auth');

// Pages routes
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/file-upload', 'pages.file-upload')->name('file-upload');
Route::view('/settings', 'pages.settings')->name('settings');
Route::view('/upgrade', 'pages.upgrade')->name('upgrade');



// SUPPORT AND MAINTENANCE ROUTES 
 //Clear route cache:
 Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
}); 

// Clear application cache:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});


// J7mbo twitter-api-php

use Illuminate\Support\Str;
use App\ApiConnectors\TwitterGateway;

Route::get('/tap', function() {

    $twitter2 = new TwitterGateway();
    $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
    $getfield = '?skip_status=true';
    $requestMethod = 'GET';

    $response2 = $twitter2->connection
        ->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    dd($response2->profile_image_url_https);
    
});
Route::get('/tap2', function() {

    // Build the twitter connection class
    $twitter = new TwitterGateway( 15, false);

    $response2 = $twitter->connection
        ->get("account/verify_credentials", ["skip_status" => "true"]);

    // $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
    // $getfield = '?skip_status=true';
    // $requestMethod = 'GET';

    // $response2 = $twitter2->connection
    //     ->setGetfield($getfield)
    //     ->buildOauth($url, $requestMethod)
    //     ->performRequest();

    //dd($response2->profile_image_url_https);
    dd($response2);

});

Route::get('/tap3', function() {
    //GET statuses/show/:id
    // GET TWEET ENGAGEMENT
    $twitter = new TwitterGateway( 1, false);

    $response3 = $twitter->connection
        ->get("statuses/show", ["id" => "1250421157339074561"]);

    dd($response3);
    
});
