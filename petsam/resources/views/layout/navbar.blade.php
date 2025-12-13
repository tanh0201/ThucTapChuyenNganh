<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid px-4">
        <!-- Logo + Search -->
        <div class="d-flex align-items-center flex-grow-1">
            <a href="/" class="navbar-brand fw-bold text-white me-4">
                <i class="fas fa-paw me-2"></i>PetSam
            </a>
            <div class="input-group d-none d-lg-flex" style="max-width: 400px;">
                <input type="text" class="form-control form-control-sm" placeholder="Tìm sản phẩm...">
                <button class="btn btn-light btn-sm" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Toggler Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">Sản phẩm</a>
                </li>
                <!-- Danh mục dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        @php
                            $categories = \App\Models\Category::where('status', 'active')->get();
                        @endphp
                        @forelse($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('categories') }}?cat={{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item disabled">Không có danh mục</span></li>
                        @endforelse
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ</a>
                </li>
                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(Auth::user()->role_id == 1)
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </ul>
                    @else
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                    @endauth
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="tel:+84987654321">
                        <i class="fas fa-phone me-1"></i> +84 987 654 321
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->
