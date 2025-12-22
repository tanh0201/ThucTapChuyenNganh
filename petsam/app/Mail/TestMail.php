<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $message;

    public function __construct($title = 'Test Email', $message = 'This is a test email from PetSam')
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
            with: [
                'title' => $this->title,
                'message' => $this->message,
            ]
        );
    }
}
