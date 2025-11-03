<?php

namespace App\Http\Controllers\API\TermApi;

use App\Http\Controllers\Controller;
use App\Models\Term;

class TermApiController extends Controller
{
    /**
     * Return all terms as JSON.
     */
    public function index()
    {
        $terms = Term::latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $terms
        ]);
    }
    /**
     * Display a single term by ID.
     */
    public function show($id)
    {
        try {
            $term = Term::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $term
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Term not found'
            ], 404);
        }
    }
}
