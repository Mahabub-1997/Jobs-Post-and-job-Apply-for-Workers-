<?php

namespace App\Http\Controllers\API\JobApplyApi;

use App\Http\Controllers\Controller;
use App\Models\TradeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TradeApplicationController extends Controller
{
    /**
     * GET: List all trade applications
     * Admin: sees all applications
     * Tradesperson: sees only their own applications
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $applications = TradeApplication::with(['user', 'category', 'subscription'])->get();
        } else {
            $applications = TradeApplication::with(['category', 'subscription'])
                ->where('user_id', $user->id)
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $applications
        ]);
    }

    /**
     * POST: Create a new trade application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_name' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'upload_trade_license' => 'nullable|file|mimes:pdf,jpg,png',
            'upload_business_insurance' => 'nullable|file|mimes:pdf,jpg,png',
            'passport_or_driving_license' => 'nullable|file|mimes:pdf,jpg,png',
            'certificate' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        foreach ([
                     'upload_trade_license',
                     'upload_business_insurance',
                     'passport_or_driving_license',
                     'certificate'
                 ] as $fileField) {

            if ($request->hasFile($fileField)) {
                $filePath = $request->file($fileField)->store('trade_applications', 'public');
                $data[$fileField] = asset('storage/' . $filePath);
            }
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'inactive';

        $application = TradeApplication::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully',
            'data' => $application,
            'redirect_url' => url('/api/subscriptions')
        ], 201);
    }
}
