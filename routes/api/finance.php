<?php
use Caiocesar173\Aprobank\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('finance')->group(function () {
    Route::get('/', [FinanceController::class, 'extract']);
    Route::get('/futures', [FinanceController::class, 'future']);
    Route::get('/transaction/history', [FinanceController::class, 'history']);
    Route::get('transaction/{id}', [FinanceController::class, 'transaction']);
});




