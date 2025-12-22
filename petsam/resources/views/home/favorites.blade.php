@extends('layout.app')

@section('title', 'Yêu Thích - PetSam')
@section('description', 'Các sản phẩm yêu thích của bạn')

@section('content')

<!-- ==================== PAGE HEADER ==================== -->
<section class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0; color: white; text-align: center;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">❤️ Danh Sách Yêu Thích</h1>
        <p class="fs-5 text-white-50">Những sản phẩm bạn thích nhất</p>
    </div>
</section>

<!-- ==================== FAVORITES SECTION ==================== -->
<section class="py-5">
    <div class="container">
        @if($favorites->count() > 0)
        <div class="row g-4">
            @foreach($favorites as $favorite)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card h-100 rounded-lg overflow-hidden" style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; border: none; position: relative;">
                    <!-- Remove from favorites button -->
                    <button class="btn btn-sm btn-danger remove-favorite-btn" data-product-id="{{ $favorite->product->id }}" style="position: absolute; top: 10px; right: 10px; z-index: 10; border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-heart"></i>
                    </button>

                    <!-- Product Image -->
                    <div class="product-image-wrapper position-relative overflow-hidden" style="height: 250px;">
                        @if(!empty($favorite->product->image) && file_exists(public_path($favorite->product->image)))
                            <img src="{{ asset($favorite->product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $favorite->product->name }}">
                        @else
                            <img src="{{ asset('img/product-placeholder.png') }}" class="w-100 h-100 object-fit-cover" alt="{{ $favorite->product->name }}">
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-3">
                        <h6 class="card-title fw-bold mb-2" style="height: 45px; overflow: hidden;">
                            {{ $favorite->product->name }}
                        </h6>
                        <p class="text-muted small mb-2">{{ $favorite->product->category->name ?? 'Chưa phân loại' }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 text-danger fw-bold mb-0">{{ number_format($favorite->product->price, 0, ',', '.') }}₫</span>
                            @if($favorite->product->original_price)
                            <span class="text-muted text-decoration-line-through small">{{ number_format($favorite->product->original_price, 0, ',', '.') }}₫</span>
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('product.show', $favorite->product) }}" class="btn btn-sm btn-outline-primary grow">
                                <i class="fas fa-eye me-1"></i>Xem
                            </a>
                            <button class="btn btn-sm btn-primary add-to-cart-btn" data-product-id="{{ $favorite->product->id }}" style="flex-grow: 1;">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info text-center py-5" role="alert">
            <i class="fas fa-heart mb-3" style="font-size: 3rem; display: block; opacity: 0.5;"></i>
            <h5 class="mt-3">Danh sách yêu thích trống</h5>
            <p class="text-muted mb-0">Hãy thêm những sản phẩm bạn thích</p>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Mua Sắm Ngay
            </a>
        </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from favorites
    document.querySelectorAll('.remove-favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/favorites/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Add to cart
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Đã thêm vào giỏ hàng');
                    updateCartCount();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                }
            });
    }
});
</script>

@endsection
