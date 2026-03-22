<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\CourseController as V1CourseController;
use App\Http\Controllers\Api\V1\WishlistController as V1WishlistController;
use App\Http\Controllers\Api\V1\EnrollmentController as V1EnrollmentController;
use App\Http\Controllers\Api\V1\GroupController as V1GroupController;
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
            Route::prefix('wishlists')->group(function () {
                Route::get('', [V1WishlistController::class, 'index']);
                Route::post('{course_id}', [V1WishlistController::class, 'store']);
                Route::delete('{course_id}', [V1WishlistController::class, 'destroy']);
                Route::delete('', [V1WishlistController::class, 'clearWishlist']);
                Route::put('{course_id}/toggle', [V1WishlistController::class, 'toggle']); // for favorite icon
            });

            // enrollment
            Route::name('courses')->group(function () {
                Route::get('my-courses', [V1EnrollmentController::class, 'index'])->name('my');
                Route::post('courses/{course}/enroll', [V1EnrollmentController::class, 'store'])->name('enroll');
                Route::delete('courses/{course}/unenroll', [V1EnrollmentController::class, 'destroy'])->name('unenroll');
            });
        });

        // auth routes
        Route::get ('me',      [V1AuthController::class, 'me']);
        Route::post('logout',  [V1AuthController::class, 'logout']);
        Route::post('refresh', [V1AuthController::class, 'refresh']);
        Route::post('reset-password', [V1AuthController::class, 'resetPassword']);
    });
});
