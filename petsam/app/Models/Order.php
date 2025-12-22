<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'shipping_address',
        'phone',
        'notes',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'bank_code',
        'bank_tran_no',
        'payment_description',
        'payment_date',
        'payment_ip',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'total_price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Order belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Order has many OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $timestamp = now()->format('YmdHis');
        $random = mt_rand(1000, 9999);
        return $prefix . $timestamp . $random;
    }

    /**
     * Get status display text
     */
    public function getStatusDisplay()
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get payment status display text
     */
    public function getPaymentStatusDisplay()
    {
        $statuses = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
        ];
        return $statuses[$this->payment_status] ?? $this->payment_status;
    }
}
