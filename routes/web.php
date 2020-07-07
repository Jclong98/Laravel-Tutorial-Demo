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

use App\Mail\NewUserWelcomeMail;

Auth::routes();

Route::get('/email', function() {
    return new NewUserWelcomeMail();
});

// defining routes
// second arg on get is the controller and method of that controller
// for more info on how each of these is defined, go to https://laravel.com/docs/5.1/controllers
    
// profiles
Route::get('/profile/{user}', 'ProfilesController@index')->name('user.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('user.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('user.update');

// following
Route::post('/follow/{user}', 'FollowsController@store');
    
// posts
Route::get('/', 'PostsController@index');
Route::post('/p', 'PostsController@store');
Route::get('/p/create', 'PostsController@create');
Route::get('/p/{post}', 'PostsController@show');
