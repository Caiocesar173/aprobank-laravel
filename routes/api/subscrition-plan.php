<?php
use Caiocesar173\Aprobank\Http\Controllers\SubscritionPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('subscrition')->group(function () {
    Route::prefix('plan')->group(function () {
        Route::post('/', [SubscritionPlanController::class, 'create']);
        Route::get('/', [SubscritionPlanController::class, 'list']);
        Route::get('/{id}', [SubscritionPlanController::class, 'list']);
        Route::put('/', [SubscritionPlanController::class, 'edit']);
        Route::delete('/', [SubscritionPlanController::class, 'delete']);
    });
});