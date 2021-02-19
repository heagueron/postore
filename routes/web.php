<?php

use App\Remjob;
use Illuminate\Support\Str;
use App\Mail\RemjobPaidMail;

use App\Rules\GumroadLicense;

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

// REMOTE JOBS
Route::get('/', 'RemjobController@index')->name('landing');
Route::get('/worldwide_remote_jobs', 'RemjobController@worldwide')->name('remjobs.worlwide');

Route::get('/post_a_job', 'RemjobController@create')->name('post_a_job')->middleware('auth');
Route::post('/remjobs', 'RemjobController@store')->name('remjobs.store')->middleware('auth');

// REMJOB EDITED BY CUSTOMER
Route::get('/remjobs/edit/{remjob}', 'RemjobController@edit')->name('remjobs.edit')->middleware('auth');
Route::patch('/remjobs/{remjob}', 'RemjobController@update')->name('remjobs.update')->middleware('auth');

// REMOTE JOB SHOW 
Route::get('/remote_job/{remjob:slug}', 'RemjobController@show')->name('remjobs.show');

// REMOTE JOBS SEARCH
Route::get('/list/{tags}', 'RemjobController@searchByTags')->name('remjobs.searchByTags');
Route::get('/remote-companies/{company:slug}', 'RemjobController@searchByCompany')->name('remjobs.searchByCompany');

// From javascript autocomplete search)
Route::get('/job_tags/{search_term}', 'RemjobController@search_job_tags_by_term');


Auth::routes();

// CHECKOUT
Route::get('/checkout/{remjob:slug}', 'PaymentController@checkout')->name('checkout');


// Paid plans
Route::get('/activate_remote_job', 'PaymentController@activate')->name('checkout.activate')->middleware('auth');
Route::patch('/publish_remote_job/{remjob}', 'PaymentController@publish')->name('checkout.publish')->middleware('auth');

// Free plan
Route::patch('/free_publish_remote_job/{remjob}', 'PaymentController@freePublish')->name('checkout.free_publish')->middleware('auth');


// ADMIN ROUTES
Route::get('/home', 'HomeController@index')->name('home');

Route::group( 
    ['prefix' => 'admin','middleware' => ['auth', 'admin']], 
    function () {
        
        // App Options
        Route::get('/editOptions', 'Admin\AdminController@editAdminOptions')->name('admin.edit-options');
        Route::patch('/update-options', 'Admin\AdminController@updateAdminOptions')->name('admin.update-options');

        Route::get('/textOptions/{textOption}/edit', 'Admin\AdminController@editTextOption')->name('admin.textOptions.edit');
        Route::patch('/textOptions/{textOption}', 'Admin\AdminController@updateTextOption')->name('admin.textOptions.update');
        Route::post('/textOptions', 'Admin\AdminController@storeTextOption')->name('admin.textOptions.store');

        Route::get('/options/{option}/edit', 'Admin\AdminController@editOption')->name('admin.options.edit');
        Route::patch('/options/{option}', 'Admin\AdminController@updateOption')->name('admin.options.update');

        // Remjobs
        Route::get('/remjobs', 'Admin\RemjobController@index')->name('admin.remjobs.index');
        Route::get('/remjobs/{remjob}/edit', 'Admin\RemjobController@edit')->name('admin.remjobs.edit');
        Route::patch('/remjob/{remjob}', 'Admin\RemjobController@update')->name('admin.remjobs.update');

        Route::delete('/remjobs/{remjob}', 'Admin\RemjobController@destroy')->name('admin.remjobs.destroy');
        Route::patch('/remjobs/{remjob}', 'Admin\RemjobController@toggleActive')->name('admin.remjobs.toggleActive');
        Route::get('/remjobs/{remjob}/tweet', 'Admin\RemjobController@tweet')->name('admin.remjobs.tweet');

        // Companies
        Route::get('/companies', 'Admin\CompanyController@index')->name('admin.companies.index');
        Route::get('/companies/create', 'Admin\CompanyController@create')->name('admin.companies.create');
        Route::post('/companies', 'Admin\CompanyController@store')->name('admin.companies.store');
        Route::get('/companies/{company}/edit', 'Admin\CompanyController@edit')->name('admin.companies.edit');
        Route::patch('/companies/{company}', 'Admin\CompanyController@update')->name('admin.companies.update');
        Route::delete('/companies/{company}', 'Admin\CompanyController@destroy')->name('admin.companies.destroy');

        // Categories
        Route::get('/categories', 'Admin\CategoryController@index')->name('admin.categories.index');
        Route::get('/categories/create', 'Admin\CategoryController@create')->name('admin.categories.create');
        Route::post('/categories', 'Admin\CategoryController@store')->name('admin.categories.store');
        Route::get('/categories/{category}/edit', 'Admin\CategoryController@edit')->name('admin.categories.edit');
        Route::patch('/categories/{category}', 'Admin\CategoryController@update')->name('admin.categories.update');
        Route::delete('/categories/{category}', 'Admin\CategoryController@destroy')->name('admin.categories.destroy');

        // Plans
        Route::get('/plans', 'Admin\PlanController@index')->name('admin.plans.index');
        Route::get('/plans/{plan}/edit', 'Admin\PlanController@edit')->name('admin.plans.edit');
        Route::patch('/plans/{plan}', 'Admin\PlanController@update')->name('admin.plans.update');

        // Dailies
        Route::get('/dailies', 'Admin\DailyController@index')->name('admin.dailies.index');
        Route::get('/dailies/updateAll', 'Admin\DailyController@updateAll')->name('admin.dailies.updateAll');

        // Visits
        Route::get('/visits/cleanAll', 'Admin\VisitController@cleanAll')->name('admin.visits.cleanAll');

        // Users
        Route::get('/users', 'Admin\UserController@index')->name('admin.users.index');
        Route::delete('/users/{user}', 'Admin\UserController@destroy')->name('admin.users.destroy');

        // External APIs
        Route::get('/api_jobs.rok', 'Admin\RemjobController@rok')->name('admin.api_jobs.rok');
        Route::get('/api_jobs.remotive', 'Admin\RemjobController@remotive')->name('admin.api_jobs.remotive');
        Route::get('/api_jobs.working-nomads', 'Admin\RemjobController@workingNomads')->name('admin.api_jobs.working-nomads');
        Route::get('/api_jobs.github', 'Admin\RemjobController@github')->name('admin.api_jobs.github');

        // Test private route
        Route::get('/hean', 'RemjobController@index_hean')->name('landing_hean');
        
});

