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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    // Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
});


// POSTS

Route::get('/posts', 'App\Http\Controllers\PostController@index');

// Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/posts', 'App\Http\Controllers\PostController@store');
    Route::put('/posts/{id}', 'App\Http\Controllers\PostController@update');
    Route::delete('/posts/{id}', 'App\Http\Controllers\PostController@destroy');
// });