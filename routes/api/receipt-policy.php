<?php
use Caiocesar173\Aprobank\Http\Controllers\ReceiptPolicyController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('receipt')->group(function () {
    Route::post('/', [ReceiptPolicyController::class, 'create']);
    Route::get('/', [ReceiptPolicyController::class, 'list']);
});