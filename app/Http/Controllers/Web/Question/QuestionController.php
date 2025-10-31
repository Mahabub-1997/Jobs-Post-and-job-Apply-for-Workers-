<?php

namespace App\Http\Controllers\Web\Question;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions per category.
     */
    public function index()
    {
        // Load all categories with their questions
        $questions = Question::with('category')->latest()->paginate(10);
        return view('backend.layouts.jobsPost.questions.list', compact('questions'));
    }

    /**
     * Show the form for creating new questions.
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.layouts.jobsPost.questions.add', compact('categories'));
    }

    /**
     * Store new questions in JSON format.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string|max:255',
        ]);

        Question::create([
            'category_id' => $request->category_id,
            'questions' => $request->questions
        ]);

        return redirect()->route('questions.index')->with('success', 'Questions added successfully.');
    }

    /**
     * Show the form for editing existing questions.
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();

        return view('backend.layouts.jobsPost.questions.edit', compact('question', 'categories'));
    }

    /**
     * Update questions JSON for a category.
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string|max:255',
        ]);

        $question->update([
            'category_id' => $request->category_id,
            'questions' => $request->questions,
        ]);

        return redirect()->route('questions.index')->with('success', 'Questions updated successfully.');
    }

    /**
     * Remove questions for a category.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Questions deleted successfully.');
    }
}
