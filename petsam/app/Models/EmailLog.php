<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'email_logs';

    protected $fillable = [
        'to_email',
        'subject',
        'mailable_class',
        'body',
        'status',
        'error_message',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
