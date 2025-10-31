<?php

namespace App\Http\Controllers\API\CMS\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a paginated list of contact messages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $contacts = ContactUs::latest()->paginate(15);

            return response()->json([
                'status' => 'success',
                'message' => 'Contact list retrieved successfully.',
                'data' => $contacts->items(),
                'pagination' => [
                    'current_page' => $contacts->currentPage(),
                    'last_page'    => $contacts->lastPage(),
                    'per_page'     => $contacts->perPage(),
                    'total'        => $contacts->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching contact list: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve contact list.',
            ], 500);
        }
    }

    /**
     * Store a new contact message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'nullable|string|max:255',
                'email'      => 'required|email|max:255',
                'phone'      => 'nullable|string|max:50',
                'message'    => 'required|string',
            ]);

            $contact = ContactUs::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Contact submitted successfully.',
                'data' => $contact,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'validation_error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing contact: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit contact.',
            ], 500);
        }
    }
}
