<?php

namespace App\Http\Controllers\API\CMS\AboutUs\AboutUsBanner;

use App\Http\Controllers\Controller;
use App\Models\AboutUsBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsBannerController extends Controller
{
    /**
     * List all banners
     */
    public function index()
    {
        $banners = AboutUsBanner::all()->map(function ($banner) {
            $banner->image = $banner->image ? asset('storage/' . $banner->image) : null;
            return $banner;
        });

        return response()->json($banners);
    }

    /**
     * Store a new banner
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('contact-us-banners', 'public');
        }

        $banner = AboutUsBanner::create([
            'image' => $path,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Return full URL for image
        $banner->image = $banner->image ? asset('storage/' . $banner->image) : null;

        return response()->json($banner, 201);
    }

}
