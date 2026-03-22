<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EnrollmentController extends Controller
{
    // use AuthorizesRequests;

    private EnrollmentService $enrollmentService;
    public function __construct(EnrollmentService $enrollmentService) {
        $this->enrollmentService = $enrollmentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('enroll', Enrollment::class);
        $enrollments = $this->enrollmentService->getEnrollments(auth()->user());
        return response()->json([
            'enrollments' => $enrollments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Course $course)
    {
        $this->authorize('enroll', Enrollment::class);
        $enrollment = $this->enrollmentService->createEnrollment(auth()->user(), $course);
        if($enrollment['attached']) {
            return response()->json([
                'message' => 'Course added to your enrollments successfully',
                // 'enrollment' => $enrollment,    // "enrollment": {"attached": [1],"detached": [],"updated": []}
            ]);
        }
        return response()->json([
            'message' => 'Course already added to your enrollments',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('enroll', Enrollment::class);
        $enrollment = $this->enrollmentService->deleteEnrollment(auth()->user(), $course);
        if($enrollment) {
            return response()->json([
                'message' => 'Course removed from your enrollments successfully',
                // 'enrollment' => $enrollment, // "enrollment": 1
            ], 200); // 204 no content => no message
        }
        return response()->json([
            'message' => 'Course not found in your enrollments',
        ], 404);
    }
}
