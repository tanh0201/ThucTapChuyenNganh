@extends('admin.layout.base')

@section('title', 'PetSam Admin - Thống Kê Toàn Bộ')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Thống Kê</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-bar-chart"></i> Thống Kê Toàn Bộ
    </h2>
  </div>
</div>

<!-- Stat Cards -->
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #4e73df; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Doanh Thu</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ number_format($stats['total_revenue'] / 1000000, 1, ',', '.') }}M
        </div>
        <small style="color: #666666;">Tổng cộng tất cả đơn hàng</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #1cc88a; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Đơn Hàng</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ $stats['total_orders'] }}
        </div>
        <small style="color: #666666;">{{ $stats['completed_orders'] }} hoàn tất, {{ $stats['pending_orders'] }} chờ xử lý</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #36b9cc; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Sản Phẩm</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ $stats['total_products'] }}
        </div>
        <small style="color: #666666;">Trong {{ $stats['total_categories'] }} danh mục</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #f6c23e; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Người Dùng</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ $stats['total_users'] }}
        </div>
        <small style="color: #666666;">{{ $newUsers }} người dùng mới trong 30 ngày</small>
      </div>
    </div>
  </div>
</div>

<!-- Growth Stats -->
<div class="row mb-4">
  <div class="col-xl-4">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-line-chart"></i> Tăng Trưởng Tháng Này
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <div class="mb-3">
          <small style="color: #666666; display: block;">Doanh Thu Tháng Này</small>
          <h5 style="color: #4e73df; font-weight: bold; margin-bottom: 0;">
            {{ number_format($currentMonthRevenue / 1000000, 1, ',', '.') }}M
          </h5>
        </div>
        <div class="mb-3">
          <small style="color: #666666; display: block;">Doanh Thu Tháng Trước</small>
          <h5 style="color: #858796; font-weight: bold; margin-bottom: 0;">
            {{ number_format($prevMonthRevenue / 1000000, 1, ',', '.') }}M
          </h5>
        </div>
        <div style="border-top: 1px solid #dee2e6; padding-top: 1rem;">
          <div style="display: flex; align-items: center; gap: 0.5rem;">
            @if($revenueGrowth > 0)
              <i class="fa fa-arrow-up" style="color: #1cc88a; font-size: 1.2rem;"></i>
              <span style="color: #1cc88a; font-weight: bold;">+{{ number_format($revenueGrowth, 1, ',', '.') }}%</span>
            @elseif($revenueGrowth < 0)
              <i class="fa fa-arrow-down" style="color: #dc3545; font-size: 1.2rem;"></i>
              <span style="color: #dc3545; font-weight: bold;">{{ number_format($revenueGrowth, 1, ',', '.') }}%</span>
            @else
              <span style="color: #666666;">Không thay đổi</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-pie-chart"></i> Trạng Thái Đơn Hàng
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <div class="mb-2">
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <small style="color: #666666;">Chờ Xử Lý</small>
            <small style="color: #666666; font-weight: bold;">{{ $orderStatus['pending'] ?? 0 }}</small>
          </div>
          <div style="background-color: #f0f0f0; border-radius: 4px; height: 8px; overflow: hidden;">
            <div style="background-color: #dc3545; height: 100%; width: {{ $stats['total_orders'] > 0 ? (($orderStatus['pending'] ?? 0) / $stats['total_orders'] * 100) : 0 }}%;">
            </div>
          </div>
        </div>
        <div class="mb-2">
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <small style="color: #666666;">Đang Xử Lý</small>
            <small style="color: #666666; font-weight: bold;">{{ $orderStatus['processing'] ?? 0 }}</small>
          </div>
          <div style="background-color: #f0f0f0; border-radius: 4px; height: 8px; overflow: hidden;">
            <div style="background-color: #ffc107; height: 100%; width: {{ $stats['total_orders'] > 0 ? (($orderStatus['processing'] ?? 0) / $stats['total_orders'] * 100) : 0 }}%;">
            </div>
          </div>
        </div>
        <div class="mb-2">
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <small style="color: #666666;">Hoàn Thành</small>
            <small style="color: #666666; font-weight: bold;">{{ $orderStatus['completed'] ?? 0 }}</small>
          </div>
          <div style="background-color: #f0f0f0; border-radius: 4px; height: 8px; overflow: hidden;">
            <div style="background-color: #28a745; height: 100%; width: {{ $stats['total_orders'] > 0 ? (($orderStatus['completed'] ?? 0) / $stats['total_orders'] * 100) : 0 }}%;">
            </div>
          </div>
        </div>
        <div>
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <small style="color: #666666;">Đã Hủy</small>
            <small style="color: #666666; font-weight: bold;">{{ $orderStatus['cancelled'] ?? 0 }}</small>
          </div>
          <div style="background-color: #f0f0f0; border-radius: 4px; height: 8px; overflow: hidden;">
            <div style="background-color: #858796; height: 100%; width: {{ $stats['total_orders'] > 0 ? (($orderStatus['cancelled'] ?? 0) / $stats['total_orders'] * 100) : 0 }}%;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-credit-card"></i> Phương Thức Thanh Toán
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        @forelse($paymentMethods as $method)
          <div class="mb-3">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
              <small style="color: #333333; font-weight: 500;">
                @switch($method->payment_method)
                  @case('cash')
                    Tiền Mặt
                    @break
                  @case('bank_transfer')
                    Chuyển Khoản
                    @break
                  @case('card')
                    Thẻ Tín Dụng
                    @break
                  @default
                    {{ ucfirst($method->payment_method) }}
                @endswitch
              </small>
              <small style="color: #666666;">{{ $method->count }} đơn</small>
            </div>
            <small style="color: #4e73df; font-weight: bold;">{{ number_format($method->revenue / 1000000, 1, ',', '.') }}M</small>
          </div>
        @empty
          <p style="color: #666666; text-align: center;">Chưa có dữ liệu</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Charts Row 1 -->
