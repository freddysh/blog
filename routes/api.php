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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v2/posts', [App\Http\Controllers\Post\PostController::class, 'api_index']);
Route::get('/v2/post/{id}', [App\Http\Controllers\Post\PostController::class, 'show']);
Route::get('/v2/post/imagen/{nombre}', [App\Http\Controllers\Post\PostController::class, 'get_imagen']);
