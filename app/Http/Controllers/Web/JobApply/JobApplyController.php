<?php

namespace App\Http\Controllers\Web\JobApply;

use App\Http\Controllers\Controller;
use App\Models\JobApply;
use App\Models\JobPost;
use App\Models\TradeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplyController extends Controller
{
    /**
     * Display a paginated list of trade applications.
     * Admin can see all applications, tradesperson sees only their own.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        $applications = $user->hasRole('admin')
            ? TradeApplication::with(['user', 'category', 'subscription'])->paginate(10)
            : TradeApplication::with(['category', 'subscription'])
                ->where('user_id', $user->id)
                ->paginate(10);

        return view('backend.layouts.jobApply.list', compact('applications'));
    }

    /**
     * Toggle the status of a trade application (active/inactive).
     * Only admin can change status.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(int $id)
    {
        $application = TradeApplication::findOrFail($id);

        // Toggle status
        $application->status = $application->status === 'active' ? 'inactive' : 'active';
        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Show all job posts for enrollment.
     * Tradesperson can see all available jobs.
     *
     * @return \Illuminate\View\View
     */
    public function registration()
    {
        $user = Auth::user();
        $jobPosts = JobPost::with(['user', 'category'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('backend.layouts.jobApply.index', compact('jobPosts', 'user'));
    }

    /**
     * Enroll the authenticated tradesperson in a job.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(int $id)
    {
        $user = Auth::user();

        // Ensure only tradespersons can apply
        if (! $user->hasRole('tradesperson')) {
            return redirect()->route('job-registration.index')
                ->with('error', 'Only tradespersons can apply!');
        }

        $jobPost = JobPost::find($id);
        if (! $jobPost) {
            return redirect()->route('job-registration.index')
                ->with('error', 'The job was not found.');
        }

        // Check if the user already applied
        $alreadyApplied = $jobPost->applicants()->where('user_id', $user->id)->exists();
        if ($alreadyApplied) {
            return redirect()->route('job-registration.index')
                ->with('error', 'You have already applied for this job.');
        }

        // Attach user to job applicants
        $jobPost->applicants()->attach($user->id);

        return redirect()->route('job-registration.index')
            ->with('success', 'You have successfully applied for this job!');
    }
}
