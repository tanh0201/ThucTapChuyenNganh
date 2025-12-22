<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notifications Test - PetSam Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding-top: 20px;
        }
        .test-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .test-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .test-card h5 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .test-card .icon {
            font-size: 20px;
            width: 30px;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status-ready {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-warning {
            background-color: #f8d7da;
            color: #721c24;
        }
        .instruction {
            background-color: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #4e73df;
            margin-top: 15px;
            border-radius: 4px;
        }
        .code-block {
            background-color: #272822;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin-top: 10px;
        }
        .success-log {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 3px;
        }
        .error-log {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 3px;
        }
        .progress {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center gap-3 mb-5">
                    <div style="font-size: 40px;">📧</div>
                    <div>
                        <h1 class="mb-0">Email Notifications Test Panel</h1>
                        <p class="text-muted mb-0">Test email system configuration and sending</p>
                    </div>
                </div>

                <!-- System Status -->
                <div class="test-card mb-4">
                    <h5>
                        <span class="icon">⚙️</span>
                        Email System Status
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Current Mailer:</strong></p>
                            <code>{{ config('mail.mailer') }}</code>
                            <span class="status-badge {{ config('mail.mailer') !== 'log' ? 'status-ready' : 'status-warning' }}">
                                {{ config('mail.mailer') === 'log' ? '⚠️ Using Log Driver' : '✅ Configured' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>From Address:</strong></p>
                            <code>{{ config('mail.from.address') }}</code>
                        </div>
                    </div>

                    @if(config('mail.mailer') === 'log')
                    <div class="instruction">
                        <i class="fas fa-warning"></i> <strong>Note:</strong> Email driver is set to 'log'. Emails will be logged to storage/logs/laravel.log instead of being sent.
                        Configure a proper email service in .env to actually send emails.
                    </div>
                    @endif
                </div>

                <!-- Test Commands -->
                <div class="test-card">
                    <h5>
                        <span class="icon">🧪</span>
                        Test Commands
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>1. Test Email Notifications</strong></p>
                            <p class="text-muted text-sm mb-3">Run this command to test the entire email system with the latest order:</p>
                            <div class="code-block">
php artisan email:test-notifications
                            </div>
                            <p class="text-muted text-sm mt-2">With custom admin email:</p>
                            <div class="code-block">
php artisan email:test-notifications admin@example.com
                            </div>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-2"><strong>2. Send Test Email</strong></p>
                            <p class="text-muted text-sm mb-3">Send a simple test email using tinker:</p>
                            <div class="code-block">
php artisan tinker
Mail::raw('Test', function($m) {
  $m->to('test@example.com');
})
exit
                            </div>
                            <p class="text-muted text-sm mt-2">Or check configuration:</p>
                            <div class="code-block">
config('mail.mailer')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Guide -->
                <div class="test-card mt-4">
                    <h5>
                        <span class="icon">⚙️</span>
                        Setup Email Service
                    </h5>

                    <div class="row">
                        <div class="col-lg-4">
                            <p class="mb-3"><strong>Option 1: Mailtrap (Recommended)</strong></p>
                            <ol class="small">
                                <li>Sign up: <a href="https://mailtrap.io" target="_blank">mailtrap.io</a></li>
                                <li>Get SMTP credentials</li>
                                <li>Update .env:
                                    <div class="code-block mt-2">
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="col-lg-4">
                            <p class="mb-3"><strong>Option 2: Gmail</strong></p>
                            <ol class="small">
                                <li>Generate app password at <a href="https://myaccount.google.com/apppasswords" target="_blank">Google Account</a></li>
                                <li>Update .env:
                                    <div class="code-block mt-2">
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
                                    </div>
                                </li>
                                <li>Clear cache: <code>php artisan config:clear</code></li>
                            </ol>
                        </div>

                        <div class="col-lg-4">
                            <p class="mb-3"><strong>Option 3: Mailgun</strong></p>
                            <ol class="small">
                                <li>Create account at <a href="https://mailgun.com" target="_blank">mailgun.com</a></li>
                                <li>Get API credentials</li>
                                <li>Update .env:
                                    <div class="code-block mt-2">
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=...
MAILGUN_SECRET=...
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="instruction mt-3">
                        <i class="fas fa-info-circle"></i> Don't forget to run <code>php artisan config:clear</code> after updating .env
                    </div>
                </div>

                <!-- Email Types -->
                <div class="test-card mt-4">
                    <h5>
                        <span class="icon">📨</span>
                        Email Types Implemented
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="mb-2">✅ Customer Emails</h6>
                                <ul class="list-unstyled text-sm">
                                    <li>📦 Order Confirmation - Sent on checkout</li>
                                    <li>📊 Order Status Updated - When admin updates status</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="mb-2">✅ Admin Notifications</h6>
                                <ul class="list-unstyled text-sm">
                                    <li>🆕 New Order - When customer creates order</li>
                                    <li>🎫 Support Ticket - When customer creates ticket</li>
                                    <li>💬 Contact Form - When customer submits form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Logs -->
                <div class="test-card mt-4">
                    <h5>
                        <span class="icon">📋</span>
                        Email Logs Management
                    </h5>
                    <p class="mb-3">View and manage all sent emails in the admin panel:</p>
                    <a href="/admin/email-logs" class="btn btn-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Email Logs
                    </a>

                    <div class="instruction mt-3">
                        <strong>Features:</strong>
                        <ul class="mb-0 mt-2">
                            <li>View all sent emails with status</li>
                            <li>Preview email content</li>
                            <li>Filter by status (sent, failed, sending)</li>
                            <li>Search by recipient or subject</li>
                            <li>View error messages for failed emails</li>
                            <li>Delete failed logs</li>
                            <li>Clear old logs (> 30 days)</li>
                        </ul>
                    </div>
                </div>

                <!-- Recent Logs -->
                <div class="test-card mt-4">
                    <h5>
                        <span class="icon">📊</span>
                        Recent Email Logs
                    </h5>
                    <div id="recentLogs">
                        <p class="text-muted">Loading recent logs...</p>
                    </div>
                </div>

                <!-- Troubleshooting -->
                <div class="test-card mt-4 border-left border-4" style="border-left-color: #dc3545;">
                    <h5>
                        <span class="icon">🔧</span>
                        Troubleshooting
                    </h5>

                    <div class="accordion" id="troubleshootingAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#troubleshoot1">
                                    Emails not sending?
                                </button>
                            </h2>
                            <div id="troubleshoot1" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ol>
                                        <li>Check .env configuration (MAIL_MAILER, MAIL_HOST, etc.)</li>
                                        <li>Run: <code>php artisan config:clear</code></li>
                                        <li>Check logs: <code>tail -f storage/logs/laravel.log</code></li>
                                        <li>Verify SMTP credentials in <a href="/admin/email-logs">/admin/email-logs</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#troubleshoot2">
                                    "Authentication failed" error?
                                </button>
                            </h2>
                            <div id="troubleshoot2" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Verify MAIL_USERNAME and MAIL_PASSWORD in .env</li>
                                        <li>For Gmail: Use app password, not account password</li>
                                        <li>For Mailtrap: Copy exact credentials from Integration tab</li>
                                        <li>Clear config cache: <code>php artisan config:clear</code></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#troubleshoot3">
                                    How to test emails safely?
                                </button>
                            </h2>
                            <div id="troubleshoot3" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Use <strong>Mailtrap</strong> for testing (catches all emails)</li>
                                        <li>Use <strong>Log driver</strong> for development (logs to file)</li>
                                        <li>Use a <strong>catch-all email</strong> for staging</li>
                                        <li>Create test user account for testing</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="alert alert-info mt-4 mb-4">
                    <h5 class="alert-heading mb-3">🚀 Next Steps</h5>
                    <ol class="mb-0">
                        <li>Configure email service in <code>.env</code></li>
                        <li>Run: <code>php artisan config:clear</code></li>
                        <li>Test with: <code>php artisan email:test-notifications</code></li>
                        <li>Monitor emails in: <code><a href="/admin/email-logs">/admin/email-logs</a></code></li>
                        <li>Customize email templates in <code>resources/views/emails/</code> if needed</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load recent email logs
        async function loadRecentLogs() {
            try {
                const response = await fetch('/api/email-logs/recent');
                const data = await response.json();

                let html = '';
                if (data.length === 0) {
                    html = '<p class="text-muted">No email logs yet</p>';
                } else {
                    html = '<table class="table table-sm mb-0">';
                    data.forEach(log => {
                        const statusBadge = log.status === 'sent'
                            ? '<span class="badge bg-success">✓ Sent</span>'
                            : log.status === 'failed'
                            ? '<span class="badge bg-danger">✗ Failed</span>'
                            : '<span class="badge bg-warning">⏳ Sending</span>';

                        html += `
                            <tr>
                                <td>
                                    ${statusBadge}
                                </td>
                                <td><small>${log.subject}</small></td>
                                <td><small class="text-muted">${log.to_email}</small></td>
                                <td><small class="text-muted">${new Date(log.created_at).toLocaleString()}</small></td>
                            </tr>
                        `;
                    });
                    html += '</table>';
                }

                document.getElementById('recentLogs').innerHTML = html;
            } catch (error) {
                document.getElementById('recentLogs').innerHTML = '<p class="text-danger">Error loading logs</p>';
            }
        }

        // Load on page load
        document.addEventListener('DOMContentLoaded', loadRecentLogs);
    </script>
</body>
</html>
