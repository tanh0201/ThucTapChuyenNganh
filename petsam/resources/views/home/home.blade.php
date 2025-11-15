@extends('layout.app')

@section('title', 'PetSam - Cửa hàng phụ kiện thú cưng')
@section('description', 'PetSam - Cửa hàng phụ kiện thú cưng, gợi ý sản phẩm thông minh bằng AI.')

@section('content')

    <!-- Carousel Start -->
    <div class="container-fluid carousel bg-light px-0">
        <div class="row g-0 justify-content-end">
            <div class="col-12 col-lg-7 col-xl-9">
                <div class="header-carousel owl-carousel bg-light py-0">
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img wow fadeInLeft" data-wow-delay="0.1s">
                            <img src="img/pets-banner-1.jpg" class="img-fluid w-100" alt="PetSam promo">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 wow fadeInRight" data-wow-delay="0.1s"
                                style="letter-spacing: 3px;">Giảm đến 50%</h4>
                            <h1 class="display-3 text-capitalize mb-4 wow fadeInRight" data-wow-delay="0.3s">Phụ kiện
                                mới cho thú cưng</h1>
                            <p class="text-dark wow fadeInRight" data-wow-delay="0.5s">Chất lượng & An toàn cho thú cưng
                                của bạn.</p>
                            <a class="btn btn-primary rounded-pill py-3 px-5 wow fadeInRight" data-wow-delay="0.7s"
                                href="#">Mua ngay</a>
                        </div>
                    </div>
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img wow fadeInLeft" data-wow-delay="0.1s">
                            <img src="img/pets-banner-2.jpg" class="img-fluid w-100" alt="PetSam promo 2">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 wow fadeInRight" data-wow-delay="0.1s"
                                style="letter-spacing: 3px;">Ưu đãi combo</h4>
                            <h1 class="display-3 text-capitalize mb-4 wow fadeInRight" data-wow-delay="0.3s">Bộ quà tặng
                                thú cưng</h1>
                            <p class="text-dark wow fadeInRight" data-wow-delay="0.5s">Tiết kiệm hơn khi mua combo.</p>
                            <a class="btn btn-primary rounded-pill py-3 px-5 wow fadeInRight" data-wow-delay="0.7s"
                                href="#">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-6 col-md-4 col-lg-2 border-start border-end wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4">
                    <div class="d-inline-flex align-items-center">
                        <i class="fa fa-sync-alt fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Đổi trả 30 ngày</h6>
                            <p class="mb-0">Đảm bảo hài lòng hoặc hoàn tiền</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.2s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-telegram-plane fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Giao hàng nhanh</h6>
                            <p class="mb-0">Giao toàn quốc</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-life-ring fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Hỗ trợ 24/7</h6>
                            <p class="mb-0">Tư vấn dinh dưỡng & chăm sóc</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.4s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-credit-card fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Thanh toán linh hoạt</h6>
                            <p class="mb-0">Nhiều phương thức thanh toán</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.5s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Mua sắm an toàn</h6>
                            <p class="mb-0">Bảo mật thông tin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.6s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-blog fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Blog chuyên môn</h6>
                            <p class="mb-0">Mẹo chăm sóc & dinh dưỡng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Offer Start -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <a href="#" class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                        <div>
                            <p class="text-muted mb-3">Dành cho thú cưng yêu thương</p>
                            <h3 class="text-primary">Bộ chăm sóc sức khỏe</h3>
                            <h1 class="display-3 text-secondary mb-0">30% <span class="text-primary fw-normal">Off</span></h1>
                        </div>
                        <img src="img/product-offer-1.png" class="img-fluid" alt="">
                    </a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                    <a href="#" class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                        <div>
                            <p class="text-muted mb-3">Thời trang & phụ kiện</p>
                            <h3 class="text-primary">Áo & Dây dắt</h3>
                            <h1 class="display-3 text-secondary mb-0">25% <span class="text-primary fw-normal">Off</span></h1>
                        </div>
                        <img src="img/product-offer-2.png" class="img-fluid" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Offer End -->

    <!-- Our Products Start -->
    <div class="container-fluid product py-5">
        <div class="container py-5">
            <div class="tab-class">
                <div class="row g-4">
                    <div class="col-lg-4 text-start wow fadeInLeft" data-wow-delay="0.1s">
                        <h1>Sản phẩm của chúng tôi</h1>
                        <p class="text-muted">Phụ kiện, đồ chơi, thức ăn và nhiều hơn nữa cho thú cưng của bạn.</p>
                    </div>
                    <div class="col-lg-8 text-end wow fadeInRight" data-wow-delay="0.1s">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item mb-4">
                                <a class="d-flex mx-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1"><span class="text-dark" style="width: 130px;">Tất cả sản phẩm</span></a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="d-flex py-2 mx-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2"><span
                                        class="text-dark" style="width: 130px;">Mới về</span></a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="d-flex mx-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3"><span
                                        class="text-dark" style="width: 130px;">Đặc sắc</span></a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="d-flex mx-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4"><span
                                        class="text-dark" style="width: 130px;">Bán chạy</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- Tab 1: All Products -->
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <!-- Product Item 1 -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="img/product-3.png" class="img-fluid w-100 rounded-top" alt="Dây dắt">
                                            <div class="product-new">Mới</div>
                                            <div class="product-details">
                                                <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center rounded-bottom p-4">
                                            <a href="#" class="d-block mb-2">Dây dắt</a>
                                            <a href="#" class="d-block h4">Dây dắt phản quang - PetSam</a>
                                            <del class="me-2 fs-5">₫150.000</del>
                                            <span class="text-primary fs-5">₫120.000</span>
                                        </div>
                                    </div>
                                    <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                                            <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-3">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                                </a>
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-0">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Item 2 -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="img/product-4.png" class="img-fluid w-100 rounded-top" alt="Áo mèo">
                                            <div class="product-sale">Sale</div>
                                            <div class="product-details">
                                                <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center rounded-bottom p-4">
                                            <a href="#" class="d-block mb-2">Áo ấm</a>
                                            <a href="#" class="d-block h4">Áo len cho mèo con</a>
                                            <del class="me-2 fs-5">₫120.000</del>
                                            <span class="text-primary fs-5">₫95.000</span>
                                        </div>
                                    </div>
                                    <div class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                                            <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-3">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                                </a>
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-0">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Item 3 -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="img/product-5.png" class="img-fluid w-100 rounded-top" alt="Thức ăn">
                                            <div class="product-details">
                                                <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center rounded-bottom p-4">
                                            <a href="#" class="d-block mb-2">Thức ăn</a>
                                            <a href="#" class="d-block h4">Hạt dinh dưỡng cho chó nhỏ</a>
                                            <del class="me-2 fs-5">₫260.000</del>
                                            <span class="text-primary fs-5">₫220.000</span>
                                        </div>
                                    </div>
                                    <div class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                                            <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-3">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                                </a>
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-0">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Item 4 -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.7s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="img/product-6.png" class="img-fluid w-100 rounded-top" alt="Chuồng">
                                            <div class="product-new">Mới</div>
                                            <div class="product-details">
                                                <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center rounded-bottom p-4">
                                            <a href="#" class="d-block mb-2">Chuồng</a>
                                            <a href="#" class="d-block h4">Chuồng nhựa cho hamster</a>
                                            <del class="me-2 fs-5">₫650.000</del>
                                            <span class="text-primary fs-5">₫599.000</span>
                                        </div>
                                    </div>
                                    <div class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                                            <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-3">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                                </a>
                                                <a href="#" class="text-primary d-flex align-items-center justify-content-center me-0">
                                                    <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ... Bạn có thể nhân bản thêm item tương tự để lấp full grid ... -->
                        </div>
                    </div>

                    <!-- Tab 2: New Arrivals -->
                    <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <!-- copy some items or show different ones -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                              <!-- product item -->
                              <div class="product-item rounded wow fadeInUp">
                                <div class="product-item-inner border rounded">
                                  <div class="product-item-inner-item">
                                    <img src="img/product-7.png" class="img-fluid w-100 rounded-top" alt="">
                                    <div class="product-new">Mới</div>
                                  </div>
                                  <div class="text-center rounded-bottom p-4">
                                    <a href="#" class="d-block mb-2">Vòng cổ</a>
                                    <a href="#" class="d-block h4">Vòng cổ da cho chó</a>
                                    <span class="text-primary fs-5">₫180.000</span>
                                  </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                  <a href="#" class="btn btn-primary rounded-pill py-2 px-4 mb-4"><i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                                </div>
                              </div>
                            </div>
                            <!-- ... -->
                        </div>
                    </div>

                    <!-- Tab 3: Featured -->
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <!-- featured items -->
                        </div>
                    </div>

                    <!-- Tab 4: Top Selling -->
                    <div id="tab-4" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <!-- top selling items -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Products End -->

    <!-- ✨ AI Recommendation Section (thêm vào dưới Our Products) -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-3 text-primary">🐾 Gợi ý sản phẩm cho bạn (AI Recommendation)</h2>
            <p class="text-center mb-4 text-muted">Mục này là placeholder — sau khi backend AI sẵn sàng, bạn chỉ cần cung cấp API trả về sản phẩm gợi ý và thay nội dung tĩnh bằng dữ liệu động.</p>
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="border rounded text-center p-3">
                        <img src="img/recommend1.jpg" class="img-fluid mb-3 rounded" alt="recommend">
                        <h5 class="mb-1">Dây dắt phản quang</h5>
                        <div class="mb-2 text-primary fw-bold">₫120.000</div>
                        <a href="#" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="border rounded text-center p-3">
                        <img src="img/recommend2.jpg" class="img-fluid mb-3 rounded" alt="recommend2">
                        <h5 class="mb-1">Áo ấm cho mèo</h5>
                        <div class="mb-2 text-primary fw-bold">₫95.000</div>
                        <a href="#" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="border rounded text-center p-3">
                        <img src="img/recommend3.jpg" class="img-fluid mb-3 rounded" alt="recommend3">
                        <h5 class="mb-1">Hạt dinh dưỡng chó nhỏ</h5>
                        <div class="mb-2 text-primary fw-bold">₫220.000</div>
                        <a href="#" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
                <!-- nếu cần hiển thị nhiều hơn, copy thẻ trên -->
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary rounded-pill px-5 py-2">Xem thêm gợi ý</a>
            </div>
        </div>
    </div>

    <!-- Product Banner Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <a href="#">
                        <div class="bg-primary rounded position-relative">
                            <img src="img/product-banner.jpg" class="img-fluid w-100 rounded" alt="banner">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                                style="background: rgba(255, 255, 255, 0.5);">
                                <h3 class="display-5 text-primary">Bộ quà tặng <br><span>PetCare</span></h3>
                                <p class="fs-4 text-muted">₫899.000</p>
                                <a href="#" class="btn btn-primary rounded-pill align-self-start py-2 px-4">Mua ngay</a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <a href="#">
                        <div class="text-center bg-primary rounded position-relative">
                            <img src="img/product-banner-2.jpg" class="img-fluid w-100" alt="banner2">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                                style="background: rgba(242, 139, 0, 0.5);">
                                <h2 class="display-2 text-secondary">SALE</h2>
                                <h4 class="display-5 text-white mb-4">Giảm đến 50%</h4>
                                <a href="#" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">Mua ngay</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Banner End -->

    <!-- Product List Start (mini product list on sidebar) -->
    <div class="container-fluid products productList overflow-hidden">
        <div class="container products-mini py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="products-mini-item border">
                        <div class="row g-0">
                            <div class="col-5">
                                <div class="products-mini-img border-end h-100">
                                    <img src="img/product-3.png" class="img-fluid w-100 h-100" alt="mini">
                                    <div class="products-mini-icon rounded-circle bg-primary">
                                        <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="products-mini-content p-3">
                                    <a href="#" class="d-block mb-2">Dây dắt phản quang</a>
                                    <a href="#" class="d-block h6">PetSam - Dây dắt phản quang</a>
                                    <del class="me-2 fs-6">₫150.000</del>
                                    <span class="text-primary fs-6">₫120.000</span>
                                </div>
                            </div>
                        </div>
                        <div class="products-mini-add border p-3">
                            <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                    class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>

                <!-- copy blocks similar để hiển thị nhiều sản phẩm -->
            </div>
        </div>
    </div>
    <!-- Product List End -->

    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1>Tin tức & Hướng dẫn</h1>
                <p class="text-muted">Bài viết hữu ích về chăm sóc thú cưng, dinh dưỡng và mẹo chọn phụ kiện.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card border-0">
                        <img src="img/blog-1.jpg" class="card-img-top" alt="blog">
                        <div class="card-body">
                            <h5 class="card-title">Cách chăm sóc chó con</h5>
                            <p class="card-text text-muted">Những lưu ý cơ bản cho chó con trong 3 tháng đầu.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc tiếp</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0">
                        <img src="img/blog-2.jpg" class="card-img-top" alt="blog2">
                        <div class="card-body">
                            <h5 class="card-title">Dinh dưỡng cho mèo</h5>
                            <p class="card-text text-muted">Lựa chọn thức ăn phù hợp theo độ tuổi.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc tiếp</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="card border-0">
                        <img src="img/blog-3.jpg" class="card-img-top" alt="blog3">
                        <div class="card-body">
                            <h5 class="card-title">Thiết kế hồ cá đẹp</h5>
                            <p class="card-text text-muted">Các mẹo chọn cây và trang trí hồ thủy sinh.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc tiếp</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional-js')
<script>
    // Init carousel and animations for home page
    $(window).on('load', function () {
        // init carousel if owl exists
        if ($('.header-carousel').length) {
            $('.header-carousel').owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                items: 1,
                dots: true,
                loop: true,
                nav: false
            });
        }
    });
</script>
@endsection
