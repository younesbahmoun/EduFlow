<?php

namespace App\Observers;
use App\Models\Course;

class CourseObserver
{
    public function deleting(Course $course): void
    {
        $course->interests()->detach();
    }
}
