<?php

use Caiocesar173\Aprobank\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('webhook')->group(function () {
    Route::post('/', [WebhookController::class, 'create']);
    Route::get('/', [WebhookController::class, 'list']);
    Route::delete('/', [WebhookController::class, 'delete']);
});