@extends('layout.app')

@section('title', 'PetSam - Cửa hàng phụ kiện thú cưng')
@section('description', 'Mua phụ kiện thú cưng chất lượng cao với giá tốt nhất. Giao hàng nhanh toàn quốc.')

@section('content')

<!-- ==================== HERO BANNER ==================== -->
<section class="hero-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 100px 0; color: white; position: relative; overflow: hidden; min-height: 500px;">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Left Content -->
            <div class="col-lg-5 col-md-6 mb-4 mb-lg-0 pe-lg-5">
                <h1 class="display-3 fw-bold mb-4" style="line-height: 1.2;">
                    Phụ kiện thú cưng chất lượng cao
                </h1>
                <p class="fs-5 mb-5 text-white-50" style="line-height: 1.6;">
                    Tìm mọi thứ cần thiết cho thú cưng yêu quý của bạn - từ dây dắt, áo, đến thức ăn dinh dưỡng. Giá cạnh tranh, giao hàng nhanh chóng.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('shop') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold" style="border-radius: 50px;">
                        <i class="fas fa-shopping-cart me-2"></i> Khám Phá Sản Phẩm
                    </a>
                    <a href="{{ route('categories') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold" style="border-radius: 50px; border-width: 2px;">
                        <i class="fas fa-list me-2"></i> Xem Danh Mục
                    </a>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="col-lg-6 col-md-6 text-center">
                <div class="hero-image-box" style="background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%); border-radius: 30px; padding: 40px; position: relative; box-shadow: 0 30px 80px rgba(0,0,0,0.3); transform: perspective(1000px) rotateY(-5deg); animation: float 3s ease-in-out infinite;">
                    <img src="img/pets-banner-1.jpg" alt="Thú cưng" class="img-fluid" style="max-height: 350px; width: 100%; object-fit: cover; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 0;"></div>
    <div style="position: absolute; bottom: -100px; left: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; z-index: 0;"></div>
</section>

<!-- ==================== STATS SECTION ==================== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h2 class="display-5 text-primary fw-bold mb-2">{{ $totalProducts ?? 0 }}</h2>
                    <p class="text-muted mb-0">Sản phẩm</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h2 class="display-5 text-success fw-bold mb-2">{{ $totalCategories ?? 0 }}</h2>
                    <p class="text-muted mb-0">Danh mục</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h2 class="display-5 text-info fw-bold mb-2">10K+</h2>
                    <p class="text-muted mb-0">Khách hàng hài lòng</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card p-4">
                    <h2 class="display-5 text-warning fw-bold mb-2">⭐ 4.9</h2>
                    <p class="text-muted mb-0">Đánh giá trung bình</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== BENEFITS SECTION ==================== -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold display-5">Tại sao chọn PetSam?</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="benefit-card h-100 p-4 text-center rounded-lg" style="background: #f8f9fa; border: none; transition: all 0.3s;">
                    <div class="feature-icon mb-3" style="font-size: 3rem;">
                        <i class="fas fa-shipping-fast text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Giao Hàng Nhanh</h5>
                    <p class="text-muted">Giao hàng trong 1-3 ngày trên toàn quốc. Miễn phí cho đơn hàng từ 500k</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="benefit-card h-100 p-4 text-center rounded-lg" style="background: #f8f9fa; border: none; transition: all 0.3s;">
                    <div class="feature-icon mb-3" style="font-size: 3rem;">
                        <i class="fas fa-shield-alt text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">100% Chính Hãng</h5>
                    <p class="text-muted">Tất cả sản phẩm đều là hàng chính hãng, được kiểm chứng chất lượng</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="benefit-card h-100 p-4 text-center rounded-lg" style="background: #f8f9fa; border: none; transition: all 0.3s;">
                    <div class="feature-icon mb-3" style="font-size: 3rem;">
                        <i class="fas fa-undo text-info"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Đổi Trả 30 Ngày</h5>
                    <p class="text-muted">Không hài lòng? Đổi trả miễn phí trong 30 ngày, không cần lý do</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="benefit-card h-100 p-4 text-center rounded-lg" style="background: #f8f9fa; border: none; transition: all 0.3s;">
                    <div class="feature-icon mb-3" style="font-size: 3rem;">
                        <i class="fas fa-headset text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Hỗ Trợ 24/7</h5>
                    <p class="text-muted">Đội ngũ chuyên viên sẵn sàng hỗ trợ bạn mọi lúc qua chat, email, phone</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CUSTOMER CARE CTA ==================== -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="fw-bold display-5 mb-3">
                    <i class="fas fa-question-circle me-2"></i> Có Câu Hỏi Hay Vấn Đề?
                </h3>
                <p class="fs-5 mb-4 text-white-50">
                    Liên hệ với chúng tôi ngay hôm nay. Đội hỗ trợ của chúng tôi luôn sẵn sàng giúp bạn giải quyết bất kỳ vấn đề nào.
                </p>
                <a href="{{ route('customer-care.index') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold" style="border-radius: 50px;">
                    <i class="fas fa-paper-plane me-2"></i> Gửi Yêu Cầu Hỗ Trợ
                </a>
                @auth
                    <p class="text-white-50 mt-3 mb-0">
                        <i class="fas fa-check-circle me-1"></i> Xem yêu cầu của tôi <a href="{{ route('customer-care.my-tickets') }}" class="text-white fw-bold">tại đây</a>
                    </p>
                @endauth
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
                <i class="fas fa-headset" style="font-size: 150px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- ==================== FEATURED PRODUCTS ==================== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-3">Sản Phẩm Nổi Bật</h2>
            <p class="text-muted fs-5">Những sản phẩm được yêu thích nhất của khách hàng PetSam</p>
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
                        @endif
                        
                        <!-- Badge -->
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
                <p class="text-muted">Chưa có sản phẩm nào</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5 py-3">
                <i class="fas fa-arrow-right me-2"></i> Xem Tất Cả Sản Phẩm
            </a>
        </div>
    </div>
