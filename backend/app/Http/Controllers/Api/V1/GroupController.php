<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\GroupService;

class GroupController extends Controller
{
    private $groupService;
    public function __construct(GroupService $groupService) {
        $this->groupService = $groupService;
    }

    public function myGroups()
    {
        $groups = $this->groupService->myGroups(auth()->user());
        return response()->json([
            'groups' => $groups,
        ]);
    }

    /**
     * Get ALL groups across ALL courses for the authenticated teacher.
     */
    public function teacherGroups()
    {
        $teacher = auth()->user();
        
        // Get all course IDs owned by this teacher
        $courseIds = $teacher->courses()->pluck('id');
        
        // Find all groups belonging to these courses and include the students and course details
        $groups = Group::whereIn('course_id', $courseIds)
            ->with(['course', 'students'])
            ->get();
            
        return response()->json([
            'groups' => $groups
        ], 200);
    }

    /**
     * Get groups and their participants for a specific course (Teacher only)
     */
    public function courseGroups(Course $course)
    {
        // Verify that the authenticated teacher owns this course
        if (auth()->id() !== $course->teacher_id) {
            return response()->json([
                'message' => 'Unauthorized. You do not own this course.'
            ], 403);
        }

        // Return groups with their students
        $groups = $course->groups()->with('students')->get();

        return response()->json([
            'groups' => $groups
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function createGroup($group_number, $course_id) {
        $group = $this->groupService->createGroup($group_number, $course_id);
        return response()->json([
            'message' => 'Group created',
            'group' => $group,
        ], 201);
    }

    public function addStudentToGroup($group) {
        $group = $this->groupService->addStudentToGroup($group, auth()->user());
        return response()->json([
            'message' => 'Student added to group',
            'group' => $group,
        ]);
    }

}