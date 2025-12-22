@extends('layout.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <h1 class="h3 fw-bold">
                <i class="fas fa-shopping-bag text-primary me-2"></i>Quản Lý Đơn Hàng
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

    <!-- Filter Form -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0">Tìm kiếm và lọc</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Mã đơn hàng, email, tên..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">-- Tất cả --</option>
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" @selected(request('status') === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment_status" class="form-label">Thanh toán</label>
                    <select class="form-select" id="payment_status" name="payment_status">
                        <option value="">-- Tất cả --</option>
                        @foreach ($paymentStatuses as $key => $label)
                            <option value="{{ $key }}" @selected(request('payment_status') === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Lọc
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $order->user->name ?? 'Guest' }}</h6>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <strong class="text-primary">
                                    {{ number_format($order->total_price, 0, ',', '.') }} ₫
                                </strong>
                            </td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-info">Đã xác nhận</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-primary">Đang xử lý</span>
                                        @break
                                    @case('shipped')
                                        <span class="badge bg-info">Đã gửi</span>
                                        @break
                                    @case('delivered')
                                        <span class="badge bg-success">Đã giao</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @switch($order->payment_status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Thất bại</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-secondary">Hoàn tiền</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-3">Không có đơn hàng nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