</section>

<!-- ==================== CATEGORIES ==================== -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold display-5 text-center mb-5">Danh Mục Sản Phẩm</h2>
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('categories') }}?cat={{ $category->id }}" class="category-card d-block rounded-lg overflow-hidden text-decoration-none" style="border-radius: 15px; transition: all 0.3s; text-align: center;">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 15px; transition: all 0.3s;">
                        <!-- Category Image -->
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                            @if(!empty($category->image) && file_exists(public_path($category->image)))
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="font-size: 3rem; opacity: 0.9;">
                                    <i class="fas fa-paw text-light"></i>
                                </div>
                            @endif
                            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0); transition: all 0.3s;" class="category-overlay"></div>
                        </div>

                        <!-- Category Info -->
                        <div style="padding: 20px; color: white; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <h4 class="fw-bold mb-2 text-white">{{ $category->name }}</h4>
                            <p class="text-white-50 small mb-0">
                                {{ $category->products_count ?? 0 }} sản phẩm
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có danh mục</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==================== CTA SECTION ==================== -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container text-center">
        <h2 class="fw-bold display-5 mb-4">Sẵn sàng chăm sóc thú cưng?</h2>
        <p class="fs-5 mb-4 text-white-50">Hơn 10,000 khách hàng đã tin tưởng PetSam. Bạn sẽ là tiếp theo!</p>
        <a href="{{ route('shop') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold">
            <i class="fas fa-shopping-cart me-2"></i> Mua Sắm Ngay
        </a>
    </div>
</section>

<!-- ==================== TESTIMONIALS ==================== -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold display-5 text-center mb-5">Đánh Giá Từ Khách Hàng</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded-lg" style="background: white; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">"Sản phẩm chất lượng, giao hàng nhanh. Chó của tôi rất thích dây dắt mới từ PetSam!"</p>
                    <p class="fw-bold mb-1">Nguyễn Thị A</p>
                    <p class="text-muted small">TP. Hồ Chí Minh</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded-lg" style="background: white; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">"Mèo của tôi rất thích áo ấm. Chất lượng tốt, giá hợp lý. Sẽ mua lại!"</p>
                    <p class="fw-bold mb-1">Trần Văn B</p>
                    <p class="text-muted small">Hà Nội</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded-lg" style="background: white; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">"Hỗ trợ khách hàng rất tốt. Mình có thắc mắc được giải đáp nhanh chóng."</p>
                    <p class="fw-bold mb-1">Lê Thị C</p>
                    <p class="text-muted small">Đà Nẵng</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== NEWSLETTER ==================== -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold display-5 mb-3">Nhận thông tin khuyến mãi</h2>
                <p class="text-muted fs-5">Đăng ký email để nhận những ưu đãi độc quyền và tin tức mới nhất từ PetSam</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2" id="newsletter-form">
                    <input type="email" class="form-control form-control-lg" placeholder="Nhập email của bạn" required>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CSS & JS ==================== -->
<style>
    .hero-section {
        position: relative;
    }

    /* Float Animation */
    @keyframes float {
        0%, 100% {
            transform: perspective(1000px) rotateY(-5deg) translateY(0px);
        }
        50% {
            transform: perspective(1000px) rotateY(-5deg) translateY(-20px);
        }
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .product-card:hover .product-overlay {
        opacity: 1 !important;
    }

    .category-card:hover {
        transform: scale(1.05);
    }

    .rounded-lg {
        border-radius: 15px !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .hero-banner {
            padding: 60px 0 !important;
            min-height: auto !important;
        }

        .hero-banner h1 {
            font-size: 1.8rem !important;
        }

        .hero-image-box {
            margin-top: 30px;
            padding: 20px !important;
        }

        .display-4, .display-5 {
            font-size: 1.8rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to Cart button
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
                // TODO: Integrate with shopping cart API
            });
        });

        // View Product details
        document.querySelectorAll('.view-product-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                // TODO: Navigate to product detail page
                console.log('View product:', productId);
            });
        });

        // Newsletter form
        const newsletterForm = document.getElementById('newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input[type="email"]').value;
                alert('Cảm ơn bạn đã đăng ký! Email xác nhận sẽ được gửi tới: ' + email);
                this.reset();
            });
        }
    });
</script>

@endsection
