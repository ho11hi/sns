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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('json/{id?}', 'ApiController@getPosts')->name('post.json');
// Route::get('like', 'ApiController@getLikes')->name('like');
// Route::post('like/store', 'ApiController@store')->name('like.store');
// Route::delete('like/{u_id}/{p_id}', 'ApiController@delete')->name('delete');


// Route::group(['middleware' => 'auth:api'], function () {
//     Route::apiResource('like', 'ApiController', ['except' => ['destroy']]);
//     Route::delete('like/{u_id}/{p_id}', 'ApiController@destroy')->name('like.destroy');
// });


// Route::group(['middleware' => 'can:admin'], function () {
// Route::apiResource('like', 'ApiController', ['except' => ['destroy']]);
// Route::delete('like/{u_id}/{p_id}', 'ApiController@destroy')->name('like.destroy');
// });
