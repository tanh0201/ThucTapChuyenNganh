<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Get all messages for current user
     */
    public function index()
    {
        $messages = Message::where('to_user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($messages);
    }

    /**
     * Get recent messages for navbar
     */
    public function getRecent()
    {
        $messages = Message::getRecent(auth()->id(), 5);
        $unreadCount = Message::getUnreadCount(auth()->id());

        return response()->json([
            'messages' => $messages,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Store a new message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $validated['to_user_id'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 201);
    }

    /**
     * Show a specific message
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // Check authorization
        if ($message->to_user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Mark as read
        if (!$message->is_read) {
            $message->markAsRead();
        }

        return response()->json($message->load('fromUser'));
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);

        if ($message->to_user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
        ]);
    }

    /**
     * Delete a message
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->to_user_id !== auth()->id() && $message->from_user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully',
        ]);
    }

    /**
     * Mark all messages as read
     */
    public function markAllAsRead()
    {
        Message::where('to_user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All messages marked as read',
        ]);
    }
}
