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
            $message = $event->message;
            
            // Get recipient email
            $toEmail = '';
            $to = $message->getTo();
            
            if (is_array($to) && count($to) > 0) {
                // Iterate through recipient addresses
                foreach ($to as $address) {
                    // If it's a Symfony Address object, get email via getAddress()
                    if (is_object($address) && method_exists($address, 'getAddress')) {
                        $toEmail = $address->getAddress();
                    } elseif (is_string($address)) {
                        $toEmail = $address;
                    }
                    
                    if ($toEmail) {
                        break;
                    }
                }
            }
            
            // Extract clean body content
            $fullMessage = $message->toString();
            $bodyContent = $this->extractBodyFromMessage($fullMessage);

            EmailLog::create([
                'to_email' => trim($toEmail),
                'subject' => $message->getSubject() ?? 'No Subject',
                'mailable_class' => 'Email',
                'body' => $bodyContent,
                'status' => 'sending',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log email: ' . $e->getMessage());
        }
    }

    /**
     * Extract clean body from MIME message
     */
    private function extractBodyFromMessage(string $message): string
    {
        // Split by double newline (headers end marker)
        $parts = preg_split('/\r?\n\r?\n/', $message, 2);
        
        if (count($parts) > 1) {
            $body = $parts[1];
        } else {
            $body = $message;
        }

        // Remove MIME boundaries
        $body = preg_replace('/^--.*$/m', '', $body);
        
        // Remove Content-Type headers
        $body = preg_replace('/Content-Type:.*?(?=\r?\n(?:[A-Z-]+:|$))/is', '', $body);
        $body = preg_replace('/Content-Transfer-Encoding:.*$/m', '', $body);
        $body = preg_replace('/Content-Disposition:.*$/m', '', $body);
        $body = preg_replace('/boundary=.*$/m', '', $body);
        
        // Decode quoted-printable
        if (strpos($body, '=') !== false && preg_match('/=[0-9A-F]{2}/', $body)) {
            $body = quoted_printable_decode($body);
        }
        
        // Clean up HTML if present
        if (stripos($body, '<html') !== false || stripos($body, '<!DOCTYPE') !== false) {
            // Extract text from HTML - simple strip tags
            $body = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $body);
            $body = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $body);
            $body = preg_replace('/<[^>]+>/', '', $body);
        }
        
        // Clean up extra whitespace
        $body = preg_replace('/\n{3,}/', "\n\n", trim($body));
        $body = html_entity_decode($body);
        
        return substr($body, 0, 5000); // Limit to 5000 chars
    }
}

