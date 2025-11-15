@extends('admin.layout.base')

@section('title', 'PetSam Admin - Trang chủ')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Trang chủ</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white o-hidden h-100 shadow" style="background-color: #4e73df;">
      <div class="card-body">
        <div class="card-body-icon"><i class="fa fa-fw fa-cube"></i></div>
        <div style="font-size: 18px; font-weight: 600;">Sản phẩm: {{ $stats['total_products'] }}</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="/admin/products" style="background-color: #224abe;">
        <span class="float-left">Xem sản phẩm</span>
        <span class="float-right"><i class="fa fa-angle-right"></i></span>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white o-hidden h-100 shadow" style="background-color: #1cc88a;">
      <div class="card-body">
        <div class="card-body-icon"><i class="fa fa-fw fa-shopping-cart"></i></div>
        <div style="font-size: 18px; font-weight: 600;">Đơn hàng: {{ $stats['total_orders'] }}</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="/admin/orders" style="background-color: #13855c;">
        <span class="float-left">Xem đơn hàng</span>
        <span class="float-right"><i class="fa fa-angle-right"></i></span>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white o-hidden h-100 shadow" style="background-color: #36b9cc;">
      <div class="card-body">
        <div class="card-body-icon"><i class="fa fa-fw fa-users"></i></div>
        <div style="font-size: 18px; font-weight: 600;">Người dùng: {{ $stats['total_users'] }}</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="/admin/users" style="background-color: #278a96;">
        <span class="float-left">Xem người dùng</span>
        <span class="float-right"><i class="fa fa-angle-right"></i></span>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white o-hidden h-100 shadow" style="background-color: #f6c23e;">
      <div class="card-body">
        <div class="card-body-icon"><i class="fa fa-fw fa-dollar"></i></div>
        <div style="font-size: 18px; font-weight: 600; color: #333333;">Doanh thu: {{ number_format($stats['total_revenue'] / 1000000, 1, ',', '.') }}M</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="/admin/orders" style="background-color: #dda15e;">
        <span class="float-left">Chi tiết doanh thu</span>
        <span class="float-right"><i class="fa fa-angle-right"></i></span>
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card shadow mb-3" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-bar-chart"></i> Doanh thu 7 ngày
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="dashboardChart" style="max-height: 300px;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow mb-3" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-tasks"></i> Hoạt động gần đây
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <ul class="timeline">
          @forelse($recentActivity as $activity)
            <li class="timeline-item">
              <div class="timeline-badge {{ $activity['color'] }}"><i class="fa {{ $activity['icon'] }}"></i></div>
              <div class="timeline-panel">
                <p class="timeline-header"><small style="color: #666666;">{{ $activity['time'] }}</small></p>
                <p style="color: #333333;">{{ $activity['message'] }}</p>
              </div>
            </li>
          @empty
            <li class="timeline-item">
              <p style="color: #999999; text-align: center;">Chưa có hoạt động</p>
            </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card shadow mb-3" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-list"></i> Đơn hàng mới nhất
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff; padding: 0;">
        <div class="table-responsive">
          <table class="table table-sm table-borderless mb-0" style="background-color: #ffffff;">
            <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
              <tr>
                <th style="padding: 1rem; color: #333333;"><strong>Mã</strong></th>
                <th style="padding: 1rem; color: #333333;"><strong>Khách</strong></th>
                <th style="padding: 1rem; color: #333333;"><strong>Tiền</strong></th>
                <th style="padding: 1rem; color: #333333;"><strong>Trạng thái</strong></th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentOrders as $order)
                <tr style="border-bottom: 1px solid #dee2e6;">
                  <td style="padding: 1rem; color: #333333;"><strong>{{ $order['order_number'] }}</strong></td>
                  <td style="padding: 1rem; color: #333333;">{{ $order['customer_name'] }}</td>
                  <td style="padding: 1rem; color: #333333;">{{ number_format($order['total'] / 1000000, 1, ',', '.') }}M</td>
                  <td style="padding: 1rem;">
                    @if($order['status'] === 'completed')
                      <span class="badge" style="background-color: #28a745; color: white; font-size: 12px; padding: 6px 10px;">Hoàn tất</span>
                    @elseif($order['status'] === 'processing')
                      <span class="badge" style="background-color: #ffc107; color: #333333; font-size: 12px; padding: 6px 10px;">Đang xử lý</span>
                    @elseif($order['status'] === 'pending')
                      <span class="badge" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">Mới</span>
                    @else
                      <span class="badge" style="background-color: #dc3545; color: white; font-size: 12px; padding: 6px 10px;">Hủy</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" style="text-align: center; color: #999999; padding: 1.5rem;">Chưa có đơn hàng</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow mb-3" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-star"></i> Sản phẩm bán chạy
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff; padding: 0;">
        <div class="table-responsive">
          <table class="table table-sm table-borderless mb-0" style="background-color: #ffffff;">
            <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
              <tr>
                <th style="padding: 1rem; color: #333333;"><strong>Tên</strong></th>
                <th style="padding: 1rem; color: #333333;"><strong>Bán</strong></th>
                <th style="padding: 1rem; color: #333333;"><strong>Doanh thu</strong></th>
              </tr>
            </thead>
            <tbody>
              @forelse($topProducts as $product)
                <tr style="border-bottom: 1px solid #dee2e6;">
                  <td style="padding: 1rem; color: #333333;">{{ $product['name'] }}</td>
                  <td style="padding: 1rem; color: #333333;">{{ $product['quantity'] }}</td>
                  <td style="padding: 1rem; color: #333333;">{{ number_format($product['revenue'], 1, ',', '.') }}M</td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" style="text-align: center; color: #999999; padding: 1.5rem;">Chưa có dữ liệu</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('additional-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
// Dữ liệu từ backend
const revenueData = @json($revenueChart);

var ctx = document.getElementById("dashboardChart");
if(ctx){
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: revenueData.labels,
      datasets: [{
        label: 'Doanh thu (triệu)',
        data: revenueData.data,
        backgroundColor: '#007bff',
        borderColor: '#004085',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) {
              return value.toLocaleString('vi-VN') + ' triệu';
            }
          }
        }]
      }
    }
  });
}
</script>
@endsection
