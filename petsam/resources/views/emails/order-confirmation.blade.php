<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
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
        .customer-info {
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #4e73df;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
            color: #4e73df;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .payment-info {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #4caf50;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Đơn hàng đã được tạo thành công</h1>
            <p class="order-number">Mã đơn hàng: <strong>{{ $order->order_number }}</strong></p>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="section">
            <div class="section-title">Thông tin giao hàng</div>
            <div class="customer-info">
                <div class="info-row">
                    <span class="label">Tên khách hàng:</span>
                    <span class="value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $order->user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Số điện thoại:</span>
                    <span class="value">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Địa chỉ:</span>
                    <span class="value">{{ $order->shipping_address }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Ngày đặt hàng:</span>
                    <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="section">
            <div class="section-title">Chi tiết sản phẩm</div>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                        <td><strong>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="section">
            <div class="summary">
                <div class="summary-row">
                    <span>Tổng tiền hàng:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>{{ $order->shipping_fee ? number_format($order->shipping_fee, 0, ',', '.') . '₫' : 'Miễn phí' }}</span>
                </div>
                <div class="summary-row total-row">
                    <span>Tổng thanh toán:</span>
                    <span>{{ number_format($total + ($order->shipping_fee ?? 0), 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        <div class="section">
            <div class="payment-info">
                <strong>Phương thức thanh toán:</strong> 
                @if($order->payment_method === 'cod')
                    Thanh toán khi nhận hàng (COD)
                @elseif($order->payment_method === 'bank_transfer')
                    Chuyển khoản ngân hàng
                @else
                    Thanh toán trực tuyến
                @endif
                <br><br>
                <strong>Trạng thái thanh toán:</strong> 
                @if($order->payment_status === 'pending')
                    <span style="color: #ff9800;">Chờ thanh toán</span>
                @elseif($order->payment_status === 'paid')
                    <span style="color: #4caf50;">Đã thanh toán</span>
                @else
                    <span style="color: #f44336;">{{ $order->payment_status }}</span>
                @endif
            </div>
        </div>

        <!-- Ghi chú -->
        <div class="section">
            <div class="section-title">Ghi chú từ admin</div>
            <p>{{ $order->notes ?? 'Không có ghi chú' }}</p>
        </div>

        <!-- Nút xem chi tiết -->
        <div style="text-align: center;">
            <a href="{{ route('checkout.show', $order) }}" class="button">Xem Chi Tiết Đơn Hàng</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn bạn đã mua sắm tại PetSam! 🐾</p>
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
            <p>&copy; {{ date('Y') }} PetSam. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
