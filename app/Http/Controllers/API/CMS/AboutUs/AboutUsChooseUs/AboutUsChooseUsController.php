<?php

namespace App\Http\Controllers\API\CMS\AboutUs\AboutUsChooseUs;

use App\Http\Controllers\Controller;
use App\Models\AboutUsChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsChooseUsController extends Controller
{
    // GET all entries
    public function index()
    {
        $chooseUs = AboutUsChooseUs::latest()->get();
        return response()->json($chooseUs);
    }

    // POST a new entry
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sub_items' => 'nullable|array',
            'sub_items.*.sub_title' => 'required_with:sub_items|string|max:255',
            'sub_items.*.icon' => 'nullable|string|max:255',
            'sub_items.*.description' => 'required_with:sub_items|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $chooseUs = AboutUsChooseUs::create([
            'title' => $request->title,
            'sub_items' => $request->sub_items,
        ]);

        return response()->json($chooseUs, 201);
    }
}
