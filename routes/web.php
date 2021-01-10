<?php

use Illuminate\Http\Request;

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('posts', 'PostsController');
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);
});

// async
Route::resource('like', 'LikesAsyncController', ['only' => ['store']]);
Route::delete('like/{u_id}/{p_id}', 'LikesAsyncController@destroy')->name('like.destroy');
