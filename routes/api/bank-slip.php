<?php
use Caiocesar173\Aprobank\Http\Controllers\BankSlipController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('bank')->group(function () {
    Route::prefix('slip')->group(function () {
        Route::post('/', [BankSlipController::class, 'create']);
        Route::get('/', [BankSlipController::class, 'list']);
        Route::get('/{id}', [BankSlipController::class, 'list']);
        Route::put('/', [BankSlipController::class, 'edit']);
        Route::delete('/', [BankSlipController::class, 'delete']);
    });
});