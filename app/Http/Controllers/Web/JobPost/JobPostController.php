<?php

namespace App\Http\Controllers\Web\JobPost;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobPostController extends Controller
{
    /**
     * JobPost list
     */
    public function index()
    {
        $jobPosts = JobPost::with('user', 'category')->paginate(10);
        return view('backend.layouts.jobsPost.jobPosts.list', compact('jobPosts'));
    }

    /**
     * Create Form
     */
    public function create(Request $request)
    {
//        $users = User::all();
        $users = User::role(['admin','homeowner'])->get();
        $categories = Category::all();

        $categoryId = $request->category ?? null;

        $questions = collect();
        $questionOptions = collect();

        if($categoryId){
            $questions = Question::where('category_id', $categoryId)
                ->with('options') // Question model-এ options relationship থাকতে হবে
                ->get();

            $questionOptions = $questions->flatMap(function($q){
                return $q->options;
            });
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
     * JobPost Save
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

        // Image upload
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('job_images','public');
        }

        JobPost::create($data);

        return redirect()->route('job_posts.index')->with('success', 'Job Post created successfully.');
    }

    /**
     * JobPost Edit Form
     */
    public function edit($id, Request $request)
    {
        $jobPost = JobPost::findOrFail($id);
        $users = User::all();
        $categories = Category::all();

        $categoryId = $request->get('category') ?? $jobPost->category_id;

        // Selected category অনুযায়ী Questions & Options
        $questions = Question::where('category_id', $categoryId)->get();
        $questionOptions = QuestionOption::whereIn('question_id', $questions->pluck('id'))->get();

        return view('backend.layouts.jobsPost.jobPosts.edit', compact(
            'jobPost', 'users', 'categories', 'categoryId', 'questions', 'questionOptions'
        ));
    }

    /**
     * Update JobPost
     */
    public function update(Request $request, $id)
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

        // Image upload
        if ($request->hasFile('image')) {
            // পুরানো image delete করা
            if ($jobPost->image && Storage::disk('public')->exists($jobPost->image)) {
                Storage::disk('public')->delete($jobPost->image);
            }

            $data['image'] = $request->file('image')->store('job_images', 'public');
        }

        $jobPost->update($data);

        return redirect()->route('job_posts.index')->with('success', 'Job Post updated successfully.');
    }
    /**
     * Delete JobPost
     */
    public function destroy($id)
    {
        $jobPost = JobPost::findOrFail($id);

        // Delete image from storage
        if ($jobPost->image && Storage::disk('public')->exists($jobPost->image)) {
            Storage::disk('public')->delete($jobPost->image);
        }

        $jobPost->delete();

        return redirect()->route('job_posts.index')->with('success', 'Job Post deleted successfully.');
    }
}
