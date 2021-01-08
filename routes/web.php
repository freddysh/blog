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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categorias', [App\Http\Controllers\Categoria\CategoriaController::class, 'index'])->name('categoria.index');
Route::get('/api/v1/categorias', [App\Http\Controllers\Categoria\CategoriaController::class, 'api_index']);
Route::post('/api/v1/categorias', [App\Http\Controllers\Categoria\CategoriaController::class, 'store']);
Route::put('/api/v1/categorias/{categoria_id}', [App\Http\Controllers\Categoria\CategoriaController::class, 'update']);
Route::delete('/api/v1/categorias/{categoria_id}', [App\Http\Controllers\Categoria\CategoriaController::class, 'destroy']);

Route::get('/posts', [App\Http\Controllers\Post\PostController::class, 'index'])->name('posts.index');
Route::get('/api/v1/posts', [App\Http\Controllers\Post\PostController::class, 'api_index']);
Route::post('/api/v1/posts', [App\Http\Controllers\Post\PostController::class, 'store']);
Route::put('/api/v1/posts/{post_id}', [App\Http\Controllers\Post\PostController::class, 'update']);
Route::delete('/api/v1/posts/{post_id}', [App\Http\Controllers\Post\PostController::class, 'destroy']);
Route::get('/storage/post/{filename}', [App\Http\Controllers\Post\PostController::class, 'get_imagen']);

Route::get('/users', [App\Http\Controllers\User\UserController::class, 'index'])->name('users.index');
Route::get('/api/v1/users', [App\Http\Controllers\User\UserController::class, 'api_index']);
Route::post('/api/v1/users', [App\Http\Controllers\User\UserController::class, 'store']);
Route::put('/api/v1/users/{post_id}', [App\Http\Controllers\User\UserController::class, 'update']);
Route::delete('/api/v1/users/{post_id}', [App\Http\Controllers\User\UserController::class, 'destroy']);
