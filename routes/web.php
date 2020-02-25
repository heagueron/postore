<?php

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
Route::get('/twitter-profiles', 'TwitterProfileController@index');
Route::get('/twitter-profiles/create', 'TwitterProfileController@create');
Route::post('/twitter-profiles', 'TwitterProfileController@store');
Route::get('/twitter-profiles/{twitter-profile}', 'TwitterProfileController@show');
Route::get('/twitter-profiles/{twitter-profile}/edit', 'TwitterProfileController@edit');
Route::patch('/twitter-profiles/{twitter-profile}', 'TwitterProfileController@update');
Route::delete('/twitter-profiles/{twitter-profile}', 'TwitterProfileController@destroy');

// Scheduled Tweets (Stweets)
Route::get('/stweets', 'StweetController@index');
Route::get('/stweets/create', 'StweetController@create');
Route::post('/stweets', 'StweetController@store');
Route::get('/stweets/{stweet}', 'StweetController@show');
Route::get('/stweets/{stweet}/edit', 'StweetController@edit');
Route::patch('/stweets/{stweet}', 'StweetController@update');
Route::delete('/stweets/stweetr}', 'StweetController@destroy');