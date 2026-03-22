<?php

namespace App\Interfaces;

interface EnrollmentRepositoryInterface {
    public function createEnrollment($student, $course);
    public function deleteEnrollment($student, $course);
    public function getEnrollments($student);
}