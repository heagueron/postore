<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Free all remjobs
Route::get('/v1/remjobs', 'Api\RemjobController@index');
//Route::get('/v1/remjobs', [Api\RemjobController::class, 'index']);

// Paid all remjobs
Route::get('/v1/remjobs-pro', 'Api\RemjobController@indexPro')->middleware('auth:sanctum');
