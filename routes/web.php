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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as' => 'backend.','middleware' => ['auth']], function (){
   Route::get('dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');
   Route::get('posts', [App\Http\Controllers\Backend\PostController::class, 'index'])->name('posts.index');
   Route::get('posts/create', [App\Http\Controllers\Backend\PostController::class, 'create'])->name('posts.create');
   Route::post('posts', [App\Http\Controllers\Backend\PostController::class, 'store'])->name('posts.store');
   Route::get('posts/{post}/edit', [App\Http\Controllers\Backend\PostController::class, 'edit'])->name('posts.edit');
   Route::put('posts/{post}', [App\Http\Controllers\Backend\PostController::class, 'update'])->name('posts.update');
   Route::delete('posts/{post}', [App\Http\Controllers\Backend\PostController::class, 'destroy'])->name('posts.destroy');
});
