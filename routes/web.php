<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Forum\HomeController;
use App\Http\Controllers\Forum\Dashboard\MyThreadController;
use App\Http\Controllers\Forum\Dashboard\ProfileController;
use App\Http\Controllers\Forum\Dashboard\SettingController;

// Forum
Route::group(['as' => 'forum.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::group(['prefix' => 'my-thread', 'as' => 'my_thread.'], function () {
        Route::get('/', [MyThreadController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
    });

});

require __DIR__ . '/auth.php';

