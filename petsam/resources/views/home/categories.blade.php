@extends('layout.app')

@section('title', 'Danh Mục Sản Phẩm - PetSam')
@section('description', 'Khám phá các danh mục sản phẩm thú cưng của PetSam')

@section('content')

<!-- ==================== PAGE HEADER ==================== -->
<section class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0; color: white; text-align: center;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">{{ $selectedCategory ? $selectedCategory->name : 'Danh Mục Sản Phẩm' }}</h1>
        <p class="fs-5 text-white-50">{{ $selectedCategory ? 'Các sản phẩm trong danh mục này' : 'Tìm kiếm sản phẩm theo danh mục yêu thích của bạn' }}</p>
    </div>
</section>

<!-- ==================== CONTENT AREA ==================== -->
<section class="py-5">
    <div class="container">
        <!-- Show products if category selected -->
        @if($selectedCategory && $products)
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">{{ $products->total() }} sản phẩm</h3>
                        <a href="{{ route('categories') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại danh mục
                        </a>
                    </div>

                    <div class="row g-4">
                        @forelse($products as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-card h-100 rounded-lg overflow-hidden" style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; border: none;">
                            <!-- Product Image -->
                            <div class="product-image-wrapper position-relative overflow-hidden" style="height: 250px;">
                                @if(!empty($product->image) && file_exists(public_path($product->image)))
                                    <img src="{{ asset($product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/product-placeholder.png') }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                @endif                                    <!-- Badge -->
                                    <div style="position: absolute; top: 15px; right: 15px;">
                                        @if($product->status === 'new')
                                        <span class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                            <i class="fas fa-star me-1"></i> Mới
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Overlay with buttons -->
                                    <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end justify-content-center pb-3" style="background: rgba(0,0,0,0.6); opacity: 0; transition: all 0.3s;">
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-light btn-sm px-4 py-2">
                                            <i class="fas fa-eye me-2"></i> Xem Chi Tiết
                                        </a>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    <p class="text-muted small mb-2">{{ $product->category->name ?? 'Khác' }}</p>
                                    <h6 class="fw-bold mb-3" style="min-height: 45px; line-height: 1.5;">
                                        {{ Illuminate\Support\Str::limit($product->name, 45) }}
                                    </h6>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <h5 class="text-primary fw-bold mb-0">
                                            ₫{{ number_format($product->price, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <!-- Rating -->
                                    <div class="mb-3">
                                        @php
                                            $avgRating = $product->ratings()->where('status', 'approved')->avg('rating') ?? 0;
                                            $ratingCount = $product->ratings()->where('status', 'approved')->count();
                                            $fullStars = floor($avgRating);
                                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                        @endphp
                                        <div class="text-warning small mb-2">
                                            @for($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if($hasHalfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                                @php $fullStars++ @endphp
                                            @endif
                                            @for($i = $fullStars; $i < 5; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                            <span class="text-muted">({{ $ratingCount }})</span>
                                        </div>
                                    </div>

                                    <!-- Add to Cart Button -->
                                    <button class="btn btn-primary w-100 add-to-cart-btn" data-product-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart me-2"></i> Thêm Vào Giỏ
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-inbox text-muted" style="font-size: 3rem; margin-bottom: 20px;"></i>
                            <p class="text-muted">Không có sản phẩm trong danh mục này</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links() }}
                    </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Show all categories -->
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-filter me-2 text-primary"></i>Bộ Lọc
                            </h5>

                            <!-- Price Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Giá</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="price1" value="0-500000">
                                    <label class="form-check-label" for="price1">
                                        Dưới 500k
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="price2" value="500000-1000000">
                                    <label class="form-check-label" for="price2">
                                        500k - 1 triệu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="price3" value="1000000-5000000">
                                    <label class="form-check-label" for="price3">
                                        1 - 5 triệu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="price4" value="5000000">
                                    <label class="form-check-label" for="price4">
                                        Trên 5 triệu
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <!-- Rating Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Đánh Giá</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rating5">
                                    <label class="form-check-label" for="rating5">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rating4">
                                    <label class="form-check-label" for="rating4">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-muted">trở lên</span>
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <!-- Reset Button -->
                            <button class="btn btn-outline-primary w-100" onclick="resetFilters()">
                                <i class="fas fa-redo me-2"></i>Xóa Bộ Lọc
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Categories Grid -->
                <div class="col-lg-9">
                    <!-- Sort Options -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">
                            Hiển thị <strong>{{ $totalCategories }}</strong> danh mục
                        </p>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="max-width: 200px;">
                                <option>Sắp xếp mặc định</option>
                                <option>Tên A-Z</option>
                                <option>Tên Z-A</option>
                                <option>Phổ biến nhất</option>
                            </select>
                        </div>
                    </div>

                    <!-- Categories Cards -->
                    <div class="row g-4">
                        @forelse($categories as $category)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('categories') }}?cat={{ $category->id }}" class="category-card h-100 text-decoration-none" style="display: block; border-radius: 15px; overflow: hidden; transition: all 0.3s; text-align: center;">
                                <div class="card border-0 h-100 shadow-sm" style="border-radius: 15px; transition: all 0.3s;">
                                    <!-- Category Image/Icon -->
                                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                                        @if(!empty($category->image) && file_exists(public_path($category->image)))
                                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="font-size: 4rem; opacity: 0.9;">
                                                @switch($category->name)
                                                    @case('Dây Dắt')
                                                        <i class="fas fa-ring text-light"></i>
                                                        @break
                                                    @case('Áo Quần')
                                                        <i class="fas fa-shirt text-light"></i>
                                                        @break
                                                    @case('Thức Ăn')
                                                        <i class="fas fa-bone text-light"></i>
                                                        @break
                                                    @case('Đồ Chơi')
                                                        <i class="fas fa-dice text-light"></i>
                                                        @break
                                                    @case('Giường & Nhà')
                                                        <i class="fas fa-home text-light"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-paw text-light"></i>
                                                @endswitch
                                            </div>
                                        @endif
                                        <!-- Overlay -->
                                        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0); transition: all 0.3s;" class="category-overlay"></div>
                                    </div>

                                    <!-- Category Info -->
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                                        <p class="text-muted small mb-3">
                                            {{ $category->products_count ?? 0 }} sản phẩm
                                        </p>
                                        <button class="btn btn-primary btn-sm w-100" style="border-radius: 8px;">
                                            <i class="fas fa-arrow-right me-1"></i>Khám Phá
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-inbox text-muted" style="font-size: 3rem; margin-bottom: 20px;"></i>
                            <p class="text-muted">Chưa có danh mục nào</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- View All Products Button -->
                    @if($categories)
                    <div class="text-center mt-5">
                        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="fas fa-arrow-right me-2"></i>Xem Tất Cả Sản Phẩm
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- ==================== CTA SECTION ==================== -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container text-center">
        <h2 class="fw-bold display-5 mb-4">Không tìm thấy danh mục bạn muốn?</h2>
        <p class="fs-5 mb-4 text-white-50">Liên hệ với chúng tôi để được hỗ trợ tìm kiếm sản phẩm phù hợp nhất</p>
        <a href="#" class="btn btn-light btn-lg px-5 py-3 fw-bold">
            <i class="fas fa-envelope me-2"></i>Liên Hệ Ngay
        </a>
    </div>
</section>

<!-- ==================== CSS & JS ==================== -->
<style>
    .category-card .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .category-card:hover .card {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .category-card:hover .category-overlay {
        background: rgba(0, 0, 0, 0.2) !important;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .product-card:hover .product-overlay {
        opacity: 1 !important;
    }

    .form-check-input {
        border-radius: 4px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .rounded-lg {
        border-radius: 15px !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 40px 0 !important;
        }

        .page-header h1 {
            font-size: 1.8rem !important;
        }

        .display-5 {
            font-size: 1.8rem !important;
        }
    }
</style>

<script>
    function resetFilters() {
        document.querySelectorAll('.form-check-input').forEach(input => {
            input.checked = false;
        });
        alert('Đã xóa bộ lọc');
    }

    // Add to Cart button
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
        });
    });

    // View Product details
    document.querySelectorAll('.view-product-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            console.log('View product:', productId);
        });
    });
</script>

@endsection
