<?php

namespace App\Http\Controllers\API\CMS\ContactImage;

use App\Http\Controllers\Controller;
use App\Models\ContactImage;
use Illuminate\Http\Request;

class ContactImageApiController extends Controller
{
    /**
     * Get all contact images.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = ContactImage::latest()->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'image_url' => asset('storage/' . $image->image),
                'created_at' => $image->created_at->toDateTimeString(),
            ];
        });

        return response()->json($images);
    }
}
