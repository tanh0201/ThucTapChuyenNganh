@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Success Message -->
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2">Đặt hàng thành công!</h2>
                    <p class="text-muted mb-4">Cảm ơn bạn đã mua sắm tại PetSam. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>

                    <div class="alert alert-info mb-4">
                        <strong>Số đơn hàng:</strong> <span class="badge bg-primary fs-6">{{ $order->order_number }}</span>
                    </div>

                    @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                    <div class="alert alert-warning mb-4">
                        <strong><i class="fas fa-info-circle me-2"></i>Hướng dẫn chuyển khoản:</strong><br>
                        <small>Vui lòng chuyển khoản đến tài khoản ngân hàng. Đơn hàng sẽ được xác nhận sau khi chúng tôi nhận được thanh toán.</small><br>
                        <a href="{{ route('checkout.bank-transfer', $order->id) }}" class="btn btn-sm btn-warning mt-2">
                            <i class="fas fa-university me-1"></i>Xem chi tiết chuyển khoản
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Details -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Chi tiết đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Thông tin giao hàng</h6>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Trạng thái đơn hàng</h6>
                            <p class="mb-1">
                                <strong>Trạng thái:</strong>
                                <span class="badge bg-warning text-dark">{{ $order->getStatusDisplay() }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Thanh toán:</strong>
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-success">{{ $order->getPaymentStatusDisplay() }}</span>
                                @else
                                    <span class="badge bg-info">{{ $order->getPaymentStatusDisplay() }}</span>
                                @endif
                            </p>
                            <p class="mb-0">
                                <strong>Phương thức thanh toán:</strong>
                                <span class="badge bg-secondary">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Thanh toán khi nhận hàng
                                            @break
                                        @case('bank_transfer')
                                            Chuyển khoản ngân hàng
                                            @break
                                    @endswitch
                                </span>
                            </p>
                            <p class="mb-0">
                                <strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Sản phẩm đã đặt</h6>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
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
                                            {{ $item->product->name ?? 'Sản phẩm không tồn tại' }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($item->price, 0, ',', '.') }} ₫
                                        </td>
                                        <td class="text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($item->total, 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-8 ms-auto">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Phí vận chuyển:</span>
                                <span class="text-success">Miễn phí</span>
                            </div>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between fw-bold" style="font-size: 18px;">
                                    <span>Tổng cộng:</span>
                                    <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->notes)
                        <hr>
                        <h6 class="fw-bold mb-2">Ghi chú:</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card shadow-sm border-0 mt-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Các bước tiếp theo</h5>
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="mb-2">
                                <i class="fas fa-clipboard-check text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6>1. Xác nhận đơn hàng</h6>
                            <small class="text-muted">Chúng tôi sẽ xác nhận trong vòng 24 giờ</small>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="mb-2">
                                <i class="fas fa-box text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6>2. Chuẩn bị hàng</h6>
                            <small class="text-muted">Đóng gói và chuẩn bị gửi hàng</small>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="mb-2">
                                <i class="fas fa-truck text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6>3. Giao hàng</h6>
                            <small class="text-muted">Gửi đến địa chỉ của bạn</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 text-center">
                <a href="{{ route('checkout.show', $order->id) }}" class="btn btn-primary me-2">
                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                </a>
                <a href="{{ route('checkout.myOrders') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-list me-2"></i>Đơn hàng của tôi
                </a>
                <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
