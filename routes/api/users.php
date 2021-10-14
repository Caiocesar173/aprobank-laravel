<?php
use Caiocesar173\Aprobank\Http\Controllers\UsersController;


Route::middleware('api')->prefix('user')->group(function () {
    Route::post('/', [UsersController::class, 'create']);
    Route::get('/', [UsersController::class, 'list']);
    Route::get('/{id}', [UsersController::class, 'list']);
    Route::put('/', [UsersController::class, 'edit']);
    Route::delete('/', [UsersController::class, 'delete']);
});