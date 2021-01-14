<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;



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

Route::get('load-news/{country_code}', [NewsController::class, 'load_news']);


Route::get('send-mail', function () {
   
    $details = [
        'title' => 'title',
        'body' => 'body'
    ];
   
    \Mail::to('saifxhatem@gmail.com')->send(new \App\Mail\Mailer($details));
   
    dd("Email is Sent.");
});