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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Twitter Profiles
Route::get('/twitter_profiles', 'TwitterProfileController@index')->name('twitter_profiles.index')->middleware('auth');

Route::get('/twitter_profiles/create', 'TwitterProfileController@create')->name('twitter_profiles.create')->middleware('auth');

Route::post('/twitter_profiles', 'TwitterProfileController@store')->name('twitter_profiles.store')->middleware('auth');

// Callback for Twitter API
Route::get('/twitter_profiles/convertToken', 'TwitterProfileController@convertToken');

//Route::get('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@show');
//Route::get('/twitter_profiles/{twitter_profile}/edit', 'TwitterProfileController@edit')->name('twitter_profiles.edit')->middleware('auth');;
//Route::patch('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@update')->name('twitter_profiles.update')->middleware('auth');;
//Route::delete('/twitter_profiles/{twitter_profile}', 'TwitterProfileController@destroy')->name('twitter_profiles.destroy')->middleware('auth');;



// Scheduled Tweets (Stweets)
Route::get('/stweets', 'StweetController@index')->name('stweets.index');
Route::get('/stweets/create', 'StweetController@create')->name('stweets.create');
Route::post('/stweets', 'StweetController@store');
// Route::get('/stweets/{stweet}', 'StweetController@show');
// Route::get('/stweets/{stweet}/edit', 'StweetController@edit');
// Route::patch('/stweets/{stweet}', 'StweetController@update');
// Route::delete('/stweets/stweetr}', 'StweetController@destroy');

Route::get('/stweets/statuses', 'StweetController@twitterStatuses')->name('stweets.statuses');

// Scheduled posts (Sposts)
Route::get('/sposts', 'SpostController@index')->name('sposts.index');
Route::get('/sposts/create', 'SpostController@create')->name('sposts.create');
Route::post('/sposts', 'SpostController@store');
Route::post('/sposts/sendNow', 'SpostController@sendNow')->name('sposts.send_now');

Route::post('/sposts/imageUpload', 'SpostController@imageUpload')->name('sposts.image');

Route::get('/sposts/schedule', 'SpostController@schedule')->name('sposts.schedule');
//Route::post('/sposts', 'SpostController@store');

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

    dd($response2);
    
});
