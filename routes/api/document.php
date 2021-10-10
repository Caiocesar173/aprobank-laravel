<?php
use Caiocesar173\Aprobank\Http\Controllers\DocumentController;


Route::middleware('api')->prefix('document')->group(function () {
    Route::post('/', [DocumentController::class, 'create']);
    Route::get('/', [DocumentController::class, 'list']);
    Route::get('/{id}', [DocumentController::class, 'list']);
    Route::delete('/', [DocumentController::class, 'delete']);
});