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
    }

}