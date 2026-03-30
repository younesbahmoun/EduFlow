<?php

namespace App\Repositories;
use App\Interfaces\WishlistRepositoryInterface;
// use App\Models\User;

class WishlistRepository implements WishlistRepositoryInterface {

    // attach() => blindly add => can cause duplicates
    // syncWithoutDetaching() => safe add => no duplicates
    public function addToWishlist($user, $course_id) {
        return $user->wishlist()->syncWithoutDetaching($course_id);
    }

    public function removeFromWishlist($user, $course_id) {
        return $user->wishlist()->detach($course_id);
    }

    
    public function getWishlist($user) {
        return $user->wishlist;
    }
    
    
    public function clearWishlist($user) {
        return $user->wishlist()->detach();
    }

    public function toggleWishlist($user, $course_id) {
        return $user->wishlist()->toggle($course_id);
    }

    // short version toggle
    // public function toggleWishlist($user, $course_id) {
    //     $exists = $user->wishlist()->where('course_id', $course_id)->exists();

    //     if ($exists) {
    //         $user->wishlist()->detach($course_id);
    //     } else {
    //         $user->wishlist()->attach($course_id);
    //     }
    // }
}