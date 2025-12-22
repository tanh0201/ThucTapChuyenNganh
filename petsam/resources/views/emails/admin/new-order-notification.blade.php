<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .order-info {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin-bottom: 20px;
        }
        .order-info p {
            margin: 8px 0;
        }
        .customer-info {
            background-color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .customer-info h4 {
            margin-top: 0;
            color: #667eea;
        }
        .items-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #667eea;
            font-weight: bold;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .items-table tr:hover {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 16px;
        }
        .action-button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .action-button:hover {
            background-color: #764ba2;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cod {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>✓ Đơn Hàng Mới Được Tạo</h2>
            <p>Đơn hàng #{$order->order_number}}</p>
        </div>

        <div class="order-info">
            <p><strong>Mã đơn hàng:</strong> #{{ $order->order_number }}</p>
            <p><strong>Thời gian:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> <span class="status-badge status-pending">{{ $order->status === 'pending' ? 'Chờ xử lý' : $order->status }}</span></p>
            <p><strong>Phương thức thanh toán:</strong> 
                <span class="status-badge" style="background-color: {{ $order->payment_method === 'cod' ? '#d1ecf1' : '#e2e3e5' }}; color: {{ $order->payment_method === 'cod' ? '#0c5460' : '#383d41' }}">
                    {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}
                </span>
            </p>
        </div>

        <div class="customer-info">
            <h4>👤 Thông Tin Khách Hàng</h4>
            <p><strong>Tên:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
            @if($order->notes)
            <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₫{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>₫{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Tổng cộng:</td>
                    <td>₫{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div style="background-color: white; padding: 15px; border-radius: 5px;">
            <h4 style="margin-top: 0; color: #667eea;">📋 Hành Động Cần Thiết</h4>
            <p>Vui lòng xem xét và xử lý đơn hàng này tại bảng quản trị.</p>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="action-button">Xem Chi Tiết Đơn Hàng</a>
        </div>

        <div class="footer">
            <p>© 2024 PetSam - Hệ thống quản lý đơn hàng</p>
        </div>
    </div>
</body>
</html>
