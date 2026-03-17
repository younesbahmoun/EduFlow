<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;


Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('register', [V1AuthController::class, 'register']);
    Route::post('login',    [V1AuthController::class, 'login']);

    // Protected routes
    
    Route::middleware('auth:api')->group(function () {
        Route::get ('me',      [V1AuthController::class, 'me']);
        Route::post('logout',  [V1AuthController::class, 'logout']);
        Route::post('refresh', [V1AuthController::class, 'refresh']);
        Route::post('reset-password', [V1AuthController::class, 'resetPassword']);
    });
});
