<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('threads', ThreadsController::class)->except(['show']);
Route::get('threads/{channel}', [ThreadsController::class, 'index']);
Route::get('threads/{channel:slug}/{thread:id}', [ThreadsController::class, 'show'])
    ->name('threads.show');

Route::post('/threads/{thread}/replies', [RepliesController::class, 'store'])
    ->name('replies.store');

Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])
    ->name('reply_favorite');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
