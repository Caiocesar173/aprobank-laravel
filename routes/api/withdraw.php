<?php
use Caiocesar173\Aprobank\Http\Controllers\WithdrawController;


Route::middleware('api')->prefix('withdraw')->group(function () {
    Route::post('/', [WithdrawController::class, 'create']);
    Route::get('/{id}', [WithdrawController::class, 'list']);
});