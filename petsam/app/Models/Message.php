<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'subject',
        'body',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the sender of the message
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get the receiver of the message
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get unread messages for a user
     */
    public static function getUnreadCount($userId)
    {
        return self::where('to_user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get recent messages for a user
     */
    public static function getRecent($userId, $limit = 10)
    {
        return self::where('to_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->with('fromUser')
            ->get();
    }
}
