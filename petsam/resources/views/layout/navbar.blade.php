<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 bg-primary px-5 align-items-center">
        <div class="col-lg-3 d-none d-lg-block">
            <nav class="navbar navbar-light position-relative" style="width: 250px;">
                <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button"
                    data-bs-toggle="collapse" data-bs-target="#allCat">
                    <h4 class="m-0"><i class="fa fa-bars me-2"></i>Danh mục</h4>
                </button>
                <div class="collapse navbar-collapse rounded-bottom" id="allCat">
                    <div class="navbar-nav ms-auto py-0">
                        <ul class="list-unstyled categories-bars">
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Phụ kiện cho chó</a>
                                    <span>(18)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Phụ kiện cho mèo</a>
                                    <span>(12)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Đồ chơi</a>
                                    <span>(20)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Thức ăn & Dinh dưỡng</a>
                                    <span>(14)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Chuồng & Nhà</a>
                                    <span>(6)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-bars-item">
                                    <a href="#">Phụ kiện thủy sinh</a>
                                    <span>(8)</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-12 col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary ">
                <a href="/" class="navbar-brand d-block d-lg-none">
                    <h1 class="display-5 text-secondary m-0"><i class="fas fa-paw text-white me-2"></i>PetSam</h1>
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="/" class="nav-item nav-link active">Trang chủ</a>
                        <a href="/shop" class="nav-item nav-link">Sản phẩm</a>
                        <a href="/product" class="nav-item nav-link">Chi tiết</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Trang khác</a>
                            <div class="dropdown-menu m-0">
                                <a href="#" class="dropdown-item">Bán chạy</a>
                                <a href="#" class="dropdown-item">Giỏ hàng</a>
                                <a href="#" class="dropdown-item">Thanh toán</a>
                                <a href="#" class="dropdown-item">404</a>
                            </div>
                        </div>
                        <a href="/contact" class="nav-item nav-link me-2">Liên hệ</a>
                        
                        @auth
                            @if(is_admin())
                                <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link">
                                    <i class="fa fa-tachometer-alt"></i> Admin
                                </a>
                            @endif
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu m-0">
                                    <a href="/home" class="dropdown-item">
                                        <i class="fa fa-tachometer-alt"></i> Tài khoản
                                    </a>
                                    @if(is_admin())
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                            <i class="fa fa-cog"></i> Admin Panel
                                        </a>
                                    @endif
                                    <hr class="dropdown-divider m-1">
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="nav-item nav-link">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="nav-item nav-link">Đăng ký</a>
                        @endauth
                    </div>
                    <a href="tel:+84987654321" class="btn btn-secondary rounded-pill py-2 px-4 mb-3 mb-md-3 mb-lg-0"><i
                            class="fa fa-phone-alt me-2"></i> +84 987 654 321</a>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->