// COMPANY ROUTES
Route::group( 
    ['prefix' => 'companies'], 
    function () {
        Route::get('search_company_by_email/{email}', 'CompanyController@search_company_by_email');
});

// SUBSCRIBER ROUTES
Route::post('/subscribers', 'SubscriberController@store')->name('subscribers.store');



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

// PAGES
Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('pages.privacy');
Route::get('/faq', function () {
    return view('pages.faq');
})->name('pages.faq');

// Support Routes
Route::group( 
    ['prefix' => 'support','middleware' => ['auth']], 
    function () {

        Route::get('/contact', 'SupportFormController@create')->name('support.create');
        Route::post('/contact', 'SupportFormController@store')->name('support.store');
        
});

/**
 * 
 *  SUPPORT ROUTES
 * 
 */

// Fake route to ping mailchimp
Route::get('/mc/ping', 'SubscriberController@pingChimp');
Route::get('/mc/interests', 'SubscriberController@mcInterests'); // get MailChimp segments
Route::get('/mc/segments', 'SubscriberController@mcSegments'); // get MailChimp segments
Route::get('/mc/campaigns', 'SubscriberController@mcGetCampaigns'); // get MailChimp campaigns
Route::get('/mc/createCampaigne', 'SubscriberController@mcCreateCampaign'); // Create MailChimp Campaign

Route::get('/mc/campaigns/{campaignId}', 'SubscriberController@showCampaign');


// Fake route to send paid remjob mail
Route::get('/remjob_paid', function () {
    $remjob = Remjob::where('company_id',6)->first();
    // Send Mail to Client and cc Administrator
    $title='Sending paid remjob mail ...';
    //dd($remjob->company->user->email);
    try{ 
        Mail::to( $remjob->company->user->email )
            ->cc('heagueron@gmail.com')
            ->send( new RemjobPaidMail( $remjob ) );     
            $message = 'SUCCESS!!';
    } catch (\Exception $exception){ 
        Log::info( 'Failed to send email to notify client or admin payment of remjob: ' . $remjob->id );
            $message = 'FAIL!!';
            dd($exception);
    }
    return view( 'information', compact( 'message', 'title' ) );
});

// Fake route to test activate
Route::get('/testa', function () {

    // Store the new Remjob id...
    session([ 'newRemjobId' => 33 ]);

    $saleId = 'kADrfEgPlKkWvJwdrJ3MnA==';

    if( ( null !== session('newRemjobId') ) and Remjob::where('id', session('newRemjobId') )->exists() ) {

        $remjob = Remjob::find( session('newRemjobId') );

        // Retrieve the license from gumroad:
        if ( $saleId ) {

            $grConnection = new Gumroad();
            $sale = $grConnection->getSale('kADrfEgPlKkWvJwdrJ3MnA==')['sale'];
            $gumroadLicense = $sale['license_key'];
            // dd($gumroadLicense);

            // $saleDirect = Http::withToken(config('services.gumroad.token'))->get('https://api.gumroad.com/v2/sales/kADrfEgPlKkWvJwdrJ3MnA==');
            
            // $gumroadLicense = $saleDirect->json()['sale']['license_key'];

            return view( 'payments.publish', compact( 'remjob', 'gumroadLicense' ) );

        } else { 
            $message = 'Sorry. We could not find your payment license for this job post. Contact support: heagueron@gmail.com';
        }

    } else {
        $message = 'Sorry. We could not find your remote job. Contact support: heagueron@gmail.com';
    }
     
    return view( 'information', compact( 'message' ) );

    // $saleDirect = Http::withToken(config('services.gumroad.token'))->get('https://api.gumroad.com/v2/sales/kADrfEgPlKkWvJwdrJ3MnA==');
    // dd($sale->body(), $sale->json(), $sale->headers());

    // $sales = Http::withToken(config('services.gumroad.token'))->get('https://api.gumroad.com/v2/sales');
    // dd($sales->body(), $sales->json(), $sales->headers());

    // $response = Http::withToken(config('services.gumroad.token'))->get('https://api.gumroad.com/v2/user');
    // dd($response->body(), $response->json(), $response->headers());

});


// Fake route to test final publish step
Route::get('/testp', function () {

    $remjob = Remjob::first();
    $gumroadLicense = 'fake-license-007';

    return view( 'payments.publish', compact( 'remjob', 'gumroadLicense' ) );
});

// Fake route to 404
Route::get('/test404', function () {
    return view( '404' );
});

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

use App\ApiConnectors\Gumroad;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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

Route::get('/phoneburner', function() {
    $send_resume_to="_php_job@phoneburner.com";
    for ($x=1; $x<5; $x++){
        $send_resume_to = $x . $send_resume_to;
    }
    $send_resume_to = substr($send_resume_to,1);
    dd( $send_resume_to );
    
});
