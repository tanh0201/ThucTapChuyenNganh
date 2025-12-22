<?php

namespace App\Http\Controllers;

use App\Models\CustomerCare;
use App\Models\User;
use App\Mail\NewCustomerCareMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CustomerCareController extends Controller
{
    /**
     * Display the customer care page (contact form) - GET /customer-care
     */
    public function index()
    {
        return view('home.customer-care');
    }

    /**
     * Show the form for creating a new customer care request - GET /customer-care/create
     */
    public function create()
    {
        return view('home.customer-care');
    }

    /**
     * Store a new customer care request - POST /customer-care
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'Vui lòng nhập tên của bạn',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'subject.required' => 'Vui lòng nhập tiêu đề',
            'message.required' => 'Vui lòng nhập nội dung',
            'message.min' => 'Nội dung phải ít nhất 10 ký tự',
        ]);

        $ticket = CustomerCare::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        // Send notification email to admin
        try {
            $adminEmail = config('mail.from.address') ?? env('ADMIN_EMAIL', 'admin@petsam.local');
            Mail::to($adminEmail)->send(new NewCustomerCareMail($ticket));
        } catch (\Exception $e) {
            Log::error('Failed to send new support ticket notification: ' . $e->getMessage());
        }

        return redirect()->route('customer-care.my-tickets')->with('success', 'Yêu cầu của bạn đã được gửi thành công. Chúng tôi sẽ sớm liên hệ với bạn!');
    }

    /**
     * Display the specified ticket - GET /customer-care/{customerCare}
     */
    public function show(CustomerCare $customerCare)
    {
        // Check if user owns this ticket or is admin
        if (Auth::id() !== $customerCare->user_id && !Auth::user()?->role_id == 1) {
            abort(403);
        }

        return view('home.ticket-detail', compact('customerCare'));
    }

    /**
     * Show the form for editing (not used for customer care)
     */
    public function edit(CustomerCare $customerCare)
    {
        abort(404);
    }

    /**
     * Update the specified resource (not used for customer care)
     */
    public function update(Request $request, CustomerCare $customerCare)
    {
        abort(404);
    }

    /**
     * Delete ticket - DELETE /customer-care/{customerCare}
     */
    public function destroy(CustomerCare $customerCare)
    {
        if (Auth::id() !== $customerCare->user_id) {
            abort(403);
        }

        $customerCare->delete();
        return redirect()->route('customer-care.my-tickets')->with('success', 'Yêu cầu đã được xóa');
    }

    /**
     * Show user's own tickets/requests - Custom route
     */
    public function myTickets()
    {
        $tickets = null;
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user) {
                $tickets = $user->customerCareTickets()
                    ->latest()
                    ->paginate(10);
            }
        }
        return view('home.my-tickets', compact('tickets'));
    }
}

