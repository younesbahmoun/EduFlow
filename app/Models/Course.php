<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title' ,
        'description',
        'prix',
        'teacher_id',
    ];

    public function Teacher() {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function Enrollment() {
        return $this->hasMany(Enrollment::class);
    }

    public function Group() {
        return $this->hasMany(Group::class);
    }

    public function interests() {
        return $this->belongsToMany(Interest::class, 'course_interests', 'course_id', 'interest_id');
    }

    public function wishedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'course_id', 'user_id');
    }

    public function enrolledStudents() {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id');
    }

    public function groups() {
        return $this->hasMany(Group::class, 'course_id', 'id');
    }

}