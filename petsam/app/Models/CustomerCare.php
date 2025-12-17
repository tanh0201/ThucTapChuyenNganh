<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCare extends Model
{
    use HasFactory;

    protected $table = 'customer_care';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'response',
        'responded_by',
        'responded_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Relationship: CustomerCare belongs to User (khách hàng)
     */
    public function user()
    {
        return $this->belongsTo(User::class)->nullable();
    }

    /**
     * Relationship: CustomerCare belongs to User (người trả lời - admin)
     */
    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by')->nullable();
    }

    /**
     * Scope: Get pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get resolved requests
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Scope: Get in-progress requests
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}
