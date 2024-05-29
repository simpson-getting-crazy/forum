<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Forum\HomeController;
use App\Http\Controllers\Forum\ProfileController;

// Forum
Route::group(['as' => 'forum.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });

});

require __DIR__ . '/auth.php';

