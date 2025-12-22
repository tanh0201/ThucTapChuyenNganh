<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Cầu Hỗ Trợ Mới</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #ff6b6b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #ff6b6b;
            margin: 0;
            font-size: 24px;
        }
        .alert {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-left: 4px solid #ff6b6b;
            padding-left: 10px;
        }
        .info-box {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #ff6b6b;
            border-radius: 4px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .button-group {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 5px;
            background-color: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎫 Yêu Cầu Hỗ Trợ Mới</h1>
            <p style="margin: 5px 0; color: #666;">Ticket #{{ $ticket->id }}</p>
        </div>

        <div class="alert">
            <strong>⚠️ Chú ý:</strong> Có yêu cầu hỗ trợ mới cần xử lý. Vui lòng truy cập admin dashboard để xem chi tiết.
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">👤 Thông Tin Khách Hàng</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Tên:</span>
                    <span class="value">{{ $ticket->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $ticket->email }}</span>
                </div>
                @if($ticket->phone)
                <div class="info-row">
                    <span class="label">Số Điện Thoại:</span>
                    <span class="value">{{ $ticket->phone }}</span>
                </div>
                @endif
                @if($ticket->user)
                <div class="info-row">
                    <span class="label">Người Dùng:</span>
                    <span class="value">
                        <strong>{{ $ticket->user->name }}</strong>
                        (ID: {{ $ticket->user->id }})
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Ticket Info -->
        <div class="section">
            <div class="section-title">📋 Chi Tiết Yêu Cầu</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Tiêu Đề:</span>
                    <span class="value">{{ $ticket->subject }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Trạng Thái:</span>
                    <span class="value">
                        <strong style="color: #ff6b6b;">Chờ Xử Lý</strong>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Thời Gian:</span>
                    <span class="value">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="section">
            <div class="section-title">💬 Nội Dung Yêu Cầu</div>
            <div class="message-content">{{ $ticket->message }}</div>
        </div>

        <!-- Action Buttons -->
        <div class="button-group">
            <a href="{{ route('admin.customer-care.show', $ticket->id) }}" class="btn">
                Xem Chi Tiết & Trả Lời
            </a>
        </div>

        <div class="footer">
            <p>📧 Đây là thư thông báo tự động từ hệ thống PetSam. Vui lòng không trả lời thư này.</p>
            <p>&copy; 2025 PetSam. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
