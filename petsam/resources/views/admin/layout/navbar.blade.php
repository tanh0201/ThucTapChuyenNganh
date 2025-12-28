<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm" id="mainNav" style="border-bottom: 2px solid #4e73df;">
  <div class="container-fluid px-4">
    <!-- Brand -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-paw text-primary me-2" style="font-size: 1.5rem;"></i>
      <span style="font-size: 1.3rem;">PetSam Admin</span>
    </a>

    <!-- Back to Home Button -->
    <a href="/" class="btn btn-outline-light btn-sm ms-3" title="Về Trang Chủ">
      <i class="fas fa-home me-1"></i>
      <span class="d-none d-md-inline">Trang Chủ</span>
    </a>

    <!-- Toggler Button -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <!-- Left Navigation -->
      <ul class="navbar-nav me-auto">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}" title="Dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="ms-2">Dashboard</span>
          </a>
        </li>

        <!-- Danh Mục -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-folder"></i>
            <span class="ms-2">Danh Mục</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
            <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="fas fa-list me-2"></i>Danh Sách Danh Mục</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.categories.create') }}"><i class="fas fa-plus me-2"></i>Thêm Danh Mục</a></li>
          </ul>
        </li>

        <!-- Sản Phẩm Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-shopping-bag"></i>
            <span class="ms-2">Sản Phẩm</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="productsDropdown">
            <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="fas fa-box me-2"></i>Danh Sách Sản Phẩm</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.products.create') }}"><i class="fas fa-plus me-2"></i>Thêm Sản Phẩm</a></li>
          </ul>
        </li>

        <!-- Quản Lý Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-tasks"></i>
            <span class="ms-2">Quản Lý</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="managementDropdown">
            <li><h6 class="dropdown-header"><i class="fas fa-receipt me-2"></i>Bán Hàng</h6></li>
            <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart me-2"></i>Đơn Hàng</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.ratings.index') }}"><i class="fas fa-star me-2"></i>Đánh Giá</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header"><i class="fas fa-headset me-2"></i>Hỗ Trợ</h6></li>
            <li><a class="dropdown-item" href="{{ route('admin.customer-care.index') }}"><i class="fas fa-comments me-2"></i>Hỗ Trợ Khách</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.contacts.index') }}"><i class="fas fa-envelope me-2"></i>Liên Hệ</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.email-logs.index') }}"><i class="fas fa-envelope-open me-2"></i>Email Logs</a></li>
          </ul>
        </li>

        <!-- Hệ Thống Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="systemDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs"></i>
            <span class="ms-2">Hệ Thống</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="systemDropdown">
            <li><a class="dropdown-item" href="{{ route('admin.site-info.index') }}"><i class="fas fa-globe me-2"></i>Thông Tin Trang Web</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fas fa-users me-2"></i>Người Dùng</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.users.create') }}"><i class="fas fa-user-plus me-2"></i>Thêm Người Dùng</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('admin.roles.index') }}"><i class="fas fa-user-shield me-2"></i>Phân Quyền</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.permissions.index') }}"><i class="fas fa-lock me-2"></i>Quyền</a></li>
          </ul>
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
            <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="fas fa-cog me-2"></i> Cài Đặt</a></li>
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
    font-size: 0.95rem;
  }

  #mainNav .nav-link:hover,
  #mainNav .nav-link.active {
    color: #4e73df !important;
    font-weight: 500;
  }

  /* Dropdown hover effect - show on hover */
  .navbar-nav .dropdown:hover > .dropdown-menu {
    display: block;
    animation: slideDown 0.2s ease-out;
  }

  .navbar-nav .dropdown > .dropdown-toggle::after {
    transition: transform 0.3s ease;
  }

  .navbar-nav .dropdown:hover > .dropdown-toggle::after {
    transform: rotate(180deg);
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Dropdown Menu Styling */
  .dropdown-menu {
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 0.5rem;
    min-width: 200px;
    top: 100%;
  }

  .dropdown-item {
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #4e73df;
    padding-left: 1.5rem;
  }

  .dropdown-header {
    padding: 0.6rem 1.2rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4e73df;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.3rem;
  }

  .dropdown-divider {
    margin: 0.3rem 0;
    opacity: 0.3;
  }

  /* Active dropdown link */
  #mainNav .dropdown-menu .dropdown-item.active {
    background-color: #4e73df;
    color: white !important;
  }

  .avatar-circle {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  }
</style>

<script>
  // Highlight active dropdown based on current route
  document.addEventListener('DOMContentLoaded', function() {
    const currentRoute = '{{ Route::currentRouteName() }}';
    
    // Check which dropdown should be active
    const dropdownRoutes = {
      'productsDropdown': ['admin.products.', 'admin.categories.'],
      'managementDropdown': ['admin.orders.', 'admin.ratings.', 'admin.customer-care.', 'admin.contacts.', 'admin.email-logs.'],
      'systemDropdown': ['admin.users.', 'admin.roles.', 'admin.permissions.', 'admin.site-info.']
    };

    for (let [dropdownId, routes] of Object.entries(dropdownRoutes)) {
      const dropdown = document.getElementById(dropdownId);
      if (routes.some(route => currentRoute.startsWith(route))) {
        dropdown?.parentElement.classList.add('active');
        dropdown?.classList.add('text-primary');
      }
    }

    // Highlight active dropdown items
    const items = document.querySelectorAll('.dropdown-item');
    items.forEach(item => {
      if (item.href === window.location.href) {
        item.classList.add('active');
      }
    });
  });
</script>
