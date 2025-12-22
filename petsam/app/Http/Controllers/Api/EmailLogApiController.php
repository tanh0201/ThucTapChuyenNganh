<?php

namespace App\Http\Controllers\Api;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailLogApiController extends Controller
{
    /**
     * Get recent email logs
     */
    public function recent(Request $request)
    {
        $limit = $request->query('limit', 10);

        $logs = EmailLog::latest()
            ->limit($limit)
            ->get(['id', 'to_email', 'subject', 'status', 'created_at']);

        return response()->json($logs);
    }

    /**
     * Get email log statistics
     */
    public function stats()
    {
        return response()->json([
            'total' => EmailLog::count(),
            'sent' => EmailLog::where('status', 'sent')->count(),
            'failed' => EmailLog::where('status', 'failed')->count(),
            'sending' => EmailLog::where('status', 'sending')->count(),
            'today' => EmailLog::whereDate('created_at', today())->count(),
        ]);
    }
}
