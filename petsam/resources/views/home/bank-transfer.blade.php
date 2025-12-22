@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Bank Transfer Info Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-university me-2"></i>Thông tin chuyển khoản
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Hướng dẫn:</strong> Vui lòng chuyển khoản đến tài khoản dưới đây. Đơn hàng sẽ được xác nhận khi chúng tôi nhận được thanh toán.
                    </div>

                    <!-- Order Info -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Thông tin đơn hàng</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Mã đơn hàng:</strong><br>
                                    <span class="badge bg-primary fs-6">{{ $order->order_number }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Số tiền cần thanh toán:</strong><br>
                                    <span class="badge bg-danger fs-6">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- QR Code Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Mã QR Chuyển Khoản <span class="badge bg-success ms-2">Đa ngân hàng</span></h5>
                        <div class="text-center">
                            @php
                                // Generate VietQR - Works with all Vietnamese banks (Napas standard)
                                $bankCode = $bankInfo['bank_code'] ?? 'MBBANK';
                                $accountNumber = $bankInfo['account_number'] ?? '';
                                $accountName = $bankInfo['account_name'] ?? 'PetSam';
                                $amount = (int)$order->total_price;
                                $orderId = $order->order_number;
                                
                                // Using VietQR.co API - Most reliable VietQR provider
                                $addInfo = urlencode($orderId);
                                $acctName = urlencode($accountName);
                                $qrUrl = "https://api.vietqr.io/image/{$bankCode}-{$accountNumber}-compact2.jpg?amount={$amount}&addInfo={$addInfo}";
                            @endphp
                            
                            <img src="{{ $qrUrl }}" alt="QR Code" class="img-fluid border rounded" style="max-width: 280px; margin-bottom: 1rem;">
                            <p class="text-muted small"><i class="fas fa-check-circle text-success me-2"></i>QR hoạt động với tất cả ngân hàng Việt Nam</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Bank Details -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Chi tiết tài khoản ngân hàng</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold" style="width: 30%;">Tên ngân hàng:</td>
                                        <td>{{ $bankInfo['bank_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Mã ngân hàng:</td>
                                        <td>{{ $bankInfo['bank_code'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Chủ tài khoản:</td>
                                        <td>{{ $bankInfo['account_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Số tài khoản:</td>
                                        <td>
                                            <code class="bg-light p-2 rounded" style="font-size: 16px; font-weight: bold; letter-spacing: 2px;">
                                                {{ $bankInfo['account_number'] }}
                                            </code>
                                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('{{ $bankInfo['account_number'] }}')">
                                                <i class="fas fa-copy me-1"></i>Sao chép
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Số tiền:</td>
                                        <td>
                                            <code class="bg-light p-2 rounded" style="font-size: 16px; font-weight: bold; letter-spacing: 2px;">
                                                {{ number_format($order->total_price, 0, ',', '.') }} ₫
                                            </code>
                                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('{{ $order->total_price }}')">
                                                <i class="fas fa-copy me-1"></i>Sao chép
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Nội dung chuyển khoản:</td>
                                        <td>
                                            <code class="bg-light p-2 rounded d-block" style="font-size: 14px; word-break: break-all;">
                                                {{ $order->order_number }}
                                            </code>
                                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyToClipboard('{{ $order->order_number }}')">
                                                <i class="fas fa-copy me-1"></i>Sao chép
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Important Notes -->
                    <div class="alert alert-warning" role="alert">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>Lưu ý quan trọng
                        </h6>
                        <ul class="mb-0">
                            <li><strong>Ghi chú chuyển khoản:</strong> Bắt buộc ghi mã đơn hàng <code>{{ $order->order_number }}</code> để chúng tôi có thể xác định đơn hàng của bạn</li>
                            <li><strong>Thời gian xác nhận:</strong> Đơn hàng sẽ được xác nhận trong vòng 1-2 giờ sau khi chúng tôi nhận được thanh toán</li>
                            <li><strong>QR Code:</strong> Bạn có thể quét mã QR trên để tự động điền thông tin chuyển khoản (nếu ngân hàng hỗ trợ)</li>
                            <li><strong>Hỗ trợ:</strong> Nếu có vấn đề, vui lòng <a href="{{ route('contact.index') }}" class="text-decoration-none">liên hệ chúng tôi</a></li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('checkout.myOrders') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-check me-2"></i>Tôi đã chuyển khoản
                        </a>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Chi tiết đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                    <td class="text-end">{{ number_format($item->total, 0, ',', '.') }} ₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="3" class="text-end">Tổng cộng:</td>
                                    <td class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Đã sao chép vào clipboard!');
    }).catch(err => {
        console.error('Lỗi khi sao chép:', err);
    });
}
</script>
@endsection
