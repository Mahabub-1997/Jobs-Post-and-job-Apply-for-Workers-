<?php

namespace App\Http\Controllers\Web\JobApplication;

use App\Http\Controllers\Controller;
use App\Models\JobApply;
use Illuminate\Http\Request;

class AdminJobApplicationController extends Controller
{
    /**
     * Display a paginated list of job applications.
     * Admin can see all applications, tradesperson sees only their own.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admin: Show all applications
            $appliedJobs = JobApply::with('jobPost.category', 'user')
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('tradesperson')) {
            // Tradesperson: Show only own applications
            $appliedJobs = JobApply::with('jobPost.category')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            // Unauthorized user
            abort(403, 'Unauthorized access');
        }

        return view('backend.layouts.job-registration.list', compact('appliedJobs'));
    }

    /**
     * Update the status of a specific job application.
     * Only admins can update status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Applied,Approved,Rejected',
        ]);

        $jobApply = JobApply::findOrFail($id);
        $jobApply->status = $request->status;
        $jobApply->save();

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
}
