<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PetSam Admin - Quản lý Sản phẩm</title>
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome (CDN) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS (DataTables CDN) -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
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
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="/admin">
            <i class="fa fa-fw fa-tachometer"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Sản phẩm">
          <a class="nav-link" href="/admin/products">
            <i class="fa fa-fw fa-shopping-bag"></i>
            <span class="nav-link-text">Sản phẩm</span>
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
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admin">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Quản lý Sản phẩm</li>
      </ol>

      <!-- Product Management Tools -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-shopping-bag"></i> Quản lý Sản phẩm
          <a href="/admin/products/create" class="btn btn-primary float-right">
            <i class="fa fa-plus"></i> Thêm sản phẩm mới
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Danh mục</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Trạng thái</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($products))
                  @foreach($products as $product)
                    <tr>
                      <td>{{ $product->id }}</td>
                      <td>
                        <img src="{{ $product->image_url ?? asset('img/no-image.png') }}" alt="{{ $product->name }}" style="height: 50px;">
                      </td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->category->name ?? 'N/A' }}</td>
                      <td>{{ number_format($product->price) }}₫</td>
                      <td>{{ $product->stock }}</td>
                      <td>
                        @if($product->status == 1)
                          <span class="badge badge-success">Còn hàng</span>
                        @else
                          <span class="badge badge-danger">Hết hàng</span>
                        @endif
                      </td>
                      <td>
                        <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-primary btn-sm">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Product Statistics -->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-cube"></i>
              </div>
              <div class="mr-5">Tổng sản phẩm: {{ $stats['total'] ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-check-circle"></i>
              </div>
              <div class="mr-5">Còn hàng: {{ $stats['in_stock'] ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-exclamation-circle"></i>
              </div>
              <div class="mr-5">Hết hàng: {{ $stats['out_of_stock'] ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-tags"></i>
              </div>
              <div class="mr-5">Sắp hết hàng: {{ $stats['low_stock'] ?? 0 }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid-->

    <!-- Footer -->
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

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $('#productsTable').DataTable();
      });
    </script>
  </div>
</body>
</html>