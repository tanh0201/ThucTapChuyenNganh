<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;

class LogEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSending $event): void
    {
        try {
            $email = $event->message->getTo();
            $toEmail = key($email);

            EmailLog::create([
                'to_email' => $toEmail,
                'subject' => $event->message->getSubject(),
                'mailable_class' => 'Email',
                'body' => $event->message->toString(),
                'status' => 'sending',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log email: ' . $e->getMessage());
        }
    }
}
