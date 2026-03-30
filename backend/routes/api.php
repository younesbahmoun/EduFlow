<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\CourseController as V1CourseController;
use App\Http\Controllers\Api\V1\WishlistController as V1WishlistController;
use App\Http\Controllers\Api\V1\EnrollmentController as V1EnrollmentController;
use App\Http\Controllers\Api\V1\GroupController as V1GroupController;
use App\Http\Controllers\Api\V1\StripeWebhookController as V1StripeWebhookController;
use App\Http\Controllers\Api\V1\TeacherController as V1TeacherController;
use App\Http\Middleware\RoleMiddleware;


Route::prefix('v1')->group(function () {
    // Public routes
    
    // auth
    Route::post('register', [V1AuthController::class, 'register']);
    Route::post('login',    [V1AuthController::class, 'login']);
    // paiment
    Route::post('stripe/webhook', [V1StripeWebhookController::class, 'handle']);
    Route::get('payment/success', [V1EnrollmentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment/cancel', [V1EnrollmentController::class, 'paymentCancel'])->name('payment.cancel');

    // Protected routes
    
    Route::middleware('auth:api')->group(function () {
        // teacher routes
        Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
            // Route::get('teacher/dashboard', [V1TeacherController::class, 'dashboard']);
            // Route::get('courses/{course}/enrollments', [V1CourseController::class, 'enrolledStudents']);
            // Route::apiResource('courses', V1CourseController::class)->only(['store', 'update', 'destroy']);
            Route::apiResource('courses', V1CourseController::class);
            Route::get('teacher/stats', [V1TeacherController::class , 'statistics']);
            Route::get('teacher/groups', [V1GroupController::class, 'teacherGroups']);
            Route::get('courses/{course}/groups', [V1GroupController::class , 'courseGroups']);
        });

        // teacher and student routes
        // Route::middleware(RoleMiddleware::class.':teacher,student')->group(function () {
        // });

        // student routes
        Route::middleware(RoleMiddleware::class.':student')->group(function () {
            Route::apiResource('courses', V1CourseController::class)->only(['index', 'show']);
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

            // group
            Route::get('my-groups', [V1GroupController::class, 'myGroups']);
            Route::prefix('groups')->group(function () {
                Route::get('', [V1GroupController::class, 'index']);
            });
        });

        // auth routes
        Route::get ('me',      [V1AuthController::class, 'me']);
        Route::post('logout',  [V1AuthController::class, 'logout']);
        Route::post('refresh', [V1AuthController::class, 'refresh']);
        Route::post('reset-password', [V1AuthController::class, 'resetPassword']);
    });
});


// Route::prefix('v1')->group(function () {
//     // Auth Public
//     Route::post('register', [V1AuthController::class, 'register']);
//     Route::post('login',    [V1AuthController::class, 'login']);

//     Route::middleware('auth:api')->group(function () {
        
//         // --- Shared Routes ---
//         Route::apiResource('courses', V1CourseController::class); // Use Policies for roles

//         // --- Teacher Specific ---
//         Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
//             Route::get('teacher/stats', [V1TeacherController::class, 'statistics']);
//             Route::get('courses/{course}/students', [V1CourseController::class, 'enrolledStudents']);
//             Route::get('courses/{course}/groups', [V1GroupController::class, 'index']);
//         });

//         // --- Student Specific ---
//         Route::middleware(RoleMiddleware::class.':student')->group(function () {
//             // Recommendation & Interests
//             Route::get('categories', [V1CategoryController::class, 'index']);
//             Route::post('my-interests', [V1StudentController::class, 'updateInterests']);
//             Route::get('suggested-courses', [V1CourseController::class, 'recommendations']);

//             // Wishlist (Refactored)
//             Route::get('wishlist', [V1WishlistController::class, 'index']);
//             Route::post('wishlist/{course}/toggle', [V1WishlistController::class, 'toggle']);

//             // Enrollments & Stripe
//             Route::get('my-learning', [V1EnrollmentController::class, 'index']);
//             Route::post('courses/{course}/enroll', [V1PaymentController::class, 'checkout']); // Stripe
//             Route::delete('courses/{course}/unenroll', [V1EnrollmentController::class, 'destroy']);
            
//             // Groups
//             Route::get('my-groups', [V1GroupController::class, 'myGroups']);
//         });

//         // Auth management
//         Route::get('me', [V1AuthController::class, 'me']);
//         Route::post('logout', [V1AuthController::class, 'logout']);
//     });
// });