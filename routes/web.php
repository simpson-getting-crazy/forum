<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Forum\HomeController;


// Forum
Route::group(['as' => 'forum.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');


});

require __DIR__ . '/auth.php';

