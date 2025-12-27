@extends('admin.layout.base')

@section('title', 'PetSam Admin - Chi Tiết Đơn Hàng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.orders.index') }}">Đơn Hàng</a>
  </li>
  <li class="breadcrumb-item active">{{ $order->order_number }}</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-receipt"></i> Chi Tiết Đơn Hàng: {{ $order->order_number }}
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
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

<div class="row">
    <!-- Order Details (Main) -->
    <div class="col-lg-8">
        <!-- Order Information -->
        <div class="card shadow" style="border: none; margin-bottom: 20px;">
          <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fa fa-info-circle"></i> Thông Tin Đơn Hàng
            </h6>
          </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-md-6">
                <p class="text-muted mb-1"><strong>Số đơn hàng:</strong></p>
                <p style="font-size: 16px; font-weight: bold; letter-spacing: 1px; color: #2c3e50;">
                  {{ $order->order_number }}
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1"><strong>Ngày đặt:</strong></p>
                <p style="font-weight: 600; color: #2c3e50;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
              </div>
            </div>

            <hr>

            <!-- Customer Info & Shipping Address -->
            <div class="row">
              <div class="col-md-6">
                <h6 class="font-weight-bold mb-3" style="color: #2c3e50;">Khách Hàng</h6>
                @if ($order->user)
                  <p class="mb-2" style="color: #2c3e50;">
                    <strong>Tên:</strong> {{ $order->user->name }}
                  </p>
                  <p class="mb-2" style="color: #2c3e50;">
                    <strong>Email:</strong> {{ $order->user->email }}
                  </p>
                  <p class="mb-0" style="color: #2c3e50;">
                    <strong>Điện thoại:</strong> {{ $order->user->phone ?? 'N/A' }}
                  </p>
                @else
                  <p class="text-muted">Khách hàng không tồn tại</p>
                @endif
              </div>
              <div class="col-md-6">
                <h6 class="font-weight-bold mb-3" style="color: #2c3e50;">Địa Chỉ Giao Hàng</h6>
                <p class="mb-2" style="color: #2c3e50;">{{ $order->shipping_address }}</p>
                <p class="mb-0" style="color: #2c3e50;">
                  <strong>SĐT:</strong> {{ $order->phone }}
                </p>
              </div>
            </div>

            @if ($order->notes)
              <hr>
              <h6 class="font-weight-bold mb-2" style="color: #2c3e50;">Ghi Chú:</h6>
              <p class="text-muted mb-0">{{ $order->notes }}</p>
            @endif
          </div>
        </div>

        <!-- Order Items -->
        <div class="card shadow" style="border: none;">
          <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fa fa-shopping-bag"></i> Sản Phẩm Đã Đặt
            </h6>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0" style="font-size: 14px;">
                <thead>
                  <tr style="background-color: #2e59d9; color: white;">
                    <th style="width: 50%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Sản Phẩm</th>
                    <th style="width: 15%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: center;">Giá</th>
                    <th style="width: 15%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: center;">Số Lượng</th>
                    <th style="width: 20%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: right;">Thành Tiền</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($order->orderItems as $item)
                    <tr style="border-bottom: 1px solid #e3e6f0; background-color: #ffffff;">
                      <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                        @if ($item->product)
                          <strong>{{ $item->product->name }}</strong>
                          <br>
                          <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                        @else
                          <span class="text-muted">Sản phẩm không tồn tại</span>
                        @endif
                      </td>
                      <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: center;">
                        {{ number_format($item->price, 0, ',', '.') }}₫
                      </td>
                      <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: center;">
                        <strong>{{ $item->quantity }}</strong>
                      </td>
                      <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: right;">
                        <strong class="text-primary">{{ number_format($item->total, 0, ',', '.') }}₫</strong>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div style="padding: 15px 12px; background-color: #f8f9fa; text-align: right; border-top: 1px solid #e3e6f0;">
              <h5 class="font-weight-bold" style="color: #2c3e50;">
                Tổng Cộng: <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
              </h5>
            </div>
          </div>
        </div>
    </div>

    <!-- Status Management (Sidebar) -->
    <div class="col-lg-4">
        <!-- Order Status -->
        <div class="card shadow" style="border: none; margin-bottom: 20px;">
          <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fa fa-tasks"></i> Trạng Thái Đơn Hàng
            </h6>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="status" class="form-label font-weight-bold">Cập Nhật Trạng Thái</label>
                <select class="form-control @error('status') is-invalid @enderror" 
                        id="status" 
                        name="status" 
                        required
                        style="padding: 8px 12px; border-radius: 4px;">
                  @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}" @selected($order->status === $key)>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
                @error('status')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary w-100" style="padding: 10px; font-weight: 600;">
                <i class="fa fa-save"></i> Cập Nhật Trạng Thái
              </button>
            </form>

            <!-- Current Status Display -->
            <div style="margin-top: 15px; padding: 12px; background-color: #f8f9fa; border-radius: 4px;">
              <p class="text-muted mb-2">Trạng thái hiện tại:</p>
              <div>
                <span class="badge" style="padding: 8px 12px; font-size: 12px; font-weight: 600;
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
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Status -->
        <div class="card shadow" style="border: none; margin-bottom: 20px;">
          <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fa fa-credit-card"></i> Thanh Toán
            </h6>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.orders.updatePaymentStatus', $order->id) }}" method="POST">
              @csrf
              
              <!-- Payment Method -->
              <div class="mb-3">
                <label class="form-label font-weight-bold">Phương Thức Thanh Toán</label>
                <div style="padding: 12px; background-color: #e7f3ff; border-left: 4px solid #2e59d9; border-radius: 4px; color: #2c3e50;">
                  @switch($order->payment_method)
                    @case('cod')
                      <i class="fa fa-money-bill me-2"></i><strong>Thanh toán khi nhận hàng (COD)</strong>
                    @break
                    @case('bank_transfer')
                      <i class="fa fa-university me-2"></i><strong>Chuyển khoản ngân hàng</strong>
                    @break
                    @case('online')
                      <i class="fa fa-credit-card me-2"></i><strong>Thanh toán trực tuyến</strong>
                    @break
                  @endswitch
                </div>
              </div>

              <!-- Payment Status Selector -->
              <div class="mb-3">
                <label for="payment_status" class="form-label font-weight-bold">Cập Nhật Trạng Thái Thanh Toán</label>
                <select class="form-control @error('payment_status') is-invalid @enderror" 
                        id="payment_status" 
                        name="payment_status" 
                        required
                        style="padding: 8px 12px; border-radius: 4px;">
                  @foreach ($paymentStatuses as $key => $label)
                    <option value="{{ $key }}" @selected($order->payment_status === $key)>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
                @error('payment_status')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary w-100" style="padding: 10px; font-weight: 600;">
                <i class="fa fa-save"></i> Cập Nhật Thanh Toán
              </button>
            </form>

            <!-- Current Payment Status Display -->
            <div style="margin-top: 15px; padding: 12px; background-color: #f8f9fa; border-radius: 4px;">
              <p class="text-muted mb-2">Trạng thái hiện tại:</p>
              <div>
                <span class="badge" style="padding: 8px 12px; font-size: 12px; font-weight: 600;
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
              </div>
            </div>

            <!-- Payment Details for Bank Transfer and Online -->
            @if($order->payment_method === 'bank_transfer' || $order->payment_method === 'online')
            <hr style="margin-top: 20px;">
            <div style="margin-top: 15px;">
              <h6 class="font-weight-bold mb-3" style="color: #2c3e50;">Chi Tiết Giao Dịch</h6>
              
              @if($order->transaction_id)
              <div class="mb-3" style="padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                <p class="text-muted mb-1" style="font-size: 12px;"><strong>ID Giao Dịch:</strong></p>
                <code style="color: #2c3e50;">{{ $order->transaction_id }}</code>
              </div>
              @endif

              @if($order->bank_code)
              <div class="mb-3" style="padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                <p class="text-muted mb-1" style="font-size: 12px;"><strong>Mã Ngân Hàng:</strong></p>
                <span class="badge bg-secondary">{{ $order->bank_code }}</span>
              </div>
              @endif

              @if($order->bank_tran_no)
              <div class="mb-3" style="padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                <p class="text-muted mb-1" style="font-size: 12px;"><strong>Số Tham Chiếu:</strong></p>
                <code style="color: #2c3e50;">{{ $order->bank_tran_no }}</code>
              </div>
              @endif

              @if($order->payment_date)
              <div class="mb-3" style="padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                <p class="text-muted mb-1" style="font-size: 12px;"><strong>Ngày Thanh Toán:</strong></p>
                <p class="mb-0" style="color: #2c3e50;">{{ $order->payment_date->format('d/m/Y H:i:s') }}</p>
              </div>
              @endif

              @if($order->payment_ip)
              <div style="padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                <p class="text-muted mb-1" style="font-size: 12px;"><strong>IP Thanh Toán:</strong></p>
                <code style="color: #2c3e50;">{{ $order->payment_ip }}</code>
              </div>
              @endif
            </div>
            @endif
          </div>
        </div>

        <!-- Summary Card -->
        <div class="card shadow" style="border: none; margin-bottom: 20px; background-color: #f8f9fa;">
          <div class="card-body">
            <h6 class="font-weight-bold mb-3" style="color: #2c3e50;">Tóm Tắt</h6>
            <div style="border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 10px;">
              <p class="mb-2" style="color: #2c3e50;">
                <strong>Số Sản Phẩm:</strong> <span class="badge bg-primary">{{ $order->orderItems->count() }}</span>
              </p>
            </div>
            <div style="border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 10px;">
              <p class="mb-2">
                <strong>Tổng Tiền:</strong>
              </p>
              <h5 class="text-primary font-weight-bold" style="font-size: 20px;">
                {{ number_format($order->total_price, 0, ',', '.') }}₫
              </h5>
            </div>
            <div>
              <p class="text-muted mb-0" style="font-size: 12px;">
                <i class="fa fa-calendar"></i> <strong>Cập Nhật:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Delete Order -->
        @if ($order->status === 'cancelled' || $order->status === 'delivered')
          <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100" style="padding: 10px; font-weight: 600;">
              <i class="fa fa-trash"></i> Xóa Đơn Hàng
            </button>
          </form>
        @endif
    </div>
</div>

@endsection
