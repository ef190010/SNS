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
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'PostController@index');
    Route::get('/posts/create', 'PostController@create');
    Route::post('/posts', 'PostController@store');
    Route::get('/posts/{post}', 'PostController@show');
    Route::get('/posts/{post}/edit', 'PostController@edit');
    Route::put('/posts/{post}', 'PostController@update');
    Route::delete('/posts/{post}', 'PostController@delete');

    Route::post('/replies', 'ReplyController@store');
    Route::get('/replies/{reply}', 'ReplyController@show');
    Route::get('/replies/{reply}/edit', 'ReplyController@edit');
    Route::put('/replies/{reply}', 'ReplyController@update');
    Route::delete('/replies/{reply}', 'ReplyController@delete');

    Route::get('/users/{user}', 'UserController@show');
    Route::get('/users/{user}/edit', 'UserController@edit');
    Route::patch('/users/{user}', 'UserController@update');
    
    Route::post('/users/{user}/follow', 'UserController@follow');
    Route::delete('/users/{user}/unfollow', 'UserController@unfollow');
    
    Route::post('/posts/{post}/favorite', 'FavoriteController@storePost');
    Route::delete('/posts/{post}/unfavorite', 'FavoriteController@deletePost');
    // Route::post('/replies/{reply}/like', 'FavoriteController@storeReply');
    // Route::delete('/replies/{reply}/unlike', 'FavoriteController@deleteReply');

});
