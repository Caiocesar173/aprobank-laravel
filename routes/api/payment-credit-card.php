<?php
use Caiocesar173\Aprobank\Http\Controllers\CreditCardController;


Route::middleware('api')->prefix('payment')->group(function () {
    Route::prefix('card')->group(function () {
        Route::post('/', [CreditCardController::class, 'create']);
        Route::post('/charge', [CreditCardController::class, 'charge']);
        Route::post('/chargeback', [CreditCardController::class, 'chargeback']);

        Route::get('/', [CreditCardController::class, 'list']);
        Route::get('/{id}', [CreditCardController::class, 'list']);
        Route::delete('/', [CreditCardController::class, 'delete']);
    });
});