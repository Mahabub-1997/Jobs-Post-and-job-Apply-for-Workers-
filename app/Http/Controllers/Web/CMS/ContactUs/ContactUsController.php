<?php

namespace App\Http\Controllers\Web\CMS\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactImage;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Show all contact messages in the admin panel.
     */
    public function index()
    {
        $contacts = ContactUs::latest()->paginate(20);
        $contactImages = ContactImage::latest()->paginate(12); // Contact images

        return view('backend.layouts.cms.contact_us.list', compact('contacts', 'contactImages'));
    }

    /**
     * Show single contact details.
     */
    public function show($id)
    {
        $contact = ContactUs::findOrFail($id);

        return view('backend.layouts.cms.contact_us.show', compact('contact'));
    }

    /**
     * Optional: Delete a contact message.
     */
    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact message deleted successfully.');
    }
}
