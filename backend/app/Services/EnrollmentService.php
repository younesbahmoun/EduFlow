<?php

namespace App\Services;

use App\Interfaces\EnrollmentRepositoryInterface;
use App\Interfaces\GroupRepositoryInterface;

class EnrollmentService {
    private EnrollmentRepositoryInterface $enrollmentRepository;
    private GroupRepositoryInterface $groupRepository;
    public function __construct(EnrollmentRepositoryInterface $enrollmentRepository, GroupRepositoryInterface $groupRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->groupRepository = $groupRepository;
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

    public function markAsPaid($student_id, $course_id)
    {
        return $this->enrollmentRepository->updatePaymentStatus(
            $student_id,
            $course_id,
            'paid'
        );

        
    }
}