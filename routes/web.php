<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Articles
    Route::get('/articles/create', [UserController::class, 'create'])->name('articles.create');
    Route::post('/articles/store', [UserController::class, 'store'])->middleware('throttle:10,1')->name('articles.store');
    Route::get('/articles/{article}/edit', [UserController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}/update', [UserController::class, 'update'])->middleware('throttle:10,1')->name('articles.update');
    Route::delete('/articles/{article}/delete', [UserController::class, 'remove'])->name('articles.remove');
    Route::get('/articles/{article}/like', [UserController::class, 'like'])->name('article.like');


    // Commentaires
    Route::post('/comments/store/{article}', [CommentController::class, 'store'])->middleware('throttle:10,1')->name('comments.store');
});

require __DIR__.'/auth.php';
require __DIR__.'/public.php';
