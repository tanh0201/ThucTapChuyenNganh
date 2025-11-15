@extends('admin.layout.base')

@section('title', 'PetSam Admin - Dashboard')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Tổng quan</li>
</ol>
@endsection

@section('content')

<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #4e73df; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Sản Phẩm</small>
        </div>
        <div style="font-size: 2rem; margin-bottom: 0; font-weight: 600; color: #333333;">{{ $stats['total_products'] ?? 0 }}</div>
        <a href="/admin/products" class="btn btn-sm btn-primary mt-2">Quản lý</a>
      </div>
    </div>
  </div>

 
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #36b9cc; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Danh Mục</small>
        </div>
        <div style="font-size: 2rem; margin-bottom: 0; font-weight: 600; color: #333333;">{{ $stats['total_categories'] ?? 0 }}</div>
        <a href="/admin/categories" class="btn btn-sm btn-info mt-2">Quản lý</a>
      </div>
    </div>
  </div>

  
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #1cc88a; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Đơn Hàng</small>
        </div>
        <div style="font-size: 2rem; margin-bottom: 0; font-weight: 600; color: #333333;">{{ $stats['total_orders'] ?? 0 }}</div>
        <a href="/admin/orders" class="btn btn-sm btn-success mt-2">Quản lý</a>
      </div>
    </div>
  </div>

  
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #f6c23e; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Người Dùng</small>
        </div>
        <div style="font-size: 2rem; margin-bottom: 0; font-weight: 600; color: #333333;">{{ $stats['total_users'] ?? 0 }}</div>
        <a href="/admin/users" class="btn btn-sm btn-warning mt-2">Quản lý</a>
      </div>
    </div>
  </div>
</div>


<div class="row mb-4">
  
  <div class="col-xl-8">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-area-chart"></i> Biểu Đồ Doanh Thu
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="myAreaChart" width="100%" height="30"></canvas>
      </div>
      <div class="card-footer small" style="background-color: #f8f9fa; color: #666666;">Cập nhật: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
  </div>

  
  <div class="col-xl-4">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-bar-chart"></i> Thống Kê Nhanh
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        @if(isset($ytdRevenue))
          <div class="mb-3">
            <small style="color: #666666; display: block;">Doanh Thu Năm Nay</small>
            <h5 style="color: #4e73df; font-weight: bold;">
              {{ number_format($ytdRevenue ?? 0, 0, ',', '.') }}₫
            </h5>
          </div>
        @endif
        @if(isset($ytdExpenses))
          <div class="mb-3">
            <small style="color: #666666; display: block;">Chi Phí Năm Nay</small>
            <h5 style="color: #f6c23e; font-weight: bold;">
              {{ number_format($ytdExpenses ?? 0, 0, ',', '.') }}₫
            </h5>
          </div>
        @endif
        @if(isset($ytdMargin))
          <div>
            <small style="color: #666666; display: block;">Lợi Nhuận Năm Nay</small>
            <h5 style="color: #1cc88a; font-weight: bold;">
              {{ number_format($ytdMargin ?? 0, 0, ',', '.') }}₫
            </h5>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>


