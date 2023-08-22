<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//    Route::resource('users', UserController::class);


Route::middleware('admin')->group(function () {
    Route::middleware('web')
        ->namespace('UserModule\app\Http\Controllers') // Adjust the namespace
        ->resource('users', UserController::class);
});
