<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'PetSam Admin')</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
  @yield('additional-css')
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/admin">PetSam</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Trang chủ">
          <a class="nav-link" href="/admin">
            <i class="fa fa-fw fa-tachometer"></i>
            <span class="nav-link-text">Trang chủ</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/products*')) active @endif" data-toggle="tooltip" data-placement="right" title="Sản phẩm">
          <a class="nav-link" href="/admin/products">
            <i class="fa fa-fw fa-shopping-bag"></i>
            <span class="nav-link-text">Sản phẩm</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/orders*')) active @endif" data-toggle="tooltip" data-placement="right" title="Đơn hàng">
          <a class="nav-link" href="/admin/orders">
            <i class="fa fa-fw fa-shopping-cart"></i>
            <span class="nav-link-text">Đơn hàng</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/users*')) active @endif" data-toggle="tooltip" data-placement="right" title="Người dùng">
          <a class="nav-link" href="/admin/users">
            <i class="fa fa-fw fa-users"></i>
            <span class="nav-link-text">Người dùng</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/roles*')) active @endif" data-toggle="tooltip" data-placement="right" title="Phân quyền">
          <a class="nav-link" href="/admin/roles">
            <i class="fa fa-fw fa-user-secret"></i>
            <span class="nav-link-text">Phân quyền</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/stats*')) active @endif" data-toggle="tooltip" data-placement="right" title="Thống kê">
          <a class="nav-link" href="/admin/stats">
            <i class="fa fa-fw fa-bar-chart"></i>
            <span class="nav-link-text">Thống kê</span>
          </a>
        </li>
        <li class="nav-item @if(request()->is('admin/ai*')) active @endif" data-toggle="tooltip" data-placement="right" title="Gợi ý AI">
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
        <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Tìm kiếm...">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Đăng xuất</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      @yield('breadcrumb')

      <!-- Main Content -->
      @yield('content')

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © PetSam 2025</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Chọn "Đăng xuất" để kết thúc phiên hiện tại.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
            <a class="btn btn-primary" href="/logout">Đăng xuất</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery (CDN) and Bootstrap bundle (CDN) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript (CDN) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <!-- Custom scripts for all pages -->
  <script src="{{ asset('js/sb-admin.min.js') }}"></script>
  <!-- Custom scripts for this page -->
  <script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>
  @yield('additional-js')
</body>

</html>