<div class="row">

  <div class="col-xl-8">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-bar-chart"></i> Biểu Đồ Đơn Hàng & Doanh Thu
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="myBarChart" width="100%" height="50"></canvas>
      </div>
      <div class="card-footer small" style="background-color: #f8f9fa; color: #666666;">Cập nhật: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
  </div>

 
  <div class="col-xl-4">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-clock-o"></i> Đơn Hàng Chờ Xử Lý
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <div class="text-center">
          <h3 style="color: #f6c23e; font-weight: bold;">{{ $stats['pending_orders'] ?? 0 }}</h3>
          <p style="color: #666666; margin-bottom: 0; font-size: 14px;">Đơn hàng cần phê duyệt</p>
          <a href="/admin/orders" class="btn btn-sm btn-warning mt-3">Xem Chi Tiết</a>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="card shadow mb-4" style="background-color: #ffffff;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-list"></i> Sản Phẩm Gần Đây
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    @if(isset($recentProducts) && count($recentProducts) > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="background-color: #ffffff;">
          <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <tr>
              <th style="padding: 1rem; color: #333333;"><strong>Ảnh</strong></th>
              <th style="padding: 1rem; color: #333333;"><strong>Tên Sản Phẩm</strong></th>
              <th style="padding: 1rem; color: #333333;"><strong>Giá</strong></th>
              <th style="padding: 1rem; color: #333333;"><strong>Số Lượng</strong></th>
              <th style="padding: 1rem; text-align: center; color: #333333;"><strong>Hành Động</strong></th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentProducts as $product)
              <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 1rem;">
                  @if(!empty($product['image']) && file_exists(public_path('storage/' . $product['image'])))
                    <img src="{{ asset('storage/' . $product['image']) }}" 
                         alt="{{ $product['name'] }}" 
                         style="height:40px; width: 40px; object-fit: cover; border-radius: 4px;">
                  @else
                    <span class="badge" style="background-color: #858796; color: white; font-size: 12px; padding: 6px 10px;">Không có ảnh</span>
                  @endif
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <strong>{{ $product['name'] ?? 'N/A' }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  {{ number_format($product['price'] ?? 0, 0, ',', '.') }}₫
                </td>
                <td style="padding: 1rem;">
                  <span class="badge" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">{{ $product['stock'] ?? 0 }}</span>
                </td>
                <td style="padding: 1rem; text-align: center;">
                  <a href="/admin/products/{{ $product['id'] }}" 
                     class="btn btn-sm btn-primary" 
                     title="Xem chi tiết">
                    <i class="fa fa-eye"></i> Xem
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div style="text-align: center; padding: 1.5rem; background-color: #ffffff;">
        <a href="/admin/products" class="btn btn-outline-primary">Xem Tất Cả Sản Phẩm</a>
      </div>
    @else
      <div style="text-align: center; padding: 3rem; background-color: #ffffff;">
        <p style="color: #666666; margin-bottom: 0;">Chưa có sản phẩm nào</p>
      </div>
    @endif
  </div>
</div>
@endsection

@section('additional-js')
<script>
(function() {
  
  const revenueData = {!! json_encode($revenueData ?? []) !!}; 
  const orderData = {!! json_encode($orderData ?? []) !!}; 

 
  const formatCurrency = (value) => value.toLocaleString('vi-VN') + '₫';

  
  const initRevenueChart = () => {
    const areaCtx = document.getElementById('myAreaChart');
    if (!areaCtx) return;

    if (!revenueData.labels || revenueData.labels.length === 0) {
      console.warn('Dữ liệu biểu đồ doanh thu không hợp lệ');
      areaCtx.style.display = 'none';
      return;
    }

    new Chart(areaCtx, {
      type: 'line',
      data: {
        labels: revenueData.labels,
        datasets: [{
          label: 'Doanh Thu (₫)',
          lineTension: 0.3,
          backgroundColor: 'rgba(78, 115, 223, 0.05)',
          borderColor: 'rgba(78, 115, 223, 1)',
          borderWidth: 2,
          pointRadius: 5,
          pointBackgroundColor: 'rgba(78, 115, 223, 1)',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointHoverRadius: 7,
          data: revenueData.data || [],
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: formatCurrency,
            },
            gridLines: {
              color: 'rgba(0, 0, 0, .05)',
            },
          }],
          xAxes: [{
            gridLines: {
              color: 'rgba(0, 0, 0, .05)',
            },
          }],
        },
        legend: {
          display: true,
        },
        title: {
          display: true,
          text: 'Doanh Thu 12 Tháng',
        },
      }
    });
  };


  const initOrderChart = () => {
    const barCtx = document.getElementById('myBarChart');
    if (!barCtx) return;

    if (!orderData.labels || orderData.labels.length === 0) {
      console.warn('Dữ liệu biểu đồ đơn hàng không hợp lệ');
      barCtx.style.display = 'none';
      return;
    }

    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: orderData.labels,
        datasets: [
          {
            label: 'Số Đơn Hàng',
            backgroundColor: 'rgba(78, 115, 223, 0.8)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1,
            data: orderData.orderCounts || [],
            yAxisID: 'y',
          },
          {
            label: 'Doanh Thu (₫)',
            backgroundColor: 'rgba(133, 135, 150, 0.8)',
            borderColor: 'rgba(133, 135, 150, 1)',
            borderWidth: 1,
            data: orderData.revenue || [],
            yAxisID: 'y1',
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            title: {
              display: true,
              text: 'Số Đơn Hàng',
            },
            ticks: {
              beginAtZero: true,
            },
            gridLines: {
              color: 'rgba(0, 0, 0, .05)',
            },
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            title: {
              display: true,
              text: 'Doanh Thu (₫)',
            },
            ticks: {
              beginAtZero: true,
              callback: formatCurrency,
            },
            gridLines: {
              drawOnChartArea: false,
            },
          },
        },
      }
    });
  };

 
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initRevenueChart();
      initOrderChart();
    });
  } else {
    initRevenueChart();
    initOrderChart();
  }
})();
</script>
@endsection
