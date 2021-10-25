<?php
use Caiocesar173\Aprobank\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('withdraw')->group(function () {
    Route::post('/', [WithdrawController::class, 'create']);
    Route::get('/', [WithdrawController::class, 'list']);
});