<div class="row mb-4">
  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-line-chart"></i> Doanh Thu 30 Ngày
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="revenueChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>

  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-shopping-cart"></i> Đơn Hàng 30 Ngày
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="ordersChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Charts Row 2 -->
<div class="row mb-4">
  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-tag"></i> Doanh Thu Theo Danh Mục
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="categoryChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>

  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-bar-chart"></i> Doanh Thu Theo Trạng Thái
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="statusChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Top Products Table -->
<div class="card shadow mb-4" style="background-color: #ffffff;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-star"></i> Top 10 Sản Phẩm Bán Chạy
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    <div class="table-responsive">
      <table class="table table-hover mb-0" style="background-color: #ffffff;">
        <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
          <tr>
            <th style="padding: 1rem; color: #333333;"><strong>#</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Tên Sản Phẩm</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Số Lượng Bán</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Doanh Thu</strong></th>
          </tr>
        </thead>
        <tbody>
          @forelse($topProducts as $index => $product)
            <tr style="border-bottom: 1px solid #dee2e6;">
              <td style="padding: 1rem; color: #333333;">
                <strong>{{ $index + 1 }}</strong>
              </td>
              <td style="padding: 1rem; color: #333333;">
                {{ $product->name }}
              </td>
              <td style="padding: 1rem; color: #333333;">
                <span class="badge" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">{{ $product->total_sold }}</span>
              </td>
              <td style="padding: 1rem; color: #333333;">
                <strong style="color: #1cc88a;">{{ number_format($product->revenue / 1000000, 1, ',', '.') }}M</strong>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="padding: 2rem; text-align: center; color: #999999;">Chưa có dữ liệu</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('additional-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
  // Data from backend
  const revenueChartData = {!! json_encode($revenueChart) !!};
  const ordersChartData = {!! json_encode($ordersChart) !!};
  const categoryChartData = {!! json_encode($categoryChart) !!};
  const revenueByStatus = {!! json_encode($revenueByStatus) !!};

  // Colors
  const colors = {
    primary: '#4e73df',
    success: '#1cc88a',
    info: '#36b9cc',
    warning: '#f6c23e',
    danger: '#dc3545',
    secondary: '#858796',
  };

  // Revenue Chart
  const revenueCtx = document.getElementById('revenueChart');
  if (revenueCtx) {
    new Chart(revenueCtx, {
      type: 'line',
      data: {
        labels: revenueChartData.labels,
        datasets: [{
          label: 'Doanh Thu (Triệu)',
          data: revenueChartData.data,
          borderColor: colors.primary,
          backgroundColor: 'rgba(78, 115, 223, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: colors.primary,
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 4,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true },
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
          },
          x: {
            grid: { color: 'rgba(0,0,0,0.05)' },
          },
        },
      },
    });
  }

  // Orders Chart
  const ordersCtx = document.getElementById('ordersChart');
  if (ordersCtx) {
    new Chart(ordersCtx, {
      type: 'bar',
      data: {
        labels: ordersChartData.labels,
        datasets: [{
          label: 'Số Đơn Hàng',
          data: ordersChartData.data,
          backgroundColor: colors.success,
          borderColor: colors.success,
          borderWidth: 1,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true },
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
          },
          x: {
            grid: { color: 'rgba(0,0,0,0.05)' },
          },
        },
      },
    });
  }

  // Category Chart
  const categoryCtx = document.getElementById('categoryChart');
  if (categoryCtx) {
    new Chart(categoryCtx, {
      type: 'bar',
      data: {
        labels: categoryChartData.labels,
        datasets: [{
          label: 'Doanh Thu (Triệu)',
          data: categoryChartData.data,
          backgroundColor: colors.info,
          borderColor: colors.info,
          borderWidth: 1,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
          legend: { display: true },
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
          },
        },
      },
    });
  }

  // Status Chart
  const statusCtx = document.getElementById('statusChart');
  if (statusCtx) {
    const statusLabels = Object.keys(revenueByStatus).map(status => {
      const statusMap = {
        'pending': 'Chờ Xử Lý',
        'processing': 'Đang Xử Lý',
        'completed': 'Hoàn Thành',
        'cancelled': 'Đã Hủy',
      };
      return statusMap[status] || status;
    });

    const statusData = Object.values(revenueByStatus).map(v => v / 1000000);
    const statusColors = [colors.danger, colors.warning, colors.success, colors.secondary];

    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: statusLabels,
        datasets: [{
          data: statusData,
          backgroundColor: statusColors,
          borderColor: '#fff',
          borderWidth: 2,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
          },
        },
      },
    });
  }
</script>
@endsection
