تبارك الله عليك، الـ Structure اللي حطيتي نقية ومزيانة بزاف كبداية. ولكن، باش نوصلو لـ Best Practices ونغطيو كاع الـ User Stories اللي ذكرتي (خاصة ديال الاستاد اللي كيشوف الـ Stats والـ Enrollments)، كاينين شي تحسينات ضروري نزيدوهم.

غادي نقسم ليك التصحيح حسب الـ Features:
1. Gestion des Cours (Teacher/Student)

هنا عندك واحد الملاحظة تقنية: فرقتي apiResource على جوج ديال الـ Middlewares. هادشي خدام، ولكن أحسن طريقة هي تخدم بـ Resource Controller واحد ودير الـ Authorization داخل الـ Controller (باستعمال authorizeResource أو Policies).

    تعديل: زيد الـ Route ديال الإحصائيات (Stats) والطلبة اللي مسجلين عند الأستاذ.

PHP

// Teacher Only
Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
    // كاع الـ stats ديال الأستاذ في دقة وحدة
    Route::get('teacher/dashboard', [V1TeacherController::class, 'dashboard']);
    Route::get('courses/{course}/enrollments', [V1CourseController::class, 'enrolledStudents']);
});

// Mix (Teacher/Student)
Route::apiResource('courses', V1CourseController::class); 
// ملاحظة: الـ Policies هوما اللي غايديرو الخدمة ديال شكون يقدر يدير Store/Update

2. Recommandation (Interests)

الـ User Story كتقول الطالب كيختار المجالات (Domains) فاش كيتسجل وباغي "Recommandations".

    الناقص: خاصك Routes باش تجيب لستة ديال المجالات (Categories/Domains) وباش الطالب يـ update الاهتمامات ديالو.

PHP

// Protected - Student
Route::get('interests', [V1InterestController::class, 'index']); // ليستة ديال كاع المجالات
Route::post('interests', [V1InterestController::class, 'update']); // يختار شنو كيعجبو
Route::get('recommendations', [V1CourseController::class, 'recommendations']); // الكورسات المقترحة

3. Wishlist (Favorites)

الـ Logic اللي درتي مزيان، ولكن في Laravel Best Practices، كنحاولو نختصرو. الـ toggle بوحدها كافية تعوض الـ post والـ delete.
PHP

Route::prefix('wishlist')->group(function () {
    Route::get('', [V1WishlistController::class, 'index']);
    Route::post('{course}/toggle', [V1WishlistController::class, 'toggle']); // الا كاين يحيدو، الا مكاينش يزيدو
    Route::delete('clear', [V1WishlistController::class, 'clear']);
});

4. Enrollments & Payments (Stripe)

الـ Story كتقول "Paiement via Stripe". يعني الـ store ما خاصهاش تكون غير post عادية، خاصها تـ trigger واحد الـ Checkout Session.

    Best Practice: فاش كيكون Payment، كنسميو الـ Route غالباً checkout.

PHP

Route::prefix('enrollments')->group(function () {
    Route::get('', [V1EnrollmentController::class, 'index']);
    Route::post('{course}/checkout', [V1PaymentController::class, 'checkout']); // كيرجع ليك Stripe URL
    Route::delete('{course}', [V1EnrollmentController::class, 'destroy']); // Unenroll
});

5. Organisation des Groupes (Auto-assignment)

هنا الـ User Story كتقول "Automatic Assignment". يعني الطالب ماخاصوش يدير post للـ group_id بيدو. السيستيم خاصو يحطو فاش يخلص.

    الأستاذ: خاصو يشوف الكروبات ديالو.

    الطالب: كيشوف غير الكروب اللي هو فيه.

PHP

// Teacher Only
Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
    Route::get('courses/{course}/groups', [V1GroupController::class, 'courseGroups']);
    Route::get('groups/{group}/members', [V1GroupController::class, 'groupMembers']);
});

// Student Only
Route::get('my-groups', [V1GroupController::class, 'myGroups']);

الكود النهائي المقترح (Clean & Structured):
PHP

Route::prefix('v1')->group(function () {
    // Auth Public
    Route::post('register', [V1AuthController::class, 'register']);
    Route::post('login',    [V1AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        
        // --- Shared Routes ---
        Route::apiResource('courses', V1CourseController::class); // Use Policies for roles

        // --- Teacher Specific ---
        Route::middleware(RoleMiddleware::class.':teacher')->group(function () {
            Route::get('teacher/stats', [V1TeacherController::class, 'statistics']);
            Route::get('courses/{course}/students', [V1CourseController::class, 'enrolledStudents']);
            Route::get('courses/{course}/groups', [V1GroupController::class, 'index']);
        });

        // --- Student Specific ---
        Route::middleware(RoleMiddleware::class.':student')->group(function () {
            // Recommendation & Interests
            Route::get('categories', [V1CategoryController::class, 'index']);
            Route::post('my-interests', [V1StudentController::class, 'updateInterests']);
            Route::get('suggested-courses', [V1CourseController::class, 'recommendations']);

            // Wishlist (Refactored)
            Route::get('wishlist', [V1WishlistController::class, 'index']);
            Route::post('wishlist/{course}/toggle', [V1WishlistController::class, 'toggle']);

            // Enrollments & Stripe
            Route::get('my-learning', [V1EnrollmentController::class, 'index']);
            Route::post('courses/{course}/enroll', [V1PaymentController::class, 'checkout']); // Stripe
            Route::delete('courses/{course}/unenroll', [V1EnrollmentController::class, 'destroy']);
            
            // Groups
            Route::get('my-groups', [V1GroupController::class, 'myGroups']);
        });

        // Auth management
        Route::get('me', [V1AuthController::class, 'me']);
        Route::post('logout', [V1AuthController::class, 'logout']);
    });
});

علاش هاد التغييرات؟

    Naming: استعملت my-learning و suggested-courses بلاصة الـ prefixes الطوال، حيت كتكون واضحة في الـ Frontend.

    Logic Separation: عزلنا الـ Payment (Checkout) على الـ Enrollment العادي حيت فيه Stripe Integration.

    Automation: حيدت الـ Routes اللي كيدير فيهم الطالب createGroup يدوياً، حيت الـ Story كتقول "Automatic". الخدمة غاتدار في الـ Service layer فاش تنجح عملية الخلاص.

واش بغيتي نكتب ليك الـ Logic ديال Stripe Webhook اللي كيدير الـ Enrollment والـ Group assignment أوتوماتيكياً فاش كيدوز الخلاص؟