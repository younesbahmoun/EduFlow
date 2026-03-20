<?php

namespace App\Interfaces;

interface WishlistRepositoryInterface {
    public function addToWishlist($user, $course_id);
    public function removeFromWishlist($user, $course_id);
    public function getWishlist($user);
    public function clearWishlist($user);
    public function toggleWishlist($user, $course_id);
}