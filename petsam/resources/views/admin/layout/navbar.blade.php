<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="/admin">PetSam</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link" href="/admin">
          <i class="fa fa-fw fa-tachometer"></i>
          <span class="nav-link-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sản phẩm">
        <a class="nav-link" href="/admin/products">
          <i class="fa fa-fw fa-shopping-bag"></i>
          <span class="nav-link-text">Sản phẩm</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Danh mục">
        <a class="nav-link" href="/admin/categories">
          <i class="fa fa-fw fa-folder"></i>
          <span class="nav-link-text">Danh mục</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Đơn hàng">
        <a class="nav-link" href="/admin/orders">
          <i class="fa fa-fw fa-shopping-cart"></i>
          <span class="nav-link-text">Đơn hàng</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Người dùng">
        <a class="nav-link" href="/admin/users">
          <i class="fa fa-fw fa-users"></i>
          <span class="nav-link-text">Người dùng</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Phân quyền">
        <a class="nav-link" href="/admin/roles">
          <i class="fa fa-fw fa-user-secret"></i>
          <span class="nav-link-text">Phân quyền</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Thống kê">
        <a class="nav-link" href="/admin/stats">
          <i class="fa fa-fw fa-bar-chart"></i>
          <span class="nav-link-text">Thống kê</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gợi ý AI">
        <a class="nav-link" href="/admin/ai">
          <i class="fa fa-fw fa-lightbulb-o"></i>
          <span class="nav-link-text">Gợi ý AI</span>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-envelope"></i>
          <span class="d-lg-none">Messages
            <span class="badge badge-pill badge-primary" id="msgCount">0</span>
          </span>
          <span class="indicator text-primary d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="messagesDropdown" id="messagesContainer">
          <h6 class="dropdown-header">Tin nhắn:</h6>
          <div class="dropdown-divider"></div>
          <div id="messagesList">
            <a class="dropdown-item" href="#">Không có tin nhắn</a>
          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">Xem tất cả tin nhắn</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-bell"></i>
          <span class="d-lg-none">Alerts
            <span class="badge badge-pill badge-warning" id="notifCount">0</span>
          </span>
          <span class="indicator text-warning d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="alertsDropdown" id="notificationsContainer">
          <h6 class="dropdown-header">Thông báo:</h6>
          <div class="dropdown-divider"></div>
          <div id="notificationsList">
            <a class="dropdown-item" href="#">Không có thông báo</a>
          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">Xem tất cả thông báo</a>
        </div>
      </li>
      <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 mr-lg-2">
          <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="themeToggle" title="Toggle Dark/Light Mode" style="cursor: pointer;">
          @php $currentTheme = session('admin_theme', 'light'); @endphp
          <i class="fa fa-fw @if($currentTheme === 'dark') fa-sun-o @else fa-moon-o @endif"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
          <i class="fa fa-fw fa-sign-out"></i>Logout</a>
      </li>
    </ul>
  </div>
</nav>
