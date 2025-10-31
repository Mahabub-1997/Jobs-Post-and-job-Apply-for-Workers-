<?php

namespace App\Http\Controllers\Web\QuestionOptions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the question options.
     */
    public function index()
    {
        $options = QuestionOption::with('question.category')->latest()->paginate(10);

        // Attach question text from category JSON
        foreach ($options as $option) {
            $category = $option->category;
            $questionText = '';
            if ($category && $category->questions) {
                foreach ($category->questions as $q) {
                    if ($q['id'] == $option->question_id) {
                        $questionText = $q['question_text'];
                        break;
                    }
                }
            }
            $option->question_text = $questionText;
        }

        return view('backend.layouts.jobsPost.questionOptions.list', compact('options'));
    }

    /**
     * Show the form for creating a new question option.
     */
    public function create()
    {
        $categories = Category::all();

        // Flatten questions to a collection
        $questions = collect();
        foreach ($categories as $category) {
            if ($category->questions) {
                foreach ($category->questions as $q) {
                    $questions->push([
                        'id' => $q['id'],
                        'question_text' => $q['question_text'],
                        'category_name' => $category->name,
                    ]);
                }
            }
        }
        return view('backend.layouts.jobsPost.questionOptions.add', compact('questions'));
    }

    /**
     * Store a newly created question option in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_text.*' => 'required|string|max:255',
        ]);

        QuestionOption::create([
            'question_id' => $request->question_id,
            'option_text' => $request->option_text, // JSON casted automatically
        ]);

        return redirect()
            ->route('question-options.index')
            ->with('success', 'Options created successfully.');
    }

    /**
     * Show the form for editing a question option.
     */
    public function edit($id)
    {
        // Find the option by ID
        $questionOption = QuestionOption::findOrFail($id);

        // Get all questions with category info
        $questions = Question::with('category')
            ->get()
            ->map(function($q) {
                return [
                    'id' => $q->id,
                    'question_text' => $q->question_text,
                    'category_name' => $q->category->name ?? 'N/A'
                ];
            });

        return view('backend.layouts.jobsPost.questionOptions.edit', compact('questionOption', 'questions'));
    }

    /**
     * Update the specified question option in storage.
     */
    public function update(Request $request, $id)
    {
        $questionOption = QuestionOption::findOrFail($id);

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_text.*' => 'required|string|max:255',
        ]);

        $questionOption->update([
            'question_id' => $request->question_id,
            'option_text' => $request->option_text, // JSON cast will handle array
        ]);

        return redirect()->route('question-options.index')
            ->with('success', 'Question options updated successfully.');
    }

    /**
     * Remove the specified question option from storage.
     */
    public function destroy($id)
    {
        $questionOption = QuestionOption::findOrFail($id);
        $questionOption->delete();

        return redirect()
            ->route('question-options.index')
            ->with('success', 'Options deleted successfully.');
    }
}
