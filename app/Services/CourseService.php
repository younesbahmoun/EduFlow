<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function index()
    {
        return Course::with('teacher')->get();
    }

    public function store(array $data)
    {
        $data['teacher_id'] = auth()->id();

        return Course::create($data);
    }

    public function show(Course $course)
    {
        return $course->load('teacher');
    }

    public function update(Course $course, array $data)
    {
        $course->update($data);
        return $course;
    }

    public function delete(Course $course)
    {
        return $course->delete();
    }
}