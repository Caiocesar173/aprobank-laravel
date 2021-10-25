<?php
use Caiocesar173\Aprobank\Http\Controllers\PayerController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('payer')->group(function () {
    Route::post('/', [PayerController::class, 'create']);
    Route::post('/associate', [PayerController::class, 'associate']);
    Route::get('/', [PayerController::class, 'list']);
    Route::get('/{id}', [PayerController::class, 'list']);
    Route::put('/', [PayerController::class, 'edit']);
    Route::delete('/', [PayerController::class, 'delete']);
});