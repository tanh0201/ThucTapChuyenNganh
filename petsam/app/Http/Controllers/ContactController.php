<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\NewContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index()
    {
        return view('home.contact');
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contact = Contact::create($validated);

        // Send notification email to admin
        try {
            $adminEmail = config('mail.from.address') ?? env('ADMIN_EMAIL', 'admin@petsam.local');
            Mail::to($adminEmail)->send(new NewContactMail($contact));
        } catch (\Exception $e) {
            Log::error('Failed to send new contact notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
}
