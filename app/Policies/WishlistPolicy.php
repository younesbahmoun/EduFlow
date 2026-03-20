<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Auth\Access\Response;

class WishlistPolicy
{
    public function manage(User $user): bool
    {
        return $user->role === 'student';
    }
}
