@extends('layout.master')

@section('title', 'PetSam - Trang chủ')

@section('content')

<!-- Hero Carousel -->
<div class="container-fluid px-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('img/banner-dog.jpg') }}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center flex-column text-center">
                <h1 class="text-white display-3 mb-3 animated slideInDown">Phụ kiện cho chó cưng</h1>
                <p class="text-white mb-4 animated slideInUp">Khám phá thế giới phụ kiện chất lượng cao cho người bạn trung thành của bạn.</p>
                <a href="{{ url('shop') }}" class="btn btn-primary py-3 px-5 animated slideInUp">Mua ngay</a>
            </div>
        </div>
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('img/banner-cat.jpg') }}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center flex-column text-center">
                <h1 class="text-white display-3 mb-3 animated slideInDown">Đồ dùng cho mèo yêu</h1>
                <p class="text-white mb-4 animated slideInUp">Từ đồ chơi đến thức ăn — tất cả đều có tại PetSam!</p>
                <a href="{{ url('shop') }}" class="btn btn-secondary py-3 px-5 animated slideInUp">Xem thêm</a>
            </div>
        </div>
    </div>
</div>

<!-- Service Start -->
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-3 col-sm-6 text-center">
            <div class="bg-light p-4 rounded">
                <i class="fa fa-truck fa-3x text-primary mb-3"></i>
                <h5>Giao hàng miễn phí</h5>
                <p>Miễn phí cho đơn hàng trên 300.000đ</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 text-center">
            <div class="bg-light p-4 rounded">
                <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>Chất lượng đảm bảo</h5>
                <p>Cam kết hàng chính hãng 100%</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 text-center">
            <div class="bg-light p-4 rounded">
                <i class="fa fa-undo fa-3x text-primary mb-3"></i>
                <h5>Đổi trả dễ dàng</h5>
                <p>Đổi trả miễn phí trong 7 ngày</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 text-center">
            <div class="bg-light p-4 rounded">
                <i class="fa fa-headset fa-3x text-primary mb-3"></i>
                <h5>Hỗ trợ 24/7</h5>
                <p>Đội ngũ thân thiện, tận tâm</p>
            </div>
        </div>
    </div>
</div>

<!-- Product Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-primary">Sản phẩm nổi bật</h2>
        <p>Phụ kiện mới nhất dành cho thú cưng của bạn</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/sp1.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Dây dắt chó chống rối</h6>
                <p class="text-primary fw-bold mb-2">150.000đ</p>
                <a href="{{ url('single') }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/sp2.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Nhà ngủ êm ái cho mèo</h6>
                <p class="text-primary fw-bold mb-2">290.000đ</p>
                <a href="{{ url('single') }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/sp3.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Thức ăn hạt cao cấp</h6>
                <p class="text-primary fw-bold mb-2">450.000đ</p>
                <a href="{{ url('single') }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/sp4.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Đồ chơi bóng chuông</h6>
                <p class="text-primary fw-bold mb-2">90.000đ</p>
                <a href="{{ url('single') }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
            </div>
        </div>
    </div>
</div>

<!-- AI Recommendation Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-secondary">Gợi ý cho bạn (AI Recommendation)</h2>
        <p>Hệ thống AI PetSam đề xuất sản phẩm dựa trên hành vi và sở thích của bạn</p>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/ai1.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Bát ăn tự động thông minh</h6>
                <p class="text-primary fw-bold mb-2">380.000đ</p>
                <button class="btn btn-outline-secondary btn-sm">Thêm vào giỏ</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/ai2.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Dụng cụ tắm gội tiện lợi</h6>
                <p class="text-primary fw-bold mb-2">210.000đ</p>
                <button class="btn btn-outline-secondary btn-sm">Thêm vào giỏ</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/ai3.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Áo khoác mùa đông cho mèo</h6>
                <p class="text-primary fw-bold mb-2">190.000đ</p>
                <button class="btn btn-outline-secondary btn-sm">Thêm vào giỏ</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="product-item text-center border rounded p-3">
                <img src="{{ asset('img/ai4.jpg') }}" class="img-fluid mb-3" alt="">
                <h6>Thức ăn hạt vị cá hồi</h6>
                <p class="text-primary fw-bold mb-2">320.000đ</p>
                <button class="btn btn-outline-secondary btn-sm">Thêm vào giỏ</button>
            </div>
        </div>
    </div>
</div>

<!-- Blog Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="text-primary">Tin tức & Mẹo chăm thú cưng</h2>
    </div>
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="border rounded p-3">
                <img src="{{ asset('img/blog1.jpg') }}" class="img-fluid rounded mb-3" alt="">
                <h6>Mẹo tắm cho chó không sợ nước</h6>
                <p>Hướng dẫn từng bước giúp chó yêu cảm thấy thoải mái khi tắm.</p>
                <a href="#" class="btn btn-link p-0">Đọc thêm <i class="fa fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="border rounded p-3">
                <img src="{{ asset('img/blog2.jpg') }}" class="img-fluid rounded mb-3" alt="">
                <h6>Chọn đồ chơi phù hợp cho mèo</h6>
                <p>Không phải đồ chơi nào mèo cũng thích — cùng PetSam khám phá nhé!</p>
                <a href="#" class="btn btn-link p-0">Đọc thêm <i class="fa fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="border rounded p-3">
                <img src="{{ asset('img/blog3.jpg') }}" class="img-fluid rounded mb-3" alt="">
                <h6>5 món đồ không thể thiếu khi nuôi hamster</h6>
                <p>Chuồng, bánh xe, thức ăn, và những vật dụng nhỏ nhưng cần thiết.</p>
                <a href="#" class="btn btn-link p-0">Đọc thêm <i class="fa fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

@endsection
