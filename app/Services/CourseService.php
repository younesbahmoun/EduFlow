<?php

namespace App\Services;

use App\Models\Course;
use App\Interfaces\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {
            $data['teacher_id'] = auth()->id();

            $course = $this->courseRepository->create($data);

            if (!empty($data['interest_ids'])) {    
                $course->interests()->attach($data['interest_ids']);
            }

            return $course;
        });
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
        return $this->courseRepository->delete($course);
    }
}