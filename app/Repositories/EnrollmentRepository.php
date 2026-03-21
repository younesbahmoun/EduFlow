<?php

namespace App\Repositories;

use App\Interfaces\EnrollmentRepositoryInterface;
use App\Models\Enrollment;

class EnrollmentRepository implements EnrollmentRepositoryInterface {
    public function createEnrollment($student, $course_id)
    {
        return $student->enrollments()->syncWithoutDetaching($course_id, ['payment_status' => 'pending']);
    }

    public function deleteEnrollment($student, $course_id)
    {
        return $student->enrollments()->detach($course_id);
    }

    public function getEnrollments($student)
    {
        return $student->enrollments;
    }

}