<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ Mới</title>
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
            border-bottom: 3px solid #0dcaf0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0dcaf0;
            margin: 0;
            font-size: 24px;
        }
        .alert {
            background-color: #cfe2ff;
            border-left: 4px solid #0dcaf0;
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
            border-left: 4px solid #0dcaf0;
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
            border-left: 4px solid #0dcaf0;
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
            background-color: #0dcaf0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
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
            <h1>📬 Liên Hệ Mới</h1>
            <p style="margin: 5px 0; color: #666;">Contact #{{ $contact->id }}</p>
        </div>

        <div class="alert">
            <strong>ℹ️ Thông Báo:</strong> Có tin nhắn liên hệ mới từ khách hàng. Vui lòng xem xét và phản hồi sớm nhất có thể.
        </div>

        <!-- Contact Info -->
        <div class="section">
            <div class="section-title">👤 Thông Tin Liên Hệ</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Tên:</span>
                    <span class="value">{{ $contact->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">
                        <a href="mailto:{{ $contact->email }}" style="color: #0dcaf0; text-decoration: none;">
                            {{ $contact->email }}
                        </a>
                    </span>
                </div>
                @if($contact->phone)
                <div class="info-row">
                    <span class="label">Số Điện Thoại:</span>
                    <span class="value">
                        <a href="tel:{{ $contact->phone }}" style="color: #0dcaf0; text-decoration: none;">
                            {{ $contact->phone }}
                        </a>
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Message Info -->
        <div class="section">
            <div class="section-title">📝 Chi Tiết Tin Nhắn</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Tiêu Đề:</span>
                    <span class="value">{{ $contact->subject }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Thời Gian:</span>
                    <span class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="section">
            <div class="section-title">💬 Nội Dung Tin Nhắn</div>
            <div class="message-content">{{ $contact->message }}</div>
        </div>

        <!-- Action Buttons -->
        <div class="button-group">
            <a href="mailto:{{ $contact->email }}" class="btn">
                ✉️ Trả Lời Email
            </a>
        </div>

        <div class="footer">
            <p>📧 Đây là thư thông báo tự động từ hệ thống PetSam. Vui lòng không trả lời thư này.</p>
            <p>&copy; 2025 PetSam. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
