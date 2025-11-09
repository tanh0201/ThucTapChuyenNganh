<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PetSam Admin - Quản trị ShopPet</title>
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
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sản phẩm">
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
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
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/admin">PetSam Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Quản trị</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-bag"></i>
              </div>
              <div class="mr-5">Sản phẩm: {{ $stats['products'] ?? 0 }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admin/products">
              <span class="float-left">Xem sản phẩm</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-cart"></i>
              </div>
              <div class="mr-5">Đơn hàng: {{ $stats['orders'] ?? 0 }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admin/orders">
              <span class="float-left">Quản lý đơn hàng</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-users"></i>
              </div>
              <div class="mr-5">Người dùng: {{ $stats['users'] ?? 0 }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admin/users">
              <span class="float-left">Quản lý người dùng</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-lightbulb-o"></i>
              </div>
              <div class="mr-5">Gợi ý AI: {{ $stats['ai_suggestions'] ?? 'Đang chạy' }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/admin/ai">
              <span class="float-left">Xem gợi ý AI</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      <!-- Area Chart Example-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Thống kê doanh thu PetSam</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Biểu đồ đơn hàng</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-8 my-auto">
                  <canvas id="myBarChart" width="100" height="50"></canvas>
                </div>
                <div class="col-sm-4 text-center my-auto">
                  <div class="h4 mb-0 text-primary">$34,693</div>
                  <div class="small text-muted">YTD Revenue</div>
                  <hr>
                  <div class="h4 mb-0 text-warning">$18,474</div>
                  <div class="small text-muted">YTD Expenses</div>
                  <hr>
                  <div class="h4 mb-0 text-success">$16,219</div>
                  <div class="small text-muted">YTD Margin</div>
                </div>
              </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
          <!-- Simplified content: recent products + small stats -->
          <div class="mb-0 mt-4">
            <i class="fa fa-box"></i> Sản phẩm gần đây</div>
          <hr class="mt-2">
          <div class="row">
            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header"><i class="fa fa-list"></i> Danh sách sản phẩm gần đây</div>
                <div class="card-body">
                  @if(!empty($recentProducts) && count($recentProducts) > 0)
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th>Ảnh</th>
                          <th>Tên</th>
                          <th>SKU</th>
                          <th>Giá</th>
                          <th>Số lượng</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($recentProducts as $p)
                        <tr>
                          <td><img src="{{ $p->image_url ?? asset('img/no-image.png') }}" alt="" style="height:40px"></td>
                          <td>{{ $p->name }}</td>
                          <td>{{ $p->sku ?? '-' }}</td>
                          <td>{{ number_format($p->price ?? 0) }}₫</td>
                          <td>{{ $p->stock ?? 0 }}</td>
                          <td><a href="/admin/products/{{ $p->id }}" class="btn btn-sm btn-primary">Xem</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  @else
                    <p class="text-muted">Chưa có sản phẩm gần đây.</p>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header"><i class="fa fa-bar-chart"></i> Thống kê nhanh</div>
                <div class="card-body small">
                  <p>Sản phẩm: <strong>{{ $stats['products'] ?? 0 }}</strong></p>
                  <p>Đơn hàng mới: <strong>{{ $stats['orders_new'] ?? 0 }}</strong></p>
                  <p>Gợi ý AI đang chạy: <strong>{{ $stats['ai_suggestions'] ?? 'Đang chạy' }}</strong></p>
                </div>
              </div>
            </div>
          </div>
      <!-- Additional admin widgets can be added here -->
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
  <script src="{{ asset('js/sb-admin-charts.min.js') }}"></script>
  </div>
</body>

</html>
