<?php
use Caiocesar173\Aprobank\Http\Controllers\PaymentBookletController;


Route::middleware('api')->prefix('payment')->group(function () {
    Route::prefix('booklet')->group(function () {
        Route::post('/', [PaymentBookletController::class, 'create']);
        Route::get('/', [PaymentBookletController::class, 'list']);
        Route::get('/{id}', [PaymentBookletController::class, 'list']);
        Route::delete('/', [PaymentBookletController::class, 'delete']);
    });
});