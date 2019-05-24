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

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/users', 'Api\UserController@index');

Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');

Route::get('/threads/create', 'ThreadController@create')->name('threads.create');
Route::get('/threads/{channel?}', 'ThreadController@index')->name('threads');
Route::post('/threads', 'ThreadController@store')->middleware('must-be-confirmed')->name('threads.store');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');

Route::get('/profiles/{user}', 'ProfileController@show');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');

Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

Route::post('/replies/{reply}/best', 'BestReplyController@store')->name('best-reply.store');
