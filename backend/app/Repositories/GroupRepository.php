<?php

namespace App\Repositories;
use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;

class GroupRepository implements GroupRepositoryInterface {
    public function myGroups($student) {
        return $student->groups;
    }

    public function createGroup($group_number, $course_id) {
        return Group::firstOrCreate([
            'course_id' => $course_id,
            'group_number' => $group_number,
        ]);
    }

    public function addStudentToGroup($group_id, $student) {
        return $student->groups()->syncWithoutDetaching($group_id);
    }
    // public function update($id, $data) {
    //     $group = Group::find($id);
    //     $group->update($data);
    //     return $group;
    // }
    // public function delete($id) {
    //     $group = Group::find($id);
    //     $group->delete();
    //     return $group;
    // }
}