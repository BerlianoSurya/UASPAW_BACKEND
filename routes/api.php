<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('email/verify/{id}/{hash}', 'Api\EmailVerificationController@__invoke')->name('verification.verify');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');
Route::group(['middleware'=>'auth:api'],function(){
    Route::get('user','Api\AuthController@index');
    Route::get('user/{id}','Api\AuthController@show');
    Route::delete('user/{id}','Api\AuthController@destroy');
    Route::put('user/{id}','Api\AuthController@update');
    Route::post('user','Api\AuthController@store');
    Route::post('user/{id}', 'Api\AuthController@logout');

    Route::get('feed','Api\FeedController@index');
    Route::get('feed/{id}','Api\FeedController@show');
    Route::post('feed','Api\FeedController@store');
    Route::put('feed/{id}','Api\FeedController@update');
    Route::delete('feed/{id}','Api\FeedController@destroy');

    Route::get('market','Api\MarketController@index');
    Route::get('market/{id}','Api\MarketController@show');
    Route::post('market','Api\MarketController@store');
    Route::put('market/{id}','Api\MarketController@update');
    Route::delete('market/{id}','Api\MarketController@destroy');

    Route::get('komen','Api\KfeedController@index');
    Route::get('komen/{id}','Api\KfeedController@show');
    Route::post('komen','Api\KfeedController@store');
    Route::put('komen/{id}','Api\KfeedController@update');
    Route::delete('komen/{id}','Api\KfeedController@destroy');

    Route::get('course','Api\CourseController@index');
    Route::get('course/{id}','Api\CourseController@show');
    Route::post('course','Api\CourseController@store');
    Route::put('course/{id}','Api\CourseController@update');
    Route::delete('course/{id}','Api\CourseController@destroy');

    Route::get('student','Api\StudentController@index');
    Route::get('student/{id}','Api\StudentController@show');
    Route::post('student','Api\StudentController@store');
    Route::put('student/{id}','Api\StudentController@update');
    Route::delete('student/{id}','Api\StudentController@destroy');
});