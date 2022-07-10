<?php

use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Localization;
use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/broadcasting',[PusherController::class, '']);
Route::group(['as' => 'backend.', 'middleware' => ['auth','localization']], function (){
   Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
   Route::resource('posts',PostController::class);
   Route::post('posts/{post}/favorite',[PostController::class, 'favorite'])->name('posts.favorite');
   Route::resource('comments',CommentController::class);
   Route::get('/lang',[Localization::class, 'index'])->name('localization');
});
