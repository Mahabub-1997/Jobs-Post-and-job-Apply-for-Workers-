<?php

namespace App\Http\Controllers\Web\JobPost;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use App\Notifications\NewJobPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class JobPostController extends Controller
{
    /**
     * Display a paginated list of JobPosts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobPosts = JobPost::with(['user', 'category'])->paginate(10);

        return view('backend.layouts.jobsPost.jobPosts.list', compact('jobPosts'));
    }

    /**
     * Show the form for creating a new JobPost.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $users = User::role(['admin', 'homeowner'])->get();
        $categories = Category::all();
        $categoryId = $request->category ?? null;

        $questions = collect();
        $questionOptions = collect();

        if ($categoryId) {
            $questions = Question::where('category_id', $categoryId)
                ->with('options') // Ensure Question model has 'options' relationship
                ->get();

            $questionOptions = $questions->flatMap(fn($q) => $q->options);
        }

        return view('backend.layouts.jobsPost.jobPosts.add', compact(
            'categories',
            'users',
            'questions',
            'questionOptions',
            'categoryId'
        ));
    }

    /**
     * Store a newly created JobPost in storage and notify tradepersons.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'questions_id' => 'required|array',
            'question_options_id' => 'required|array',
            'location' => 'required|string',
            'message' => 'nullable|string',
            'image' => 'nullable|image',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('job_images', 'public');
        }

        $jobPost = JobPost::create($data);

        // Notify all tradepersons
        $tradepersons = User::role('tradesperson')->get();
        if ($tradepersons->isNotEmpty()) {
            Notification::send($tradepersons, new NewJobPostNotification($jobPost));
        }

        return redirect()
            ->route('job_posts.index')
            ->with('success', 'Job Post created successfully & notifications sent!');
    }

    /**
     * Show the form for editing a JobPost.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function edit(int $id, Request $request)
    {
        $jobPost = JobPost::findOrFail($id);
        $users = User::all();
        $categories = Category::all();
        $categoryId = $request->get('category') ?? $jobPost->category_id;

        $questions = Question::where('category_id', $categoryId)->get();
        $questionOptions = QuestionOption::whereIn('question_id', $questions->pluck('id'))->get();

        return view('backend.layouts.jobsPost.jobPosts.edit', compact(
            'jobPost',
            'users',
            'categories',
            'categoryId',
            'questions',
            'questionOptions'
        ));
    }

    /**
     * Update the specified JobPost in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $jobPost = JobPost::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'questions_id' => 'required|array',
            'question_options_id' => 'required|array',
            'location' => 'required|string',
            'message' => 'nullable|string',
            'image' => 'nullable|image',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image update
        if ($request->hasFile('image')) {
            if ($jobPost->image && Storage::disk('public')->exists($jobPost->image)) {
                Storage::disk('public')->delete($jobPost->image);
            }
            $data['image'] = $request->file('image')->store('job_images', 'public');
        }

        $jobPost->update($data);

        return redirect()->route('job_posts.index')
            ->with('success', 'Job Post updated successfully.');
    }

    /**
     * Remove the specified JobPost from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $jobPost = JobPost::findOrFail($id);

        // Delete image if exists
        if ($jobPost->image && Storage::disk('public')->exists($jobPost->image)) {
            Storage::disk('public')->delete($jobPost->image);
        }

        $jobPost->delete();

        return redirect()->route('job_posts.index')
            ->with('success', 'Job Post deleted successfully.');
    }
}
