<?php

namespace App\Repositories;

use App\Interfaces\EnrollmentRepositoryInterface;
use App\Models\Enrollment;

class EnrollmentRepository implements EnrollmentRepositoryInterface {
    public function createEnrollment($student, $course)
    {
        return $student->enrollments()->syncWithoutDetaching($course->id, ['payment_status' => 'pending']);
    }

    public function deleteEnrollment($student, $course)
    {
        return $student->enrollments()->detach($course->id);
    }

    public function getEnrollments($student)
    {
        return $student->enrollments;
        // return $student->enrollments->load('teacher');
        // return $student->enrollments()->with('teacher')->get();
    }

    public function updatePaymentStatus($student_id, $course_id, $status)
    {
        return Enrollment::where('student_id', $student_id)->where('course_id', $course_id)->update(['payment_status' => $status]);
    }

}