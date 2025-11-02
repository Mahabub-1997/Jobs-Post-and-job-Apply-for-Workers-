<?php

namespace App\Http\Controllers\Web\JobApply;

use App\Http\Controllers\Controller;
use App\Models\TradeApplication;
use Illuminate\Http\Request;

class JobApplyController extends Controller
{
    /**
     * Display a paginated list of trade applications.
     * Admin can see all applications, tradesperson sees only their own.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $applications = TradeApplication::with('user', 'category', 'subscription')
                ->paginate(10); // <-- use paginate
        } else {
            $applications = TradeApplication::with('category', 'subscription')
                ->where('user_id', $user->id)
                ->paginate(10); // <-- use paginate
        }

        return view('backend.layouts.jobApply.list', compact('applications'));
    }
    /**
     * Toggle the status of a trade application (active/inactive).
     * Only admin can change status.
     *
     * @param int $id
     */
    public function updateStatus($id)
    {
        $application = TradeApplication::findOrFail($id);

        // Toggle status
        $application->status = $application->status === 'active' ? 'inactive' : 'active';
        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');

    }
}
