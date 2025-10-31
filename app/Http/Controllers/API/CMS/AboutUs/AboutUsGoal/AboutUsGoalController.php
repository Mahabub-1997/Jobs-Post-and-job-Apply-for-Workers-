<?php

namespace App\Http\Controllers\API\CMS\AboutUs\AboutUsGoal;

use App\Http\Controllers\Controller;
use App\Models\AboutUsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsGoalController extends Controller
{
    /**
     * Display a listing of all About Us Goals.
     */
    public function index()
    {
        // Fetch all About Us Goals (latest first)
        $aboutUsGoals = AboutUsGoal::latest()->get();

        // Format data: add full image URL and decode goals JSON
        $aboutUsGoals->transform(function ($item) {
            $item->image = asset('storage/' . $item->image);
            $item->goals = json_decode($item->goals);
            return $item;
        });

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'About Us Goals retrieved successfully.',
            'data' => $aboutUsGoals,
        ], 200);
    }

    /**
     * Store a newly created About Us Goal record.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'goal.title' => 'required|array|min:1',
            'goal.description' => 'required|array|min:1',
            'goal.title.*' => 'required|string|max:255',
            'goal.description.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Combine titles & descriptions into a JSON-friendly array
        $goals = [];
        foreach ($request->goal['title'] as $index => $title) {
            $goals[] = [
                'title' => $title,
                'description' => $request->goal['description'][$index] ?? '',
            ];
        }

        // Upload image to public storage
        $imagePath = $request->file('image')->store('about-us-goals', 'public');

        // Create new record in the database
        $aboutUsGoal = AboutUsGoal::create([
            'image' => $imagePath,
            'goals' => json_encode($goals, JSON_UNESCAPED_UNICODE),
        ]);

        // Format response
        $aboutUsGoal->image = asset('storage/' . $aboutUsGoal->image);
        $aboutUsGoal->goals = json_decode($aboutUsGoal->goals);

        return response()->json([
            'success' => true,
            'message' => 'About Us Goal created successfully.',
            'data' => $aboutUsGoal,
        ], 201);
    }
}

