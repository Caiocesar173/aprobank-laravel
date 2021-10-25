<?php
use Caiocesar173\Aprobank\Http\Controllers\PaymentSplitController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('payment')->group(function () {
    Route::prefix('split')->group(function () {
        Route::post('/', [PaymentSplitController::class, 'create']);
        Route::get('/', [PaymentSplitController::class, 'list']);
        Route::get('/{id}', [PaymentSplitController::class, 'list']);
        Route::put('/', [PaymentSplitController::class, 'edit']);
        Route::delete('/', [PaymentSplitController::class, 'delete']);
    });
});