<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'SiteController@index');
    Route::get('/about', 'SiteController@about');
});


Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::post('/login', 'LoginController@login')->name('login');
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('/logout', 'LogoutController@perform')->name('logout');

        /**
         * Quiz Routes
         */
        Route::get('/be-a-millionaire', 'QuizController@index')->name('quiz.index');
        Route::post('/be-a-millionaire', 'QuizController@validation')->name('quiz.validate');
    });
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
//    todo:add middleware for authenticated users
    Route::post('submit-answer','App\Http\Controllers\Admin\QuestionController@submitAnswer')->name('admin/submit-answer');
    Route::post('remove-answer','App\Http\Controllers\Admin\QuestionController@removeAnswer')->name('admin/remove-answer');
    Route::post('update-answer','App\Http\Controllers\Admin\QuestionController@updateAnswer')->name('admin/update-answer');
});
