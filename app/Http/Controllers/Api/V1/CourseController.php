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
    /**
     * Display a listing of the resource.
     */
    public function index(CourseService $courseService)
    {
        $courses = $courseService->index();
        return response()->json([
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request, CourseService $courseService)
    {
        $data = $request->validated();
        $course = $courseService->store($data);
        return response()->json([
            'message' => 'Course created successfully.',
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, CourseService $courseService)
    {
        $course = $courseService->show($course);
        return response()->json([
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course, CourseService $courseService)
    {
        $data = $request->validated();
        $course = $courseService->update($course, $data);
        return response()->json([
            'message' => 'Course updated successfully.',
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseService $courseService)
    {
        $course = $courseService->delete($course);
        return response()->json([
            'message' => 'Course deleted successfully.',
        ]);
    }
}
