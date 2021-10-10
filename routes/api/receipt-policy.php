<?php
use Caiocesar173\Aprobank\Http\Controllers\ReceiptPolicyController;


Route::middleware('api')->prefix('receipt')->group(function () {
    Route::post('/', [ReceiptPolicyController::class, 'create']);
    Route::get('/', [ReceiptPolicyController::class, 'list']);
});