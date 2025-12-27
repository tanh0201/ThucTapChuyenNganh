@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Đơn Hàng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Đơn Hàng</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-shopping-cart"></i> Quản Lý Đơn Hàng
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <!-- Không có nút tạo mới vì đơn hàng không tạo từ admin -->
  </div>
</div>

<!-- Flash Messages -->
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fa fa-exclamation-circle"></i> Có lỗi xảy ra!</strong>
    <ul class="mb-0 mt-2">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Orders List -->
<div class="card shadow">
  <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
    <div class="row align-items-center">
      <div class="col-md-12">
        <h6 class="m-0 font-weight-bold text-primary">
          <i class="fa fa-list"></i> Danh Sách Đơn Hàng ({{ $orders->total() }} đơn hàng)
        </h6>
      </div>
    </div>
  </div>
  
  <div class="card-body p-3">
    <!-- Filter Form -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" name="search" 
               placeholder="Mã đơn, email, tên..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <select class="form-control form-control-sm" name="status">
          <option value="">-- Tất cả trạng thái --</option>
          @foreach ($statuses as $key => $label)
            <option value="{{ $key }}" @selected(request('status') === $key)>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-control form-control-sm" name="payment_status">
          <option value="">-- Tất cả thanh toán --</option>
          @foreach ($paymentStatuses as $key => $label)
            <option value="{{ $key }}" @selected(request('payment_status') === $key)>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-sm w-100">
          <i class="fa fa-search"></i> Lọc
        </button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm w-100">
          <i class="fa fa-times"></i> Xóa Lọc
        </a>
      </div>
    </form>

    <!-- Orders Table -->
    @if($orders->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size: 14px;">
          <thead>
            <tr style="background-color: #2e59d9; color: white;">
              <th style="width: 12%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Mã Đơn Hàng</th>
              <th style="width: 20%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Khách Hàng</th>
              <th style="width: 13%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Ngày Đặt</th>
              <th style="width: 15%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: right;">Tổng Tiền</th>
              <th style="width: 12%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Trạng Thái</th>
              <th style="width: 13%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Thanh Toán</th>
              <th style="width: 15%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: center;">Hành Động</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr style="border-bottom: 1px solid #e3e6f0; background-color: #ffffff;">
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <strong>{{ $order->order_number }}</strong>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <div>
                    <strong style="display: block;">{{ $order->user->name ?? 'Guest' }}</strong>
                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                  </div>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  {{ $order->created_at->format('d/m/Y H:i') }}
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: right;">
                  <strong class="text-primary" style="font-size: 14px;">
                    {{ number_format($order->total_price, 0, ',', '.') }}₫
                  </strong>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; 
                    background-color: {{ 
                      $order->status === 'pending' ? '#ffc107' : 
                      ($order->status === 'confirmed' ? '#17a2b8' : 
                      ($order->status === 'processing' ? '#007bff' : 
                      ($order->status === 'shipped' ? '#17a2b8' : 
                      ($order->status === 'delivered' ? '#28a745' : '#6c757d')))) 
                    }}; 
                    color: {{ ($order->status === 'pending') ? '#000' : '#fff' }};">
                    @switch($order->status)
                      @case('pending')
                        Chờ xử lý
                      @break
                      @case('confirmed')
                        Đã xác nhận
                      @break
                      @case('processing')
                        Đang xử lý
                      @break
                      @case('shipped')
                        Đã gửi
                      @break
                      @case('delivered')
                        Đã giao
                      @break
                      @case('cancelled')
                        Đã hủy
                      @break
                    @endswitch
                  </span>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; 
                    background-color: {{ 
                      $order->payment_status === 'pending' ? '#ffc107' : 
                      ($order->payment_status === 'paid' ? '#28a745' : 
                      ($order->payment_status === 'failed' ? '#dc3545' : '#6c757d')) 
                    }}; 
                    color: {{ ($order->payment_status === 'pending') ? '#000' : '#fff' }};">
                    @switch($order->payment_status)
                      @case('pending')
                        Chờ thanh toán
                      @break
                      @case('paid')
                        Đã thanh toán
                      @break
                      @case('failed')
                        Thất bại
                      @break
                      @case('refunded')
                        Hoàn tiền
                      @break
                    @endswitch
                  </span>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: center;">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary" title="Xem chi tiết" style="padding: 6px 10px; font-size: 12px; font-weight: 600;">
                    <i class="fa fa-eye"></i> Xem
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4 p-3">
        {{ $orders->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
        <p class="text-muted">Chưa có đơn hàng nào.</p>
      </div>
    @endif
  </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
  <div class="col-md-3">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="text-primary font-weight-bold text-uppercase mb-1">
          Tổng Đơn Hàng
        </div>
        <div class="h3 mb-0">
          <strong>{{ $orders->total() }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="text-success font-weight-bold text-uppercase mb-1">
          Đã Giao
        </div>
        <div class="h3 mb-0">
          <strong>{{ $orders->where('status', 'delivered')->count() }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="text-info font-weight-bold text-uppercase mb-1">
          Đã Thanh Toán
        </div>
        <div class="h3 mb-0">
          <strong>{{ $orders->where('payment_status', 'paid')->count() }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="text-warning font-weight-bold text-uppercase mb-1">
          Chờ Xử Lý
        </div>
        <div class="h3 mb-0">
          <strong>{{ $orders->where('status', 'pending')->count() }}</strong>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
