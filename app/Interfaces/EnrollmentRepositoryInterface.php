<?php

namespace App\Interfaces;

interface EnrollmentRepositoryInterface {
    public function createEnrollment($student, $course_id);
    public function deleteEnrollment($student, $course_id);
    public function getEnrollments($student);
}