<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FavoriteController;


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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('load-news/{country_code}/{topic}', [NewsController::class, 'load_news']);
Route::post('add-to-favorites', [FavoriteController::class, 'add_favorite']);
Route::post('load-favorites', [FavoriteController::class, 'load_favorite']);
Route::post('delete-favorite', [FavoriteController::class, 'delete_favorite']);
Route::post('get-favorite-count', [FavoriteController::class, 'count_favorites']);