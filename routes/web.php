<?php

use App\Remjob;

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
//Route::get('/checkout/activate', 'RemjobController@index');


// REMOTE JOBS (From javascript autocomplete search)
Route::get('/job_tags/{search_term}', 'RemJobController@search_job_tags_by_term');


Route::get('/post_a_job', 'RemJobController@create')->name('post_a_job')->middleware('auth');
Route::post('/remjobs', 'RemJobController@store')->name('remjobs.store')->middleware('auth');


// REMOTE JOBS SEARCH
Route::get('/list/{tags}', 'RemJobController@searchByTags')->name('remjobs.searchByTags');
Route::get('/remote-companies/{company:slug}', 'RemJobController@searchByCompany')->name('remjobs.searchByCompany');

// REMOTE JOB SHOW 
Route::get('/remote_job/{remjob:slug}', 'RemJobController@show')->name('remjobs.show');


// CHECKOUT
Route::get('/checkout/{remjob:slug}', 'PaymentController@checkout')->name('checkout');

// Paid plans
Route::get('/activate_remote_job', 'PaymentController@activate')->name('checkout.activate')->middleware('auth');
Route::patch('/publish_remote_job/{remjob}', 'PaymentController@publish')->name('checkout.publish')->middleware('auth');

// Free plan
Route::patch('/free_publish_remote_job/{remjob}', 'PaymentController@freePublish')->name('checkout.free_publish')->middleware('auth');


// ADMIN ROUTES
Route::group( 
    ['prefix' => 'admin','middleware' => ['auth', 'admin']], 
    function () {
        Route::get('/remjobs', 'Admin\RemjobController@index')->name('admin.remjobs.index');

        Route::get('/editOptions', 'Admin\AdminController@editAdminOptions')->name('admin.edit-options');
        Route::patch('/update-options', 'Admin\AdminController@updateAdminOptions')->name('admin.update-options');

        Route::get('/remjobs/{remjob}/edit', 'Admin\RemjobController@edit')->name('admin.remjobs.edit');
        Route::delete('/remjobs/{remjob}', 'Admin\RemjobController@destroy')->name('admin.remjobs.destroy');
        Route::patch('/remjobs/{remjob}', 'Admin\RemjobController@inactivate')->name('admin.remjobs.inactivate');
        Route::get('/remjobs/{remjob}/tweet', 'Admin\RemjobController@tweet')->name('admin.remjobs.tweet');
        
        // External APIs
        Route::get('/api_jobs.rok', 'Admin\RemjobController@rok')->name('admin.api_jobs.rok');
        Route::get('/api_jobs.remotive', 'Admin\RemjobController@remotive')->name('admin.api_jobs.remotive');
        Route::get('/api_jobs.working-nomads', 'Admin\RemjobController@workingNomads')->name('admin.api_jobs.working-nomads');
        Route::get('/api_jobs.github', 'Admin\RemjobController@github')->name('admin.api_jobs.github');
});

// COMPANY ROUTES
Route::group( 
    ['prefix' => 'companies'], 
    function () {
        Route::get('search_company_by_email/{email}', 'CompanyController@search_company_by_email');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('home/check_avatars', 'HomeController@checkAvatars');

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

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

// Scheduled posts (Sposts)
// Route::get('/sposts', 'SpostController@index')->name('sposts.index');
// Route::get('/sposts/create', 'SpostController@create')->name('sposts.create');
// Route::post('/sposts', 'SpostController@store');

// Route::post('/sposts/{spost}', 'SpostController@sendNow')->name('sposts.send_now')->middleware('auth');

// Route::get('/sposts/{spost}/edit', 'SpostController@edit')->name('sposts.edit')->middleware('auth');
// Route::patch('/sposts/{spost}', 'SpostController@update')->name('sposts.update')->middleware('auth');

// Route::delete('/sposts/{spost}', 'SpostController@destroy')->name('sposts.destroy')->middleware('auth');
// Route::get('/sposts/detail/{spost}', 'SpostController@detail')->name('sposts.detail');

// Route::post('/sposts/imageUpload', 'SpostController@imageUpload')->name('sposts.image');

// Route::get('/sposts/schedule', 'SpostController@schedule')->name('sposts.schedule');
// Route::get('/sposts/archive', 'SpostController@archive')->name('sposts.archive');


// Social Profiles
// Route::get('/social_profiles', 'HomeController@socialProfilesIndex')->name('social_profiles.index')->middleware('auth');

// Pages routes
// Route::view('/faq', 'pages.faq')->name('faq');
// Route::view('/file-upload', 'pages.file-upload')->name('file-upload');
// Route::view('/settings', 'pages.settings')->name('settings');
// Route::view('/upgrade', 'pages.upgrade')->name('upgrade');



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
use App\ApiConnectors\TwitterAPIExchange;

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
