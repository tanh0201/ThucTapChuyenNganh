@extends('layout.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
            <h1 class="h3 fw-bold">
                <i class="fas fa-receipt text-primary me-2"></i>Chi Tiết Đơn Hàng
            </h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Có lỗi xảy ra!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Số đơn hàng</h6>
                            <p style="font-size: 18px; letter-spacing: 1px;">
                                <strong>{{ $order->order_number }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Ngày đặt</h6>
                            <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Khách hàng</h6>
                            @if ($order->user)
                                <p class="mb-1"><strong>Tên:</strong> {{ $order->user->name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                                <p class="mb-0"><strong>Điện thoại:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                            @else
                                <p class="text-muted">Khách hàng không tồn tại</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Địa chỉ giao hàng</h6>
                            <p class="mb-1">{{ $order->shipping_address }}</p>
                            <p class="mb-0"><strong>SĐT:</strong> {{ $order->phone }}</p>
                        </div>
                    </div>

                    @if ($order->notes)
                        <hr>
                        <h6 class="fw-bold mb-2">Ghi chú:</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            @if ($item->product)
                                                <a href="{{ route('admin.products.show', $item->product->id) }}" class="text-decoration-none">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Sản phẩm không tồn tại</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($item->price, 0, ',', '.') }} ₫
                                        </td>
                                        <td class="text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($item->total, 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="text-end">
                        <h5 class="fw-bold">
                            Tổng cộng: <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="col-lg-4">
            <!-- Order Status -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Trạng thái đơn hàng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Cập nhật trạng thái</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected($order->status === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Cập nhật
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Trạng thái thanh toán</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updatePaymentStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="payment_status" class="form-label fw-semibold">Phương thức thanh toán</label>
                            <div class="alert alert-info mb-3">
                                @switch($order->payment_method)
                                    @case('cod')
                                        <i class="fas fa-money-bill me-2"></i>Thanh toán khi nhận hàng
                                        @break
                                    @case('bank_transfer')
                                        <i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng
                                        @break
                                    @case('online')
                                        <i class="fas fa-credit-card me-2"></i>Thanh toán trực tuyến
                                        @break
                                @endswitch
                            </div>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                @foreach ($paymentStatuses as $key => $label)
                                    <option value="{{ $key }}" @selected($order->payment_status === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Cập nhật
                        </button>
                    </form>

                    <!-- Payment Details for Bank Transfer and Online -->
                    @if($order->payment_method === 'bank_transfer' || $order->payment_method === 'online')
                    <hr>
                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">Chi tiết thanh toán</h6>
                        
                        @if($order->transaction_id)
                        <p class="mb-2">
                            <strong>ID Giao dịch:</strong><br>
                            <code>{{ $order->transaction_id }}</code>
                        </p>
                        @endif

                        @if($order->bank_code)
                        <p class="mb-2">
                            <strong>Mã ngân hàng:</strong><br>
                            <span class="badge bg-secondary">{{ $order->bank_code }}</span>
                        </p>
                        @endif

                        @if($order->bank_tran_no)
                        <p class="mb-2">
                            <strong>Số tham chiếu:</strong><br>
                            <code>{{ $order->bank_tran_no }}</code>
                        </p>
                        @endif

                        @if($order->payment_date)
                        <p class="mb-2">
                            <strong>Ngày thanh toán:</strong><br>
                            {{ $order->payment_date->format('d/m/Y H:i:s') }}
                        </p>
                        @endif

                        @if($order->payment_ip)
                        <p class="mb-0">
                            <strong>IP:</strong><br>
                            <code>{{ $order->payment_ip }}</code>
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Summary -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Tóm tắt</h6>
                    <p class="mb-2">
                        <strong>Số sản phẩm:</strong> {{ $order->orderItems->count() }}
                    </p>
                    <p class="mb-2">
                        <strong>Tổng tiền:</strong> <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                    </p>
                    <p class="mb-0">
                        <strong>Cập nhật lần cuối:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            <!-- Delete Order -->
            @if ($order->status === 'cancelled' || $order->status === 'delivered')
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Xóa đơn hàng
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
