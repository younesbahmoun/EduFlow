<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\CourseController as V1CourseController;
use App\Http\Middleware\RoleMiddleware;


Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('register', [V1AuthController::class, 'register']);
    Route::post('login',    [V1AuthController::class, 'login']);

    // Protected routes
    
    Route::middleware('auth:api')->group(function () {
        Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
            Route::apiResource('courses', V1CourseController::class)->only(['store', 'update', 'destroy']);
        });
        Route::middleware(RoleMiddleware::class.':teacher, student')->group(function () {
            Route::apiResource('courses', V1CourseController::class)->only(['index', 'show']);
        });
        Route::get ('me',      [V1AuthController::class, 'me']);
        Route::post('logout',  [V1AuthController::class, 'logout']);
        Route::post('refresh', [V1AuthController::class, 'refresh']);
        Route::post('reset-password', [V1AuthController::class, 'resetPassword']);
    });
});
