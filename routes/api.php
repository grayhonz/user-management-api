<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['log.requests'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    
    Route::middleware(['validate.user'])->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
    });
    
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});