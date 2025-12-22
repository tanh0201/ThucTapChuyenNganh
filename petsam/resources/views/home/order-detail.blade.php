@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('checkout.myOrders') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
            <h1 class="h3 fw-bold mb-4">
                <i class="fas fa-receipt text-primary me-2"></i>Chi tiết đơn hàng
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Số đơn hàng</h6>
                            <p class="mb-0" style="font-size: 18px; letter-spacing: 1px;">
                                <strong>{{ $order->order_number }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Ngày đặt hàng</h6>
                            <p class="mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Người nhận</h6>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Trạng thái</h6>
                            <p class="mb-2">
                                <strong>Trạng thái đơn hàng:</strong><br>
                                <span class="badge bg-warning text-dark" style="font-size: 12px; padding: 8px 12px;">
                                    {{ $order->getStatusDisplay() }}
                                </span>
                            </p>
                            <p class="mb-2">
                                <strong>Thanh toán:</strong><br>
                                <span class="badge bg-info" style="font-size: 12px; padding: 8px 12px;">
                                    {{ $order->getPaymentStatusDisplay() }}
                                </span>
                            </p>
                            <p class="mb-0">
                                <strong>Phương thức:</strong><br>
                                <span class="badge bg-secondary" style="font-size: 12px; padding: 8px 12px;">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Thanh toán khi nhận hàng
                                            @break
                                        @case('bank_transfer')
                                            Chuyển khoản ngân hàng
                                            @break
                                        @case('online')
                                            Thanh toán trực tuyến
                                            @break
                                    @endswitch
                                </span>
                            </p>
                        </div>
                    </div>

                    @if ($order->notes)
                        <hr>
                        <h6 class="fw-bold mb-2">Ghi chú:</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($item->product && $item->product->image)
                                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" 
                                                         class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div class="me-3 bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">
                                                        @if ($item->product)
                                                            <a href="{{ route('product.show', $item->product->id) }}" class="text-decoration-none">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        @else
                                                            Sản phẩm không tồn tại
                                                        @endif
                                                    </h6>
                                                    @if ($item->product)
                                                        <small class="text-muted">SKU: {{ $item->product->id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($item->price, 0, ',', '.') }} ₫
                                        </td>
                                        <td class="text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            {{ number_format($item->total, 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển:</span>
                        <span class="badge bg-success">Miễn phí</span>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between fw-bold" style="font-size: 18px;">
                            <span>Tổng cộng:</span>
                            <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Status Timeline -->
                    <h6 class="fw-bold mb-3">Tiến trình</h6>
                    <div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Đơn hàng đã được tạo</h6>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                @if (in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                @else
                                    <i class="fas fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">Xác nhận đơn hàng</h6>
                                <small class="text-muted">Đang xử lý...</small>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                @else
                                    <i class="fas fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">Đang chuẩn bị hàng</h6>
                                <small class="text-muted">Đang xử lý...</small>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                @if (in_array($order->status, ['shipped', 'delivered']))
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                @else
                                    <i class="fas fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">Đã gửi hàng</h6>
                                <small class="text-muted">Đang xử lý...</small>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="me-3">
                                @if ($order->status === 'delivered')
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                @else
                                    <i class="fas fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">Đã giao hàng</h6>
                                <small class="text-muted">Chờ xác nhận...</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="{{ route('checkout.myOrders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Quay lại danh sách
                        </a>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
