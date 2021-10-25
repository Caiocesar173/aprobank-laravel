<?php
use Caiocesar173\Aprobank\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'list']);
    Route::put('/', [ProfileController::class, 'edit']);
});