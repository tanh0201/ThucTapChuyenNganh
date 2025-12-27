<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactResponseMail;
use Illuminate\Support\Facades\Log;


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
        // Mark as read only if not already responded
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        // Refresh from database to ensure we have latest data
        $contact = Contact::find($contact->id);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark as responded
     */
    public function markResponded(Contact $contact)
    {
        $contact->update(['status' => 'responded']);

        return redirect()->route('admin.contacts.show', $contact->id)->with('success', 'Đã đánh dấu là đã phản hồi!');
    }

    /**
     * Send response to contact
     */
    public function respond(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'response_message' => 'required|string|min:10',
        ], [
            'response_message.required' => 'Vui lòng nhập nội dung phản hồi',
            'response_message.min' => 'Nội dung phản hồi phải ít nhất 10 ký tự',
        ]);

        // Update status and save response
        $contact->update([
            'status' => 'responded',
            'response_message' => $validated['response_message'],
            'responded_at' => now(),
        ]);

        // Try to send email response
        try {
            Mail::to($contact->email)->send(new ContactResponseMail($contact, $validated['response_message']));
        } catch (\Exception $e) {
            // Log the error but don't fail the response
            Log::error('Failed to send contact response email: ' . $e->getMessage());
        }

        return redirect()->route('admin.contacts.show', $contact->id)->with('success', 'Phản hồi đã được ghi nhận và gửi thành công!');
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
