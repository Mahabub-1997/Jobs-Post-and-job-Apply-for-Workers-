<?php

namespace App\Http\Controllers\API\CMS\AboutUs\AboutUsTestimonial;

use App\Http\Controllers\Controller;
use App\Models\AboutUsTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsTestimonialController extends Controller
{
    /**
     * Display a listing of all About Us Testimonials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $testimonials = AboutUsTestimonial::latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $testimonials,
        ]);
    }

    /**
     * Store a newly created About Us Testimonial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'title'                     => 'required|string|max:255',
            'testimonials'              => 'required|array',
            'testimonials.*.ratingNumber'=> 'required|numeric|min:0|max:5',
            'testimonials.*.description'=> 'required|string',
            'testimonials.*.name'       => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create testimonial
        $testimonial = AboutUsTestimonial::create([
            'title'        => $request->title,
            'testimonials' => $request->testimonials,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Testimonial created successfully.',
            'data'    => $testimonial,
        ], 201);
    }
}
