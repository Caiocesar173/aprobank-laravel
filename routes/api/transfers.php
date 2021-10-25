<?php
use Caiocesar173\Aprobank\Http\Controllers\TransfersController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('transfers')->group(function () {
    Route::post('/', [TransfersController::class, 'create']);
    Route::get('/', [TransfersController::class, 'list']);
    Route::get('/{id}', [TransfersController::class, 'list']);
});