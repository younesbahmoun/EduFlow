<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Services\WishlistService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WishlistController extends Controller
{
    use AuthorizesRequests;
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService) {
        $this->wishlistService = $wishlistService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manage', Wishlist::class);
        $wishlist = $this->wishlistService->getWishlist();
        return response()->json([
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($course_id)
    {
        $this->authorize('manage', Wishlist::class);
        $result = $this->wishlistService->addToWishlist($course_id);
        if ($result) {
            return response()->json([
                'message' => 'Course added to wishlist',
            ], 200);
        }
        return response()->json([
            'message' => 'Course already in wishlist',
        ], 409);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($course_id)
    {
        // $this->authorize('delete', Wishlist::class);
        $result = $this->wishlistService->removeFromWishlist($course_id);
        if ($result) {
            return response()->json([
                'message' => 'Course removed from wishlist',
            ], 204);
        }
        return response()->json([
            'message' => 'Course not found in wishlist',
        ], 404);
    }

    // public function removeFromWishlist(Request $request) {
    //     $this->authorize('delete', Wishlist::class);
    //     $validated = $request->validate([
    //         'course_id' => 'required|exists:courses,id',
    //     ]);
    //     $this->wishlistService->removeFromWishlist($validated['course_id']);
    //     return response()->json([
    //         'message' => 'Course removed from wishlist',
    //     ], 200);
    // }

    public function clearWishlist()
    {
        $this->authorize('manage', Wishlist::class);
        $this->wishlistService->clearWishlist();
        return response()->json([
            'message' => 'Wishlist cleared',
        ], 200);
    }

    public function toggle($course_id) {
        $this->authorize('manage', Wishlist::class);
        $status = $this->wishlistService->toggleWishlist($course_id);
        if (!empty($status['attached'])) {
            return response()->json([
                'message' => 'Course added to wishlist',
                // 'status' => $status,
            ], 200);
        }
        return response()->json([
            'message' => 'Course removed from wishlist',
            // 'status' => $status,
        ], 200); // 204 no message
    }
}
