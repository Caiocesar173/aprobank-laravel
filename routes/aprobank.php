<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('web')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', function () {
            dd('Register Route is Loading');
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
