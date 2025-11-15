<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get recent notifications for navbar
     */
    public function getRecent()
    {
        $notifications = Notification::getRecent(auth()->id(), 6);
        $unreadCount = Notification::getUnreadCount(auth()->id());

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Get all notifications for user
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($notifications);
    }

    /**
     * Create a notification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|in:order,system,user,product',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|string|in:pending,warning,success,error',
            'data' => 'nullable|array',
        ]);

        $notification = Notification::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
            'data' => $notification,
        ], 201);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully',
        ]);
    }

    /**
     * Get notifications by type
     */
    public function getByType($type)
    {
        $notifications = Notification::getByType(auth()->id(), $type, 10);

        return response()->json($notifications);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount()
    {
        $messageCount = \App\Models\Message::getUnreadCount(auth()->id());
        $notificationCount = Notification::getUnreadCount(auth()->id());

        return response()->json([
            'messages' => $messageCount,
            'notifications' => $notificationCount,
            'total' => $messageCount + $notificationCount,
        ]);
    }
}
