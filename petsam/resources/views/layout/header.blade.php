<!-- Topbar -->
<div class="container-fluid px-5 d-none border-bottom d-lg-block">
    <div class="row gx-0 align-items-center">
        <div class="col-lg-4 text-center text-lg-start mb-lg-0">
            <div class="d-inline-flex align-items-center" style="height:45px;">
                <a href="#" class="text-muted me-2">Hỗ trợ</a><small> / </small>
                <a href="#" class="text-muted mx-2">Chính sách</a><small> / </small>
                <a href="#" class="text-muted ms-2">Liên hệ</a>
            </div>
        </div>
        <div class="col-lg-4 text-center d-flex align-items-center justify-content-center">
            <small class="text-dark">Gọi ngay:</small>
            <a href="tel:+84987654321" class="text-muted ms-2">(+84) 987 654 321</a>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
            <div class="d-inline-flex align-items-center" style="height:45px;">
                <a href="#" class="text-muted mx-2"><i class="fa fa-user me-1"></i>Tài khoản</a>
                <a href="#" class="text-muted mx-2"><i class="fa fa-heart me-1"></i>Yêu thích</a>
                <a href="#" class="text-muted mx-2"><i class="fa fa-shopping-cart me-1"></i>Giỏ hàng</a>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="container-fluid px-5 py-4 d-none d-lg-block">
    <div class="row gx-0 align-items-center text-center">
        <div class="col-md-4 col-lg-3 text-center text-lg-start">
            <a href="{{ url('/') }}" class="navbar-brand p-0">
                <h1 class="display-5 text-primary m-0">
                    <i class="fas fa-paw text-secondary me-2"></i>PetSam
                </h1>
            </a>
        </div>
        <div class="col-md-4 col-lg-6 text-center">
            <div class="position-relative ps-4">
                <div class="d-flex border rounded-pill">
                    <input class="form-control border-0 rounded-pill w-100 py-3" type="text" placeholder="Tìm phụ kiện cho thú cưng...">
                    <select class="form-select text-dark border-0 border-start rounded-0 p-3" style="width:200px;">
                        <option>Tất cả</option>
                        <option>Chó</option>
                        <option>Mèo</option>
                        <option>Chim</option>
                        <option>Hamster</option>
                    </select>
                    <button type="button" class="btn btn-primary rounded-pill py-3 px-5"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 text-center text-lg-end">
            <div class="d-inline-flex align-items-center">
                <a href="#" class="text-muted me-3"><i class="fas fa-random"></i></a>
                <a href="#" class="text-muted me-3"><i class="fas fa-heart"></i></a>
                <a href="#" class="text-muted"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 bg-primary px-5 align-items-center">
        <div class="col-lg-3 d-none d-lg-block">
            <nav class="navbar navbar-light position-relative" style="width:250px;">
                <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#allCat">
                    <h4 class="m-0"><i class="fa fa-bars me-2"></i>Danh mục</h4>
                </button>
                <div class="collapse navbar-collapse rounded-bottom" id="allCat">
                    <ul class="list-unstyled categories-bars">
                        <li><a href="#">Phụ kiện cho chó</a></li>
                        <li><a href="#">Phụ kiện cho mèo</a></li>
                        <li><a href="#">Đồ chơi</a></li>
                        <li><a href="#">Thức ăn & dinh dưỡng</a></li>
                        <li><a href="#">Chuồng & Nhà</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-12 col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">Trang chủ</a>
                        <a href="{{ url('shop') }}" class="nav-item nav-link">Sản phẩm</a>
                        <a href="{{ url('contact') }}" class="nav-item nav-link">Liên hệ</a>
                    </div>
                    <a href="#" class="btn btn-secondary rounded-pill py-2 px-4 mb-2 mb-lg-0">
                        <i class="fa fa-phone-alt me-2"></i> Hỗ trợ 24/7
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>
