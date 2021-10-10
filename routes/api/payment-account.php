<?php
use Caiocesar173\Aprobank\Http\Controllers\PaymentAccountController;


Route::middleware('api')->prefix('payment')->group(function () {
    Route::prefix('account')->group(function () {
        Route::post('/', [PaymentAccountController::class, 'create']);
        Route::get('/', [PaymentAccountController::class, 'list']);
        Route::get('/{id}', [PaymentAccountController::class, 'list']);
        Route::put('/', [PaymentAccountController::class, 'edit']);
        Route::delete('/', [PaymentAccountController::class, 'delete']);
    });
});