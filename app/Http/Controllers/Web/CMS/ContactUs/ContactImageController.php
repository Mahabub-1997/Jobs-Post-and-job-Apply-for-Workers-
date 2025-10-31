<?php

namespace App\Http\Controllers\Web\CMS\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactImage;
use Illuminate\Http\Request;

class ContactImageController extends Controller
{
    /**
     * Display a listing of contact images with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contactImages = ContactImage::latest()->paginate(12);

        return view('backend.layouts.cms.contact_us.image-list', compact('contactImages'));
    }

    /**
     * Store a newly uploaded contact image in storage and database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Store the image in "public/contact-images" folder
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('contact-images', 'public');
        } else {
            return back()->withErrors(['image' => 'No image file found.']);
        }

        // Save the image path in the database
        ContactImage::create([
            'image' => $path,
        ]);

        return redirect()
            ->route('web-contact-images.index')
            ->with('success', 'Contact image uploaded successfully.');
    }

    /**
     * Remove the specified contact image from storage and database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Retrieve the contact image or fail
        $contactImage = ContactImage::findOrFail($id);

        // Delete the file from storage if it exists
        if ($contactImage->image && file_exists(storage_path('app/public/' . $contactImage->image))) {
            unlink(storage_path('app/public/' . $contactImage->image));
        }

        // Delete the record from the database
        $contactImage->delete();

        return redirect()
            ->route('web-contact-images.index')
            ->with('success', 'Contact image deleted successfully.');
    }
}
