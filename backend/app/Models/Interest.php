<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_interests', 'interest_id', 'user_id');
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'course_interests', 'interest_id', 'course_id');
    }
}
