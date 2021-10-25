<?php
use Caiocesar173\Aprobank\Http\Controllers\PaymentLinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('payment')->group(function () {
    Route::prefix('link')->group(function () {
        Route::post('/', [PaymentLinkController::class, 'create']);
        Route::post('/check-password', [PaymentLinkController::class, 'checkPassword']);
        Route::post('/pay', [PaymentLinkController::class, 'pay']);

        Route::get('/', [PaymentLinkController::class, 'list']);
        Route::get('/{id}', [PaymentLinkController::class, 'list']);
        Route::delete('/', [PaymentLinkController::class, 'delete']);
    });
});