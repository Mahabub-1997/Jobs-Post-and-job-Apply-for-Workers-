<?php

namespace App\Http\Controllers\API\JobPostApi;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class JobPostApiController extends Controller
{
    /**
     * API: List all JobPosts
     */
    public function apiIndex()
    {
        $jobPosts = JobPost::with(['user', 'category'])->get();

        $jobPosts = $jobPosts->map(function ($post) {
            // Convert JobPost image to full URL
            if ($post->image) {
                $post->image = asset('storage/' . $post->image);
            }

            // Convert User image to full URL
            if (!empty($post->user) && $post->user->image) {
                $post->user->image = asset('storage/' . $post->user->image);
            }

            // Convert Category image to full URL
            if (!empty($post->category) && $post->category->image) {
                $post->category->image = asset('storage/' . $post->category->image);
            }

            // Prepare questions and options
            $post->questions_data = [];
            $questionIds = is_string($post->questions_id)
                ? json_decode($post->questions_id, true)
                : $post->questions_id;

            if (!empty($questionIds) && is_array($questionIds)) {
                foreach ($questionIds as $qid) {
                    if (!is_numeric($qid)) continue;

                    $question = Question::find($qid);
                    if ($question) {
                        $options = QuestionOption::where('question_id', $question->id)
                            ->pluck('option_text');
                        $post->questions_data[] = [
                            'question' => $question->questions,
                            'options' => $options->toArray()
                        ];
                    }
                }
            }

            return $post;
        });

        return response()->json([
            'status' => 'success',
            'data' => $jobPosts
        ]);
    }

    /**
     * API: Get single JobPost by ID
     */
    public function apiShow($id)
    {
        $jobPost = JobPost::with(['user', 'category'])->find($id);

        if (!$jobPost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job Post not found'
            ], 404);
        }

        // Convert JobPost image to full URL
        if ($jobPost->image) {
            $jobPost->image = asset('storage/' . $jobPost->image);
        }

        // Convert User image to full URL
        if (!empty($jobPost->user) && $jobPost->user->image) {
            $jobPost->user->image = asset('storage/' . $jobPost->user->image);
        }

        // Convert Category image to full URL
        if (!empty($jobPost->category) && $jobPost->category->image) {
            $jobPost->category->image = asset('storage/' . $jobPost->category->image);
        }

        // Prepare questions and options
        $jobPost->questions_data = [];

        $questionIds = is_string($jobPost->questions_id)
            ? json_decode($jobPost->questions_id, true)
            : $jobPost->questions_id;

        if (!empty($questionIds) && is_array($questionIds)) {
            foreach ($questionIds as $qid) {
                if (!is_numeric($qid)) continue;

                $question = Question::find($qid);
                if ($question) {
                    $options = QuestionOption::where('question_id', $question->id)
                        ->pluck('option_text');
                    $jobPost->questions_data[] = [
                        'question' => $question->questions,
                        'options' => $options->toArray()
                    ];
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $jobPost
        ]);
    }
}
