@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 fw-bold mb-4">
                <i class="fas fa-shopping-cart text-primary me-2"></i>Giỏ Hàng
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

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($cartItems && count($cartItems) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thành tiền</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items-body">
                                @foreach ($cartItems as $item)
                                    <tr data-product-id="{{ $item['product']->id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($item['product']->image)
                                                    <img src="{{ asset($item['product']->image) }}" alt="{{ $item['product']->name }}" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div class="me-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('product.show', $item['product']->id) }}" class="text-decoration-none">
                                                            {{ $item['product']->name }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">SKU: {{ $item['product']->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-semibold">
                                            {{ number_format($item['product']->price, 0, ',', '.') }} ₫
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                                <button class="btn btn-outline-secondary qty-minus" type="button">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center qty-input" value="{{ $item['quantity'] }}" min="1" max="100">
                                                <button class="btn btn-outline-secondary qty-plus" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-primary item-total">
                                            {{ number_format($item['total'], 0, ',', '.') }} ₫
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-danger remove-item" type="button" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <span id="subtotal">{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span id="shipping">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold text-primary" style="font-size: 18px;">
                            <span>Tổng cộng:</span>
                            <span id="total">{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                        </a>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Continue Shopping Alert -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Mẹo:</strong> Bạn có thể cập nhật số lượng trực tiếp từ bảng trên
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart text-muted" style="font-size: 3rem;"></i>
                        <h3 class="mt-4 mb-2">Giỏ hàng của bạn trống</h3>
                        <p class="text-muted mb-4">Chưa có sản phẩm nào trong giỏ hàng. Hãy bắt đầu mua sắm ngay!</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Đi tới cửa hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity change handlers
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            input.value = parseInt(input.value) + 1;
            updateCartItem(input);
        });
    });

    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCartItem(input);
            }
        });
    });

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value < 1) this.value = 1;
            updateCartItem(this);
        });
    });

    // Remove item handlers
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const productId = row.dataset.productId;
            removeFromCart(productId);
        });
    });

    function updateCartItem(input) {
        const row = input.closest('tr');
        const productId = row.dataset.productId;
        const quantity = parseInt(input.value);

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update total for this item
                const priceCell = row.querySelector('td:nth-child(2)');
                const price = parseInt(priceCell.textContent.replace(/\D/g, ''));
                const total = price * quantity;
                row.querySelector('.item-total').textContent = new Intl.NumberFormat('vi-VN').format(total) + ' ₫';
                
                updateCartSummary();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeFromCart(productId) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    function updateCartSummary() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(el => {
            total += parseInt(el.textContent.replace(/\D/g, ''));
        });
        
        document.getElementById('subtotal').textContent = new Intl.NumberFormat('vi-VN').format(total) + ' ₫';
        document.getElementById('total').textContent = new Intl.NumberFormat('vi-VN').format(total) + ' ₫';
    }
});
</script>
@endsection
