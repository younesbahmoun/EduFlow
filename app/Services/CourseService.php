<?php

namespace App\Services;

use App\Models\Course;
use App\Interfaces\CourseRepositoryInterface;

class CourseService {

    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAll()
    {
        return $this->courseRepository->getAll();
    }

    public function create(array $data)
    {
        $data['teacher_id'] = auth()->id();

        return $this->courseRepository->create($data);
    }

    public function find(Course $course)
    {
        return $this->courseRepository->find($course);
    }

    public function update(Course $course, array $data)
    {
        $this->courseRepository->update($course, $data);
        return $course;
    }

    public function delete(Course $course)
    {
        return $this->courseRepository->delete();
    }
}