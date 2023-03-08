<?php

use Illuminate\Support\Facades\Route;
use App\Models\News;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;

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

Route::get('news', [NewsController::class, 'index']);

Route::get('news/category/{id}', [NewsController::class, 'getCategories'])->name('category');

Route::get('news/{id}', [NewsController::class, 'getNews'])->name('news-detail');


//LOGIN
Route::get('login', [UserController::class, 'login']);

Route::post('login', [UserController::class, 'doLogin']);


//REGISTER
Route::get('sign-up', [UserController::class, 'register']);

Route::post('sign-up', [UserController::class, 'doRegister']);
