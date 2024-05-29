<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AcceptOnlyAuthenticatedUser;

// Auth
Route::group(['as' => 'forum_auth.', 'middleware' => AcceptOnlyAuthenticatedUser::class], function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/logout', [LogoutController::class, 'store'])
        ->withoutMiddleware(AcceptOnlyAuthenticatedUser::class)
        ->name('logout.store');
});


