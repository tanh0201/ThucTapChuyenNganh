@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-5 mb-4">
            @if(!empty($product->image) && file_exists(public_path($product->image)))
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 500px;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-lg-7">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Cửa Hàng</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.products', $product->category->id) }}">{{ $product->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <!-- Product Name -->
            <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="mb-3">
                @php
                    $avgRating = $product->ratings()->where('status', 'approved')->avg('rating');
                    $ratingCount = $product->ratings()->where('status', 'approved')->count();
                @endphp
                @if($avgRating)
                    <div class="d-flex align-items-center gap-2">
                        @php
                            $fullStars = floor($avgRating);
                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                        @if($hasHalfStar)
                            <i class="fas fa-star-half-alt text-warning"></i>
                            @php $fullStars++ @endphp
                        @endif
                        @for($i = $fullStars; $i < 5; $i++)
                            <i class="far fa-star text-warning"></i>
                        @endfor
                        <span class="text-muted ms-2">({{ number_format($avgRating, 1) }}/5 - {{ $ratingCount }} đánh giá)</span>
                    </div>
                @else
                    <small class="text-muted"><i class="fas fa-star-half-alt"></i> Chưa có đánh giá</small>
                @endif
            </div>

            <!-- Price -->
            <div class="mb-4">
                <h2 class="text-primary fw-bold">{{ number_format($product->price, 0, ',', '.') }} ₫</h2>
            </div>

            <!-- Category & Stock -->
            <div class="mb-4">
                <p class="mb-2">
                    <strong>Danh Mục:</strong> 
                    <a href="{{ route('categories.products', $product->category->id) }}" class="text-primary">
                        {{ $product->category->name }}
                    </a>
                </p>
                <p class="mb-0">
                    <strong>Tình Trạng:</strong> 
                    @if($product->stock > 0)
                        <span class="text-success">Còn Hàng ({{ $product->stock }} sản phẩm)</span>
                    @else
                        <span class="text-danger">Hết Hàng</span>
                    @endif
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h5 class="fw-bold mb-2">Mô Tả Sản Phẩm</h5>
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart & Actions -->
            <div class="mb-4">
                <label for="quantity" class="form-label fw-semibold">Số lượng:</label>
                <div class="input-group mb-3" style="max-width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" id="qty-minus">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                    <button class="btn btn-outline-secondary" type="button" id="qty-plus">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @if ($product->stock > 0)
                    <button class="btn btn-primary btn-lg w-100" id="add-to-cart-btn">
                        <i class="fas fa-shopping-cart me-2"></i> Thêm Vào Giỏ
                    </button>
                @else
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-ban me-2"></i> Hết Hàng
                    </button>
                @endif
            </div>

            <div class="d-grid gap-2 d-sm-flex"
                    <a href="{{ route('customer-care.create') }}" class="btn btn-outline-info btn-sm w-100">
                        <i class="fas fa-headset me-2"></i> Hỏi Hỗ Trợ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ratings & Comments Section -->
    <div class="row mt-5" id="ratings">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">
                <i class="fas fa-star text-warning me-2"></i> Đánh Giá & Bình Luận
            </h3>

            @php
                $approvedRatings = $product->ratings()->where('status', 'approved')->latest()->paginate(5);
            @endphp

            @if($approvedRatings->count() > 0)
                @foreach($approvedRatings as $rating)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $rating->user->name ?? 'Ẩn danh' }}</h6>
                                    <div class="mb-2">
                                        @for($i = 0; $i < $rating->rating; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        @for($i = $rating->rating; $i < 5; $i++)
                                            <i class="far fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $rating->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="text-muted mb-0">{{ $rating->comment }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $approvedRatings->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!
                </div>
            @endif

            <!-- Your Rating Form -->
            @auth
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-edit me-2"></i> Gửi Đánh Giá Của Bạn
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('ratings.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Star Rating -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Đánh Giá (Số Sao) <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="star{{ $i }}" name="rating" 
                                                   value="{{ $i }}" required>
                                            <label class="form-check-label cursor-pointer" for="star{{ $i }}">
                                                <i class="fas fa-star text-warning" style="font-size: 1.5rem;"></i>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Comment -->
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Bình Luận</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" 
                                          placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-send me-2"></i> Gửi Đánh Giá
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> 
                    <a href="{{ route('login') }}" class="alert-link">Đăng nhập</a> để gửi đánh giá của bạn.
                </div>
            @endauth
        </div>

        <!-- Related Products -->
        <div class="col-lg-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-boxes text-primary me-2"></i> Sản Phẩm Liên Quan
            </h5>

            @if($relatedProducts->count() > 0)
                @foreach($relatedProducts as $related)
                    <div class="card border-0 shadow-sm mb-3">
                        <a href="{{ route('product.show', $related->id) }}" class="text-decoration-none text-dark">
                            @if(!empty($related->image) && file_exists(public_path($related->image)))
                                <img src="{{ asset($related->image) }}" alt="{{ $related->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                            @endif
                        </a>
                        <div class="card-body">
                            <h6 class="fw-bold mb-2 text-truncate">{{ $related->name }}</h6>
                            <p class="text-primary fw-bold mb-0">{{ number_format($related->price, 0, ',', '.') }} ₫</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info">
                    <small>Không có sản phẩm liên quan</small>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productId = {{ $product->id }};
    const maxStock = {{ $product->stock }};
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');

    // Quantity controls
    qtyMinus.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) {
            quantityInput.value = currentQty - 1;
        }
    });

    qtyPlus.addEventListener('click', function() {
        let currentQty = parseInt(quantityInput.value);
        if (currentQty < maxStock) {
            quantityInput.value = currentQty + 1;
        }
    });

    quantityInput.addEventListener('change', function() {
        if (this.value < 1) this.value = 1;
        if (this.value > maxStock) this.value = maxStock;
    });

    // Add to cart
    addToCartBtn.addEventListener('click', function() {
        const quantity = parseInt(quantityInput.value);
        
        fetch('{{ route("cart.add") }}', {
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
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                const mainElement = document.querySelector('main') || document.querySelector('body');
                const containerElement = document.querySelector('.container');
                if (mainElement && containerElement) {
                    mainElement.insertBefore(alertDiv, containerElement);
                } else if (mainElement) {
                    mainElement.insertBefore(alertDiv, mainElement.firstChild);
                }
                
                // Update cart count
                fetch('{{ route("cart.count") }}')
                    .then(res => {
                        if (!res.ok) throw new Error('Failed to fetch cart count');
                        return res.json();
                    })
                    .then(json => {
                        const cartBadge = document.querySelector('.cart-count');
                        if (cartBadge) cartBadge.textContent = json.count;
                    })
                    .catch(err => console.error('Error updating cart count:', err));
                
                // Reset quantity
                quantityInput.value = 1;
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        });
    });
});
</script>
@endsection
