<?php

namespace App\Interfaces;

interface GroupRepositoryInterface {
    public function myGroups($student);
    public function createGroup($group_number, $course_id);
    public function addStudentToGroup($group_id, $student);
    // public function getGroups($course_id);
    // all logic
    // public function addStudentToGroup($student_id, $course_id);
    // public function countGroupStudents($course_id);
    // public function update($id, $data);
    // public function delete($id);
}