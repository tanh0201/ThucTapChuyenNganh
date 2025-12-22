@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 fw-bold mb-4">
                <i class="fas fa-credit-card text-primary me-2"></i>Thanh Toán
            </h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Có lỗi xảy ra!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Thông tin người nhận</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Họ tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                Số điện thoại <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label fw-semibold">
                                Địa chỉ giao hàng <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_cod" value="cod" checked>
                                <label class="form-check-label" for="payment_cod">
                                    <strong>Thanh toán khi nhận hàng (COD)</strong>
                                    <small class="d-block text-muted">Bạn sẽ thanh toán tiền mặt cho nhân viên giao hàng</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_bank" value="bank_transfer">
                                <label class="form-check-label" for="payment_bank">
                                    <strong>Chuyển khoản ngân hàng</strong>
                                    <small class="d-block text-muted">Chuyển tiền trực tiếp vào tài khoản của chúng tôi</small>
                                </label>
                            </div>
                            @error('payment_method')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">Ghi chú đơn hàng</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" placeholder="Nhập ghi chú nếu có...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="accept_terms" required>
                            <label class="form-check-label" for="accept_terms">
                                Tôi đồng ý với <a href="#" class="text-decoration-none">điều khoản sử dụng</a> và 
                                <a href="#" class="text-decoration-none">chính sách bảo mật</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-check me-2"></i>Xác nhận đặt hàng
                        </button>
                    </form>
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
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach ($cartItems as $item)
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                    <small class="text-muted">
                                        {{ number_format($item['product']->price, 0, ',', '.') }} ₫ × {{ $item['quantity'] }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <strong>{{ number_format($item['total'], 0, ',', '.') }} ₫</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển:</span>
                        <span class="badge bg-success">Miễn phí</span>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between fw-bold" style="font-size: 18px;">
                            <span>Tổng cộng:</span>
                            <span class="text-primary">{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    if (!document.getElementById('accept_terms').checked) {
        e.preventDefault();
        alert('Vui lòng đồng ý với điều khoản sử dụng');
    }
});
</script>
@endsection
