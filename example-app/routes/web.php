<?php

use Illuminate\Support\Facades\Route;
use App\Models\News;

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

Route::get('/prova/{param}', function ($param) {
    return 'Hello ' .$param;
});

Route::get('news', function () {

    $news = News::all();
    return view('news')->with('news', $news);
});

Route::get('news/{id}', function ($id) {
    
    $news = News::find($id);
    return view('news-detail')->with('news', $news);
    
})->name('news-detail');
