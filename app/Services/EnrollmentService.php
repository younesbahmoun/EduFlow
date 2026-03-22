<?php

namespace App\Services;

use App\Interfaces\EnrollmentRepositoryInterface;

class EnrollmentService {
    private EnrollmentRepositoryInterface $enrollmentRepository;
    public function __construct(EnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function createEnrollment($student, $course)
    {
        return $this->enrollmentRepository->createEnrollment($student, $course);
    }

    public function deleteEnrollment($student, $course)
    {
        $enrollment = $this->enrollmentRepository->deleteEnrollment($student, $course);
        return $enrollment;
    }

    public function getEnrollments($student)
    {
        $enrollment = $this->enrollmentRepository->getEnrollments($student);
        return $enrollment;
    }
}