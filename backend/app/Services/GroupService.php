<?php

namespace App\Services;
use App\Models\Group;
use App\Models\Course;
use App\Models\User;
use App\Interfaces\GroupRepositoryInterface;

class GroupService {
    private GroupRepositoryInterface $groupRepository;
    const MAX_STUDENTS_PER_GROUP = 2;
    public function __construct(GroupRepositoryInterface $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function myGroups($student) {
        return $this->groupRepository->myGroups($student);
    }

    public function addStudentToGroup($student_id, $course_id) {
        $student = User::where('id', $student_id)->first();
        $course = Course::where('id', $course_id)->first();
        $lastGroup = $course->groups()->orderByDesc('group_number')->first();
        if($lastGroup) {
            if($lastGroup->students()->count() < self::MAX_STUDENTS_PER_GROUP) {
                return $this->groupRepository->addStudentToGroup($lastGroup->id, $student);
            } else {
                $group = $this->groupRepository->createGroup($lastGroup->group_number + 1, $course->id);
                return $this->groupRepository->addStudentToGroup($group->id, $student);
            }
        } else {
            $group = $this->groupRepository->createGroup(1, $course->id);
            return $this->groupRepository->addStudentToGroup($group->id, $student);
        }
    }
}