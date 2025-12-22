@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 fw-bold mb-4">
                <i class="fas fa-list text-primary me-2"></i>Đơn hàng của tôi
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($orders->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Số lượng sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    {{ $order->orderItems->count() }} sản phẩm
                                </td>
                                <td>
                                    <strong class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }} ₫</strong>
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
                                            <span class="badge bg-secondary">Đã hoàn tiền</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('checkout.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($order->status !== 'shipped' && $order->status !== 'delivered' && $order->status !== 'cancelled')
                                        <form action="{{ route('checkout.cancel', $order->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn hàng">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="card shadow-sm border-0 text-center py-5">
            <div class="card-body">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <h3 class="mt-4 mb-2">Chưa có đơn hàng</h3>
                <p class="text-muted mb-4">Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Đi tới cửa hàng
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
