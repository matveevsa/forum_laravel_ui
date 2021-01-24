<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\ThreadSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
        return redirect(route('threads.index'));
});

Auth::routes();

Route::resource('/threads', ThreadsController::class)->except(['show', 'destroy']);
Route::get('/threads/{channel}', [ThreadsController::class, 'index']);
Route::get('/threads/{channel:slug}/{thread:id}', [ThreadsController::class, 'show'])
    ->name('threads.show');
Route::delete('/threads/{channel:slug}/{thread:id}', [ThreadsController::class, 'destroy'])
    ->name('threads.destroy');

Route::get('/threads/{channel:slug}/{thread}/replies', [RepliesController::class, 'index'])
    ->name('replies.index');
Route::post('/threads/{channel:slug}/{thread}/replies', [RepliesController::class, 'store'])
    ->name('replies.store');
Route::post(
    '/threads/{channel:slug}/{thread}/subscriptions',
    [ThreadSubscriptionController::class, 'store']
)->middleware('auth')
    ->name('subscriptions.store');

Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])
    ->name('reply_favorite');
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy'])
    ->name('favorites.delete');

Route::get('/profile/{user}', [ProfilesController::class, 'show'])
    ->name('profile.show');

Route::patch('/replies/{reply}', [RepliesController::class, 'update'])
    ->name('replies.update');
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])
    ->name('replies.destroy');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
