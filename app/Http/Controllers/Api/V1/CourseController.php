<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Services\CourseService;

class CourseController extends Controller
{
    protected $courseService;
    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = $this->courseService->getAll();
        return response()->json([
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = $this->courseService->create($request->validated());
        return response()->json([
            'message' => 'Course created successfully.',
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course = $this->courseService->find($course);
        return response()->json([
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        
        $course = $this->courseService->update($course, $request->validated());
        return response()->json([
            'message' => 'Course updated successfully.',
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course = $this->courseService->delete($course);
        return response()->json([
            'message' => 'Course deleted successfully.',
        ]);
    }
}
