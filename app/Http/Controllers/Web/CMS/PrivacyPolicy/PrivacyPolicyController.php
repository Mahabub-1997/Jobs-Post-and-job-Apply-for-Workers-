<?php

namespace App\Http\Controllers\Web\CMS\PrivacyPolicy;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of privacy policies.
     */
    public function index()
    {
        $policies = PrivacyPolicy::latest()->paginate(10);
        return view('backend.layouts.cms.privacy.list', compact('policies'));
    }

    /**
     * Show the form for creating a new privacy policy.
     */
    public function create()
    {
        return view('backend.layouts.cms.privacy.add');
    }

    /**
     * Store a newly created privacy policy in storage.
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

        PrivacyPolicy::create([
            'title' => $request->title,
            'content' => array_map(
                fn($sub, $desc) => ['subtitle' => $sub, 'description' => $desc],
                $request->sub_title,
                $request->description
            ),
        ]);

        return redirect()->route('privacy.index')
            ->with('success', 'Privacy Policy created successfully.');
    }

    /**
     * Show the form for editing the specified privacy policy.
     */
    public function edit($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        return view('backend.layouts.cms.privacy.edit', compact('policy'));
    }

    /**
     * Update the specified privacy policy in storage.
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

        $policy = PrivacyPolicy::findOrFail($id);
        $policy->update([
            'title' => $request->title,
            'content' => array_map(
                fn($sub, $desc) => ['subtitle' => $sub, 'description' => $desc],
                $request->sub_title,
                $request->description
            ),
        ]);

        return redirect()->route('privacy.index')
            ->with('success', 'Privacy Policy updated successfully.');
    }

    /**
     * Remove the specified privacy policy from storage.
     */
    public function destroy($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $policy->delete();

        return redirect()->route('privacy.index')
            ->with('success', 'Privacy Policy deleted successfully.');
    }

    /**
     * Display a single privacy policy (API response).
     */
    public function show($id)
    {
        $policy = PrivacyPolicy::find($id);

        if (!$policy) {
            return response()->json([
                'status' => 'error',
                'message' => 'Privacy Policy not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $policy
        ]);
    }
}
