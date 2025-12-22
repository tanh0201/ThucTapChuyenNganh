<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusMessages = [
        'pending' => 'Đơn hàng của bạn đang chờ xác nhận',
        'confirmed' => 'Đơn hàng đã được xác nhận',
        'processing' => 'Đơn hàng đang được chuẩn bị',
        'shipped' => 'Đơn hàng đã được gửi đi',
        'delivered' => 'Đơn hàng đã được giao',
        'cancelled' => 'Đơn hàng đã bị hủy'
    ];

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cập nhật trạng thái đơn hàng #' . $this->order->order_number . ' - PetSam'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
            with: [
                'order' => $this->order,
                'statusMessage' => $this->statusMessages[$this->order->status] ?? 'Đơn hàng đang cập nhật'
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
