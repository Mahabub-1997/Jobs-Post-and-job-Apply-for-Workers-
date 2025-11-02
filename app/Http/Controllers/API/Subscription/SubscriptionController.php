<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\TradeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Assign a subscription to the authenticated user's trade applications
     * and return a redirect URL to the payment page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        // Find the selected subscription
        $subscription = Subscription::findOrFail($request->subscription_id);

        // Update user's trade applications
        TradeApplication::where('user_id', Auth::id())
            ->update([
                'subscription_id' => $subscription->id,
            ]);

        // Redirect URL (payment page)
        $paymentUrl = url('/payment'); // replace with your actual payment page URL

        return response()->json([
            'status' => 'success',
            'message' => 'Trade applications updated successfully',
            'data' => [
                'subscription_id' => $subscription->id,
                'user_id'         => Auth::id(),
                'redirect_url'    => $paymentUrl, // frontend can use this to redirect
            ]
        ], 200);
    }
}

