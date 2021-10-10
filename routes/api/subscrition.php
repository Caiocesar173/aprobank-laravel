<?php
use Caiocesar173\Aprobank\Http\Controllers\SubscritionController;


Route::middleware('api')->prefix('subscrition')->group(function () {
    Route::post('/', [SubscritionController::class, 'create']);
    Route::get('/', [SubscritionController::class, 'list']);
    Route::get('/{id}', [SubscritionController::class, 'list']);
    Route::put('/', [SubscritionController::class, 'edit']);
    Route::delete('/', [SubscritionController::class, 'delete']);
});