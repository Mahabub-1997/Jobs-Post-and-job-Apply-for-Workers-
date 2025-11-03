<?php

namespace App\Http\Controllers\Web\CMS\TermsAndConditions;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of terms.
     */
    public function index()
    {
        $terms = Term::latest()->paginate(10);
        return view('backend.layouts.cms.terms.list', compact('terms'));
    }
    /**
     * create a Terms and Conditions.
     */
    public function create()
    {
        // Return the create view
        return view('backend.layouts.cms.terms.add');
    }
    /**
     * store  the form for insert the specified term.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'nullable|string',
        ]);

        // Combine sub_title and description into content array
        $content = [];
        foreach ($request->sub_title as $index => $subtitle) {
            $content[] = [
                'subtitle' => $subtitle,
                'description' => $request->description[$index] ?? null,
            ];
        }

        Term::create([
            'title' => $request->title,
            'content' => $content,
        ]);

        return redirect()->route('terms.index')
            ->with('success', 'Term & Condition created successfully.');
    }
    /**
     * Show the form for editing the specified term.
     */
    public function edit($id)
    {
        // Fetch the term or throw 404
        $term = Term::findOrFail($id);

        // Pass the term to the edit view
        return view('backend.layouts.cms.terms.edit', compact('term'));
    }
    /**
     * Update the specified term from storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'nullable|string',
        ]);

        $term = Term::findOrFail($id);

        $content = [];
        foreach ($request->sub_title as $i => $st) {
            $content[] = [
                'subtitle' => $st,
                'description' => $request->description[$i] ?? null,
            ];
        }

        $term->update([
            'title' => $request->title,
            'content' => $content,
        ]);

        return redirect()->route('terms.index')->with('success', 'Term & Condition updated successfully.');
    }
    /**
     * Remove the specified term from storage.
     */
    public function destroy($id)
    {
        // Find the term or fail
        $term = Term::findOrFail($id);

        // Delete the term
        $term->delete();


        return redirect()->route('terms.index')
            ->with('success', 'Term & Condition deleted successfully.');
    }
}
