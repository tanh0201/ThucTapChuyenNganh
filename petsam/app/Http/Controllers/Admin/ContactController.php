<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display list of contacts
     */
    public function index(Request $request)
    {
        $contacts = Contact::query()
            ->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('subject', 'like', "%{$request->search}%");
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'responded' => Contact::where('status', 'responded')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Show contact details
     */
    public function show(Contact $contact)
    {
        // Mark as read
        $contact->update(['status' => 'read']);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark as responded
     */
    public function markResponded(Contact $contact)
    {
        $contact->update(['status' => 'responded']);

        return back()->with('success', 'Đã đánh dấu là đã phản hồi!');
    }

    /**
     * Delete contact
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Đã xóa liên hệ!');
    }
}
