<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmailLogController extends Controller
{
    /**
     * Display a listing of email logs
     */
    public function index(Request $request)
    {
        $query = EmailLog::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('mailable_class', 'like', "%{$request->type}%");
        }

        // Filter by email or subject
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('to_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Get email logs with pagination
        $emailLogs = $query->latest()->paginate(20);

        // Get statistics
        $stats = [
            'sent' => EmailLog::where('status', 'sent')->count(),
            'failed' => EmailLog::where('status', 'failed')->count(),
            'sending' => EmailLog::where('status', 'sending')->count(),
        ];

        return view('admin.email-logs.index', [
            'emailLogs' => $emailLogs,
            'stats' => $stats,
        ]);
    }

    /**
     * Delete email log
     */
    public function destroy(EmailLog $emailLog)
    {
        $emailLog->delete();

        return back()->with('success', 'Xóa email log thành công');
    }

    /**
     * Delete failed email logs
     */
    public function deleteFailed()
    {
        EmailLog::where('status', 'failed')->delete();

        return back()->with('success', 'Xóa tất cả email log thất bại thành công');
    }

    /**
     * Clear old logs (older than 30 days)
     */
    public function clearOldLogs()
    {
        EmailLog::where('created_at', '<', now()->subDays(30))->delete();

        return back()->with('success', 'Xóa email log cũ thành công');
    }

    /**
     * Quick reply to email
     */
    public function quickReply(Request $request)
    {
        $request->validate([
            'to_email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        try {
            // Send email
            \Illuminate\Support\Facades\Mail::raw($request->message, function ($mail) use ($request) {
                $mail->to($request->to_email)
                     ->subject($request->subject);
            });

            // Log email
            EmailLog::create([
                'to_email' => $request->to_email,
                'subject' => $request->subject,
                'mailable_class' => 'QuickReplyMail',
                'body' => $request->message,
                'status' => 'sent',
            ]);

            return back()->with('success', 'Phản hồi được gửi thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi gửi phản hồi: ' . $e->getMessage());
        }
    }
}
