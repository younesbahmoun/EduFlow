<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
    ];

    // public function hasRole($role)
    // {
    //     return $this->role === $role;
    // }

    // public function hasRole($roles)
    // {
    //     if (is_string($roles)) {
    //         $roles = explode(',', $roles);
    //     }

    //     return in_array($this->role, $roles);
    // }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Teacher
    public function courses() {
        return $this->hasMany(Course::class);
    }

    // Student interests
    public function interests() {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    // Student wishlist
    public function wishlist() {
        return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
    }

    // Student enrollments
    public function enrollments() {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
    }
}
