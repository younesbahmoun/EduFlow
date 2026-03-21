<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\CourseController as V1CourseController;
use App\Http\Controllers\Api\V1\WishlistController as V1WishlistController;
use App\Http\Controllers\Api\V1\EnrollmentController as V1EnrollmentController;
use App\Http\Middleware\RoleMiddleware;


Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('register', [V1AuthController::class, 'register']);
    Route::post('login',    [V1AuthController::class, 'login']);

    // Protected routes
    
    Route::middleware('auth:api')->group(function () {
        // teacher routes
        Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
            Route::apiResource('courses', V1CourseController::class)->only(['store', 'update', 'destroy']);
        });

        // teacher and student routes
        Route::middleware(RoleMiddleware::class.':teacher,student')->group(function () {
            Route::apiResource('courses', V1CourseController::class)->only(['index', 'show']);
        });

        // student routes
        Route::middleware(RoleMiddleware::class.':student')->group(function () {
            // wishlist routes
            Route::get('wishlists', [V1WishlistController::class, 'index']);
            Route::post('/wishlists/{course_id}', [V1WishlistController::class, 'store']);
            Route::delete('/wishlists/{course_id}', [V1WishlistController::class, 'destroy']);
            Route::delete('/wishlists', [V1WishlistController::class, 'clearWishlist']);
            Route::put('/wishlists/{course_id}/toggle', [V1WishlistController::class, 'toggle']); // for favorite icon

            // enrollment routes
            Route::get('enrollments', [V1EnrollmentController::class, 'index']);
            Route::post('enrollments/{course_id}', [V1EnrollmentController::class, 'store']);
            Route::delete('enrollments/{course_id}', [V1EnrollmentController::class, 'destroy']);
        });

        // auth routes
        Route::get ('me',      [V1AuthController::class, 'me']);
        Route::post('logout',  [V1AuthController::class, 'logout']);
        Route::post('refresh', [V1AuthController::class, 'refresh']);
        Route::post('reset-password', [V1AuthController::class, 'resetPassword']);
    });
});
