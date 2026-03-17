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

    public function Wishlist() {
        return $this->hasMany(Wishlist::class);
    }

    public function Interest() {
        return $this->hasMany(Interest::class);
    }

}