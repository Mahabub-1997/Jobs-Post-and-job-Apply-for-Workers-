<?php

namespace App\Http\Controllers\API\CMS\AboutUs\AboutUsValue;

use App\Http\Controllers\Controller;
use App\Models\AboutUsValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsValueController extends Controller
{
    /**
     * GET all aboutUsValue
     */
    public function index()
    {
        $items = AboutUsValue::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'AboutUsValues retrieved successfully.',
            'data' => $items, // sub_items is auto-cast to array by model
        ], 200);
    }

    /**
     * POST create aboutUsValue
     * Expected JSON:
     * {
     *   "title": "Main title",
     *   "description": "Main description",
     *   "sub": [
     *     { "subtitle": "Sub 1", "description": "Desc 1" },
     *     { "subtitle": "Sub 2", "description": "Desc 2" }
     *   ]
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sub' => 'nullable|array',
            'sub.*.subtitle' => 'required_with:sub|string|max:255',
            'sub.*.description' => 'required_with:sub|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Use provided sub array or empty array
        $subItems = $request->input('sub', []);

        $item = AboutUsValue::create([
            'title' => $request->title,
            'description' => $request->description,
            'sub_items' => $subItems,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'AboutUsValue created successfully.',
            'data' => $item,
        ], 201);
    }
}
