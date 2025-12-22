<?php

namespace App\Console\Commands;

use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailSending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending with Gmail SMTP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? env('MAIL_FROM_ADDRESS', 'test@example.com');
        $mailer = env('MAIL_MAILER', 'log');

        $this->info('🚀 Testing Email Sending...');
        $this->info("📧 Target Email: {$email}");
        $this->info("📮 Mailer: {$mailer}");

        try {
            // Test 1: Simple test email
            $this->info("\n[1/3] Sending simple test email...");
            Mail::raw('✅ This is a test email from PetSam to verify email configuration is working correctly!', function ($message) use ($email) {
                $message->to($email)
                    ->subject('✅ Test Email from PetSam - ' . date('Y-m-d H:i:s'));
            });
            $this->info("✅ Simple email sent successfully!");

            // Log the email
            EmailLog::create([
                'to_email' => $email,
                'subject' => 'Test Email from PetSam',
                'mailable_class' => 'Raw',
                'status' => 'sent',
            ]);

            // Test 2: Test with Order Status Update Mail
            $this->info("\n[2/3] Testing with real Order Status Mail...");
            $lastOrder = Order::latest()->first();
            
            if ($lastOrder) {
                Mail::to($lastOrder->user->email ?? $email)->send(new OrderStatusUpdatedMail($lastOrder));
                $this->info("✅ Order Status Mail sent successfully!");

                EmailLog::create([
                    'to_email' => $lastOrder->user->email ?? $email,
                    'subject' => 'Cập nhật trạng thái đơn hàng #' . $lastOrder->order_number,
                    'mailable_class' => 'OrderStatusUpdatedMail',
                    'order_id' => $lastOrder->id,
                    'status' => 'sent',
                ]);
            } else {
                $this->warn("⚠️  No orders found. Skipping Order Status Mail test.");
            }

            // Test 3: Show configuration
            $this->info("\n[3/3] Mail Configuration:");
            $this->line("  MAIL_MAILER: " . env('MAIL_MAILER'));
            $this->line("  MAIL_HOST: " . env('MAIL_HOST'));
            $this->line("  MAIL_PORT: " . env('MAIL_PORT'));
            $this->line("  MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS'));
            $this->line("  MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION'));

            $this->info("\n✅ All email tests completed successfully!");
            
            if ($mailer === 'log') {
                $this->warn("\n📝 NOTE: Using 'log' mailer - emails are logged to storage/logs/ instead of being sent");
                $this->line("To send real emails, update .env:");
                $this->line("  MAIL_MAILER=smtp");
                $this->line("  MAIL_HOST=smtp.gmail.com (for Gmail)");
                $this->line("  MAIL_PORT=587");
                $this->line("  MAIL_USERNAME=your-email@gmail.com");
                $this->line("  MAIL_PASSWORD=your-app-password");
                $this->line("  MAIL_ENCRYPTION=tls");
            }

            $this->line("\n📋 Email Log Summary:");
            $this->info("Total emails sent: " . EmailLog::where('status', 'sent')->count());
            $this->warn("Total emails failed: " . EmailLog::where('status', 'failed')->count());

        } catch (\Exception $e) {
            $this->error("\n❌ Email Sending Failed!");
            $this->error("Error: " . $e->getMessage());

            // Log the failure
            EmailLog::create([
                'to_email' => $email,
                'subject' => 'Test Email from PetSam',
                'mailable_class' => 'Test',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            $this->line("\n🔧 Troubleshooting Tips:");
            $this->line("\n1️⃣ If using Gmail:");
            $this->line("   • Go to: https://myaccount.google.com/apppasswords");
            $this->line("   • Select: Mail + Windows");
            $this->line("   • Copy the 16-character password");
            $this->line("   • Update .env MAIL_PASSWORD=your-app-password");
            
            $this->line("\n2️⃣ If using Mailtrap (recommended for testing):");
            $this->line("   • Sign up: https://mailtrap.io");
            $this->line("   • Get SMTP settings");
            $this->line("   • Update .env with Mailtrap credentials");
            
            $this->line("\n3️⃣ Configuration checklist:");
            $this->line("   ✓ MAIL_MAILER=smtp");
            $this->line("   ✓ MAIL_HOST set correctly");
            $this->line("   ✓ MAIL_PORT=587 (TLS) or 465 (SSL)");
            $this->line("   ✓ MAIL_USERNAME set");
            $this->line("   ✓ MAIL_PASSWORD set (app password for Gmail)");
            $this->line("   ✓ MAIL_ENCRYPTION=tls");
            
            $this->line("\n4️⃣ Check logs: storage/logs/");

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
