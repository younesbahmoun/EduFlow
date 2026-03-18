<?php

namespace App\Repositories;

use App\Models\Course;
use App\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll()
    {
        return Course::with('teacher')->get();
    }

    public function find(Course $course)
    {
        return $course->load('teacher');
    }

    public function create(array $data)
    {
        return Course::create($data);
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