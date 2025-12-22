<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use App\Mail\NewOrderNotificationMail;
use Illuminate\Support\Facades\Mail;

class TestEmailNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-notifications {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email notifications system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? env('ADMIN_EMAIL', 'admin@petsam.local');

        $this->info('🧪 Testing Email Notifications System...');
        $this->newLine();

        // Test 1: Get latest order
        $order = Order::latest()->first();

        if (!$order) {
            $this->error('❌ No orders found. Create an order first.');
            return;
        }

        $this->info("✓ Found order: #{$order->order_number}");
        $this->newLine();

        // Test 2: Send Order Confirmation Email
        $this->info('1️⃣  Sending Order Confirmation Email...');
        try {
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            $this->line('   ✅ Order Confirmation email sent to: ' . $order->user->email);
        } catch (\Exception $e) {
            $this->line('   ❌ Failed: ' . $e->getMessage());
        }

        $this->newLine();

        // Test 3: Send New Order Notification
        $this->info('2️⃣  Sending New Order Notification Email to Admin...');
        try {
            Mail::to($email)->send(new NewOrderNotificationMail($order));
            $this->line('   ✅ New Order Notification sent to: ' . $email);
        } catch (\Exception $e) {
            $this->line('   ❌ Failed: ' . $e->getMessage());
        }

        $this->newLine();

        // Test 4: Check Email Logs
        $this->info('3️⃣  Checking Email Logs...');
        $emailLogs = \App\Models\EmailLog::latest()->limit(5)->get();

        if ($emailLogs->count() > 0) {
            $this->line('   ✅ Found ' . $emailLogs->count() . ' recent email logs:');
            $this->newLine();

            foreach ($emailLogs as $log) {
                $status = $log->status === 'sent' ? '✓ Sent' : '✗ Failed';
                $this->line("   [{$status}] {$log->subject} → {$log->to_email}");
            }
        } else {
            $this->line('   ⓘ No email logs found. Check if logging is enabled.');
        }

        $this->newLine();
        $this->info('🎉 Email notification test completed!');
        $this->info('📊 View email logs at: /admin/email-logs');
    }
}
