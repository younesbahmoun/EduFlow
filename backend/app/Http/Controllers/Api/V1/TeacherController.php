<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Get statistics for the authenticated teacher.
     */
    public function statistics(Request $request)
    {
        $teacher = auth()->user();

        // All courses of this teacher
        $courseIds = $teacher->courses()->pluck('id');

        // Total Courses
        $totalCourses = $courseIds->count();

        // Total Students (Only paid enrollments)
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)
            ->where('payment_status', 'paid')
            ->count();

        // Total Revenue (Join with courses to get price)
        $totalRevenue = Enrollment::whereIn('enrollments.course_id', $courseIds)
            ->where('enrollments.payment_status', 'paid')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->sum('courses.prix');

        // Statistics per course
        $coursesStats = $teacher->courses()->withCount([
            'enrolledStudents as paid_students_count' => function ($query) {
                // Ensure we only count students who successfully paid
                $query->where('enrollments.payment_status', 'paid');
            }
        ])->get()->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'prix' => $course->prix,
                'paid_students_count' => $course->paid_students_count,
                'revenue' => $course->prix * $course->paid_students_count,
            ];
        });

        return response()->json([
            'overview' => [
                'total_courses' => $totalCourses,
                'total_students' => $totalStudents,
                'total_revenue'  => $totalRevenue,
            ],
            'courses' => $coursesStats
        ], 200);
    }
}
