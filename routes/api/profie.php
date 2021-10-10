<?php
use Caiocesar173\Aprobank\Http\Controllers\ProfieController;


Route::middleware('api')->prefix('profile')->group(function () {
    Route::get('/', [ProfieController::class, 'list']);
    Route::put('/', [ProfieController::class, 'edit']);
});