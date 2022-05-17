<?php

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

Route::group(['middleware'=>['auth']], function (){
   Route::post('favorite/{post}', [App\Http\Controllers\Frontend\FavoriteController::class, 'create'])->name('posts.favorite');
});

Route::group(['as' => 'frontend.','middleware' => ['auth']], function (){
    Route::get('posts/{post}', [App\Http\Controllers\Frontend\PostController::class, 'show'])->name('posts.show')->where('post', '[0-9]+');
});

Route::group(['as' => 'backend.','middleware' => ['auth']], function (){
   Route::get('dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');
   Route::get('allPosts', [App\Http\Controllers\Backend\PostController::class, 'indexAllPosts'])->name('allPosts.index')->middleware('permission:Index Posts');
   Route::get('posts', [App\Http\Controllers\Backend\PostController::class, 'index'])->name('posts.index');
   Route::get('posts/create', [App\Http\Controllers\Backend\PostController::class, 'create'])->name('posts.create');
   Route::post('posts', [App\Http\Controllers\Backend\PostController::class, 'store'])->name('posts.store');
   Route::get('posts/{post}/edit', [App\Http\Controllers\Backend\PostController::class, 'edit'])->name('posts.edit')->middleware('permission:Edit Posts');
   Route::put('posts/{post}', [App\Http\Controllers\Backend\PostController::class, 'update'])->name('posts.update')->middleware('permission:Edit Posts');
   Route::delete('posts/{post}', [App\Http\Controllers\Backend\PostController::class, 'destroy'])->name('posts.destroy')->middleware('permission:Delete Posts');
   Route::get('posts/pending', [App\Http\Controllers\Backend\PostController::class, 'pending'])->name('posts.pending')->middleware('permission:Approved Posts');
   Route::put('posts/{post}/approved', [App\Http\Controllers\Backend\PostController::class, 'approved'])->name('posts.approved')->middleware('permission:Approved Posts');
});
