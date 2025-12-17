<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm" id="mainNav" style="border-bottom: 2px solid #4e73df;">
  <div class="container-fluid px-4">
    <!-- Brand -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-paw text-primary me-2" style="font-size: 1.5rem;"></i>
      <span style="font-size: 1.3rem;">PetSam Admin</span>
    </a>

    <!-- Toggler Button -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <!-- Left Navigation -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}" title="Dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="ms-2">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.products.index') }}" title="Sản phẩm">
            <i class="fas fa-shopping-bag"></i>
            <span class="ms-2">Sản Phẩm</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.categories.index') }}" title="Danh mục">
            <i class="fas fa-folder"></i>
            <span class="ms-2">Danh Mục</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users.index') }}" title="Người dùng">
            <i class="fas fa-users"></i>
            <span class="ms-2">Người Dùng</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.roles.index') }}" title="Phân quyền">
            <i class="fas fa-user-shield"></i>
            <span class="ms-2">Phân Quyền</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.ratings.index') }}" title="Đánh giá sản phẩm">
            <i class="fas fa-star"></i>
            <span class="ms-2">Đánh Giá</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.customer-care.index') }}" title="Chăm sóc khách hàng">
            <i class="fas fa-headset"></i>
            <span class="ms-2">Hỗ Trợ</span>
          </a>
        </li>
      </ul>

      <!-- Right Navigation -->
      <ul class="navbar-nav ms-auto d-flex align-items-center">
        <!-- Theme Toggle -->
        <li class="nav-item me-3">
          <a class="nav-link" id="themeToggle" title="Chuyển chế độ sáng/tối" style="cursor: pointer;">
            @php $currentTheme = session('admin_theme', 'light'); @endphp
            <i class="fas fa-fw @if($currentTheme === 'dark') fa-sun @else fa-moon @endif"></i>
          </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; font-size: 0.9rem; font-weight: bold;">
              {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Hồ Sơ</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Cài Đặt</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  #mainNav {
    padding: 0.75rem 0;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
  }

  #mainNav .navbar-brand {
    font-weight: 700;
    color: #fff !important;
    font-size: 1.5rem;
  }

  #mainNav .nav-link {
    color: rgba(255, 255, 255, 0.7) !important;
    transition: all 0.3s ease;
    padding: 0.5rem 1rem !important;
  }

  #mainNav .nav-link:hover,
  #mainNav .nav-link.active {
    color: #4e73df !important;
    font-weight: 500;
  }

  .dropdown-menu {
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 0.5rem;
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #4e73df;
  }

  .avatar-circle {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  }
</style>
