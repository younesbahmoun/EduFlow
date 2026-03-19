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

    // best solution
    public function getAll()
    {
        if(auth()->user()->role == 'student') {
            $interestIds = auth()->user()->interests->pluck('id');
            if(!$interestIds->isEmpty()) {
                return Course::with('teacher')->whereHas('interests', function ($query) use ($interestIds) {
                    $query->whereIn('interests.id', $interestIds);
                })->get();
            }

            // $query = Course::whereHas('interests', function ($q) use ($interestIds) {
            //     $q->whereIn('interest_id', $interestIds);
            // });
            // show query
            // dd($query->toSql(), $query->getBindings()); 
            // "select * from "courses" 
            // where exists (
            // select * from "interests"
            // inner join "course_interests" on "interests"."id" = "course_interests"."interest_id"
            // where "courses"."id" = "course_interests"."course_id" and 0 = 1) and "courses"."deleted_at" is null"
        }
        $courses = $this->courseRepository->getAll();
        return $courses;
    }

    //  solution 2 subquery
    // public function getAll()
    // {
    //     $user = auth()->user();

    //     if ($user->role == 'student') {

    //         return Course::with('teacher')
    //             ->whereHas('interests', function ($query) use ($user) {
    //                 $query->whereIn('interests.id', function ($subQuery) use ($user) {
    //                     $subQuery->select('interest_id')
    //                         ->from('user_interests')
    //                         ->where('user_id', $user->id);
    //                 });
    //             })
    //             ->get();
    //     }

    //     return $this->courseRepository->getAll();
    // }

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
        return DB::transaction(function () use ($course, $data) {
            $course = $this->courseRepository->update($course, $data);
            if(!empty($data['interest_ids'])) {
                $course->interests()->sync($data['interest_ids']);
            }
            return $course;
        });
    }

    public function delete(Course $course)
    {
        return $this->courseRepository->delete($course);
    }
}