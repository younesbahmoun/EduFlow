<?php

namespace App\Services;
use App\Interfaces\WishlistRepositoryInterface;

class WishlistService {

    protected $wishlistRepository;

    public function __construct(WishlistRepositoryInterface $wishlistRepository) {
        $this->wishlistRepository = $wishlistRepository;
    }
 
    public function addToWishlist($courseId) {
        $user = auth()->user();
        if ($user->wishlist()->where('course_id', $courseId)->exists()) {
            return false;
        }
        $this->wishlistRepository->addToWishlist($user, $courseId);
        return true;
    }

    public function removeFromWishlist($courseId) {
        $user = auth()->user();
        if($user->wishlist()->where('course_id', $courseId)->exists()) {
            $this->wishlistRepository->removeFromWishlist($user, $courseId);
            return true;
        }
        return false;
    }

    public function getWishlist() {
        return $this->wishlistRepository->getWishlist(auth()->user());
    }

    public function clearWishlist() {
        $this->wishlistRepository->clearWishlist(auth()->user());
    }

    public function toggleWishlist($courseId) {
        return $this->wishlistRepository->toggleWishlist(auth()->user(), $courseId);
    }
}