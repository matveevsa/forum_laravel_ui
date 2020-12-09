<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('threads', ThreadsController::class)->except(['show']);
Route::get('threads/{channel:slug}/{thread:id}', [ThreadsController::class, 'show'])
    ->name('threads.show');

Route::post('/threads/{thread}/replies', [RepliesController::class, 'store'])
    ->name('replies.store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
