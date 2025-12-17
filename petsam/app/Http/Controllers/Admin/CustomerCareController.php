<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCareController extends Controller
{
    /**
     * Display list of all customer care requests - GET /admin/customer-care
     */
    public function index(Request $request)
    {
        $query = CustomerCare::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name, email, subject
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $tickets = $query->paginate(15);
        $stats = [
            'total' => CustomerCare::count(),
            'pending' => CustomerCare::where('status', 'pending')->count(),
            'in_progress' => CustomerCare::where('status', 'in_progress')->count(),
            'resolved' => CustomerCare::where('status', 'resolved')->count(),
        ];

        return view('admin.customer-care.index', compact('tickets', 'stats'));
    }

    /**
     * Show the form for creating a new resource (not used)
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource (not used)
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Show ticket details - GET /admin/customer-care/{customerCare}
     */
    public function show(CustomerCare $customerCare)
    {
        return view('admin.customer-care.show', compact('customerCare'));
    }

    /**
     * Show the form for editing (not used)
     */
    public function edit(CustomerCare $customerCare)
    {
        abort(404);
    }

    /**
     * Update status - POST /admin/customer-care/{customerCare}/status
     */
    public function updateStatus(Request $request, CustomerCare $customerCare)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $customerCare->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

    /**
     * Send response to customer - POST /admin/customer-care/{customerCare}/respond
     */
    public function respond(Request $request, CustomerCare $customerCare)
    {
        $validated = $request->validate([
            'response' => 'required|string|min:10|max:5000',
            'status' => 'required|in:pending,in_progress,resolved',
        ], [
            'response.required' => 'Vui lòng nhập phản hồi',
            'response.min' => 'Phản hồi phải ít nhất 10 ký tự',
        ]);

        $customerCare->update([
            'response' => $validated['response'],
            'status' => $validated['status'],
            'responded_by' => Auth::id(),
            'responded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Phản hồi đã được gửi thành công');
    }

    /**
     * Remove the specified resource - DELETE /admin/customer-care/{customerCare}
     */
    public function destroy(CustomerCare $customerCare)
    {
        $customerCare->delete();
        return redirect()->route('admin.customer-care.index')->with('success', 'Xóa yêu cầu thành công');
    }
}
