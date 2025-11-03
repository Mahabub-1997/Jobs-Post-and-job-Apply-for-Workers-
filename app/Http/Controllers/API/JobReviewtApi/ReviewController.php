<?php

namespace App\Http\Controllers\API\JobReviewtApi;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * JobPost-এ review Added
     */
    public function addReview(Request $request, $jobPostId)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job Post Could not found!'
            ], 404);
        }

        $review = Review::create([
            'job_post_id' => $jobPost->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Review Successfully added!',
            'data' => $review
        ]);
    }

    /**
     * JobPost-for review
     */

    public function listReviews($jobPostId)
    {
        $jobPost = JobPost::with('reviews.user')->find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job Post Could not found!'
            ], 404);
        }

        $reviews = $jobPost->reviews->map(function ($review) {
            if ($review->user && !empty($review->user->profile_image)) {
                // profile_image full URL
                $review->user->profile_image = url('storage/' . $review->user->profile_image);
            }
            return $review;
        });

        return response()->json([
            'status' => 'success',
            'data' => $reviews
        ]);
    }
}
