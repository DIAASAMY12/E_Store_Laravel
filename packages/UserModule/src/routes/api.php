<?php

use Illuminate\Support\Facades\Route;
use UserModule\app\Http\Controllers\UserControllerApi;


Route::group(['prefix' => 'api'], function () {
    Route::apiResource('users', UserControllerApi::class);
});
