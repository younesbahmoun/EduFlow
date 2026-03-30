<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'course_id',
        'group_number',
    ];

    // course of the group
    public function course() {
        return $this->belongsTo(Course::class);
    }

    // students in the group
    public function students() {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }
}
