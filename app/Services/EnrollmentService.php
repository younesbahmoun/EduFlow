<?php

namespace App\Services;

use App\Interfaces\EnrollmentRepositoryInterface;

class EnrollmentService {
    private EnrollmentRepositoryInterface $enrollmentRepository;
    public function __construct(EnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function createEnrollment($student, $course_id)
    {
        return $this->enrollmentRepository->createEnrollment($student, $course_id);
    }

    public function deleteEnrollment($student, $course_id)
    {
        $enrollment = $this->enrollmentRepository->deleteEnrollment($student, $course_id);
        return $enrollment;
    }

    public function getEnrollments($student)
    {
        $enrollment = $this->enrollmentRepository->getEnrollments($student);
        return $enrollment;
    }
}