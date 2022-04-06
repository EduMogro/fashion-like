<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\DislikeController;

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


// AUTH

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group( ['middleware' => ["auth:sanctum"]], function() {
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('usuario', [PostController::class, 'usuario']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// POSTS

Route::get('/posts', [PostController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});


// LIKES / DISLIKES

Route::get('/posts/{post}/likes', [LikeController::class, 'index']);
Route::get('/posts/{post}/dislikes', [DislikeController::class, 'index']);

Route::group( ['middleware' => ["auth:sanctum"]], function() {
    // LIKES
    Route::post('/posts/{post}/like', [LikeController::class, 'store']);
    Route::get('/posts/{post}/like', [LikeController::class, 'show']);
    // DISLIKES
    Route::post('/posts/{post}/dislike', [DislikeController::class, 'store']);
    Route::get('/posts/{post}/dislike', [DislikeController::class, 'show']);
});