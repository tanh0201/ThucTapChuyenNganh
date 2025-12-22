<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái đơn hàng</title>
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
            border-bottom: 3px solid #4e73df;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4e73df;
            margin: 0;
            font-size: 24px;
        }
        .order-number {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        .status-box {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        .status-box h2 {
            margin: 0;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .status-box p {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-left: 4px solid #4e73df;
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
        .timeline {
            margin: 20px 0;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 15px;
        }
        .timeline-icon {
            width: 40px;
            height: 40px;
            background-color: #4e73df;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            flex-shrink: 0;
        }
        .timeline-icon.completed {
            background-color: #4caf50;
        }
        .timeline-item-content h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #333;
        }
        .timeline-item-content p {
            margin: 0;
            color: #999;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #4e73df;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #3d5ac5;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Cập nhật trạng thái đơn hàng</h1>
            <p class="order-number">Mã đơn hàng: <strong>{{ $order->order_number }}</strong></p>
        </div>

        <!-- Status Box -->
        <div class="status-box">
            <h2>✓ {{ $statusMessage }}</h2>
            <p>Cập nhật lúc {{ $order->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="section">
            <div class="section-title">Thông tin đơn hàng</div>
            <div class="info-box">
                <div class="info-row">
                    <span class="label">Mã đơn hàng:</span>
                    <span class="value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Địa chỉ giao hàng:</span>
                    <span class="value">{{ $order->shipping_address }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Số điện thoại:</span>
                    <span class="value">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tổng thanh toán:</span>
                    <span class="value"><strong>{{ number_format($order->orderItems->sum(function ($item) { return $item->price * $item->quantity; }), 0, ',', '.') }}₫</strong></span>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="section">
            <div class="section-title">Tiến độ xử lý</div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon completed">✓</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng được tạo</h3>
                        <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                <div class="timeline-item">
                    <div class="timeline-icon completed">✓</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng được xác nhận</h3>
                        <p>Cửa hàng đã xác nhận đơn hàng của bạn</p>
                    </div>
                </div>
                @endif

                @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                <div class="timeline-item">
                    <div class="timeline-icon completed">✓</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng đang được chuẩn bị</h3>
                        <p>Chúng tôi đang chuẩn bị gói hàng của bạn</p>
                    </div>
                </div>
                @endif

                @if(in_array($order->status, ['shipped', 'delivered']))
                <div class="timeline-item">
                    <div class="timeline-icon completed">✓</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng đã được gửi đi</h3>
                        <p>Gói hàng đã được gửi tới địa chỉ của bạn</p>
                    </div>
                </div>
                @endif

                @if($order->status === 'delivered')
                <div class="timeline-item">
                    <div class="timeline-icon completed">✓</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng đã được giao</h3>
                        <p>Cảm ơn bạn đã mua sắm tại PetSam!</p>
                    </div>
                </div>
                @endif

                @if($order->status === 'cancelled')
                <div class="timeline-item">
                    <div class="timeline-icon" style="background-color: #f44336;">✕</div>
                    <div class="timeline-item-content">
                        <h3>Đơn hàng đã bị hủy</h3>
                        <p>Liên hệ với chúng tôi nếu bạn có câu hỏi</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Nút xem chi tiết -->
        <div style="text-align: center;">
            <a href="{{ route('checkout.show', $order) }}" class="button">Xem Chi Tiết Đơn Hàng</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn bạn đã sử dụng dịch vụ của PetSam! 🐾</p>
            <p>&copy; {{ date('Y') }} PetSam. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
