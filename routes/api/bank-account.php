<?php
use Caiocesar173\Aprobank\Http\Controllers\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('bank')->group(function () {
    Route::prefix('account')->group(function () {
        Route::post('/', [BankAccountController::class, 'create']);
        Route::get('/', [BankAccountController::class, 'list']);
        Route::get('/{id}', [BankAccountController::class, 'list']);
        Route::delete('/{id}', [BankAccountController::class, 'delete']);
    });
});