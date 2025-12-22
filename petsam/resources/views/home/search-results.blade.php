@extends('layout.app')

@section('title', 'Kết Quả Tìm Kiếm - PetSam')
@section('description', 'Kết quả tìm kiếm sản phẩm và danh mục')

@section('content')

<!-- ==================== PAGE HEADER ==================== -->
<section class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0; color: white; text-align: center;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Kết Quả Tìm Kiếm</h1>
        <p class="fs-5 text-white-50">Tìm kiếm cho: <strong>"{{ $query }}"</strong></p>
    </div>
</section>

<!-- ==================== RESULTS SECTION ==================== -->
<section class="py-5">
    <div class="container">
        <!-- Categories Results -->
        @if($categories->count() > 0)
        <div class="mb-5">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-folder text-primary me-2"></i>Danh Mục Phù Hợp
                <span class="badge bg-primary">{{ $categories->count() }}</span>
            </h4>
            <div class="row g-3 mb-5">
                @foreach($categories as $category)
                <div class="col-md-4">
                    <a href="{{ route('categories') }}?cat={{ $category->id }}" class="card text-decoration-none text-dark border-0 shadow-sm h-100" style="transition: all 0.3s;">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-th-large text-primary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                            <p class="text-muted mb-0">{{ $category->products->count() ?? 0 }} sản phẩm</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <hr>
        @endif

        <!-- Products Results with Filter -->
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-filter me-2 text-primary"></i>Bộ Lọc
                        </h5>

                        <form method="GET" action="{{ route('search') }}" id="filterForm">
                            <!-- Keep search query -->
                            <input type="hidden" name="q" value="{{ $query }}">

                            <!-- Category Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Danh Mục</h6>
                                @foreach($allCategories as $cat)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="cat{{ $cat->id }}" name="category" value="{{ $cat->id }}" @if(request('category') == $cat->id) checked @endif>
                                    <label class="form-check-label" for="cat{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                                @endforeach
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" id="catAll" name="category" value="" @if(!request('category')) checked @endif>
                                    <label class="form-check-label" for="catAll">
                                        Tất cả danh mục
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <!-- Price Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Giá</h6>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="radio" id="price1" name="price_range" value="0-500000" @if(request('min_price') == '0' && request('max_price') == '500000') checked @endif>
                                    <label class="form-check-label" for="price1">
                                        Dưới 500k
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="radio" id="price2" name="price_range" value="500000-1000000" @if(request('min_price') == '500000' && request('max_price') == '1000000') checked @endif>
                                    <label class="form-check-label" for="price2">
                                        500k - 1 triệu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="radio" id="price3" name="price_range" value="1000000-5000000" @if(request('min_price') == '1000000' && request('max_price') == '5000000') checked @endif>
                                    <label class="form-check-label" for="price3">
                                        1 - 5 triệu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="radio" id="price4" name="price_range" value="5000000-999999999" @if(request('min_price') == '5000000') checked @endif>
                                    <label class="form-check-label" for="price4">
                                        Trên 5 triệu
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input price-filter" type="radio" id="priceAll" name="price_range" value="" @if(!request('min_price') && !request('max_price')) checked @endif>
                                    <label class="form-check-label" for="priceAll">
                                        Tất cả giá
                                    </label>
                                </div>
                                <input type="hidden" name="min_price" value="{{ request('min_price', '') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price', '') }}">
                            </div>

                            <hr>

                            <!-- Sort -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Sắp Xếp</h6>
                                <select class="form-select form-select-sm" name="sort" onchange="document.getElementById('filterForm').submit();">
                                    <option value="latest" @if(request('sort', 'latest') === 'latest') selected @endif>Mới nhất</option>
                                    <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Giá: Thấp đến Cao</option>
                                    <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Giá: Cao đến Thấp</option>
                                    <option value="popular" @if(request('sort') === 'popular') selected @endif>Phổ biến nhất</option>
                                    <option value="rating" @if(request('sort') === 'rating') selected @endif>Đánh giá cao nhất</option>
                                </select>
                            </div>

                            <hr>

                            <!-- Filter & Reset Buttons -->
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-filter me-2"></i>Áp Dụng Lọc
                            </button>
                            <a href="{{ route('search', ['q' => $query]) }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo me-2"></i>Xóa Bộ Lọc
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Column -->
            <div class="col-lg-9">
                <h4 class="fw-bold mb-4">
                <i class="fas fa-shopping-bag text-primary me-2"></i>Sản Phẩm Phù Hợp
                <span class="badge bg-primary">{{ $products->total() }}</span>
            </h4>

            @if($products->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card h-100 rounded-lg overflow-hidden" style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; border: none;">
                        <!-- Product Image -->
                        <div class="product-image-wrapper position-relative overflow-hidden" style="height: 250px;">
                            @if(!empty($product->image) && file_exists(public_path($product->image)))
                                <img src="{{ asset($product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('img/product-placeholder.png') }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                            @endif
                            
                            <!-- Badge -->
                            <div style="position: absolute; top: 15px; right: 15px;">
                                @if($product->status === 'new')
                                <span class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-star me-1"></i> Mới
                                </span>
                                @endif
                            </div>

                            <!-- Quick View Button (on hover) -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.8); padding: 15px; transform: translateY(100%); transition: transform 0.3s;" class="quick-view-btn">
                                <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-light w-100">
                                    <i class="fas fa-eye me-2"></i>Xem Chi Tiết
                                </a>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-3">
                            <h6 class="card-title fw-bold mb-2" style="height: 45px; overflow: hidden;">
                                {{ $product->name }}
                            </h6>
                            <p class="text-muted small mb-2">{{ $product->category->name ?? 'Chưa phân loại' }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 text-danger fw-bold mb-0">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                @if($product->original_price)
                                <span class="text-muted text-decoration-line-through small">{{ number_format($product->original_price, 0, ',', '.') }}₫</span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            <button class="btn btn-sm btn-primary w-100 add-to-cart-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-image="{{ asset($product->image) }}">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm Giỏ
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
            @else
            <div class="alert alert-warning text-center py-5" role="alert">
                <i class="fas fa-search mb-3" style="font-size: 3rem; display: block; opacity: 0.5;"></i>
                <h5 class="mt-3">Không tìm thấy sản phẩm nào</h5>
                <p class="text-muted mb-0">Hãy thử lại với từ khóa khác</p>
            </div>
            @endif
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle price filter
    document.querySelectorAll('.price-filter').forEach(radio => {
        radio.addEventListener('change', function() {
            const [minPrice, maxPrice] = this.value ? this.value.split('-') : ['', ''];
            document.querySelector('input[name="min_price"]').value = minPrice;
            document.querySelector('input[name="max_price"]').value = maxPrice;
            document.getElementById('filterForm').submit();
        });
    });

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            
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
                    alert(productName + ' đã được thêm vào giỏ hàng');
                    updateCartCount();
                } else {
                    alert('Lỗi: ' + (data.message || 'Không thể thêm sản phẩm'));
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Quick view hover effect
    document.querySelectorAll('.product-image-wrapper').forEach(wrapper => {
        wrapper.addEventListener('mouseenter', function() {
            this.querySelector('.quick-view-btn').style.transform = 'translateY(0)';
        });
        wrapper.addEventListener('mouseleave', function() {
            this.querySelector('.quick-view-btn').style.transform = 'translateY(100%)';
        });
    });

    // Update cart count
    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                // Update cart count in navbar if exists
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                }
            });
    }
});
</script>

@endsection
