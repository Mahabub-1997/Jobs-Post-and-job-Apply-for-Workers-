<?php

namespace App\Http\Controllers\API\PrivacyApi;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyApiController extends Controller
{
    /**
     * Return all terms as JSON.
     */
    public function index()
    {
        $policies = PrivacyPolicy::latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $policies
        ]);
    }
    /**
     * Display a single term by ID.
     */
    public function show(PrivacyPolicy $policy)
    {
        return response()->json([
            'status' => 'success',
            'data' => $policy
        ]);
    }
}
