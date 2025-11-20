@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Welcome Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-home"></i> Chào mừng {{ Auth::user()->name }}!
                    </h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <p class="lead">Bạn đã đăng nhập thành công vào hệ thống PetSam.</p>
                    
                    @if(is_admin())
                        <div class="alert alert-info">
                            <i class="fas fa-shield-alt"></i> Bạn là quản trị viên. 
                            <a href="{{ route('admin.dashboard') }}" class="alert-link">Đi đến bảng điều khiển admin</a>
                        </div>
                    @else
                        <p>Bạn có thể:</p>
                        <ul>
                            <li><a href="/">Quay lại trang chủ</a></li>
                            <li><a href="/shop">Xem cửa hàng sản phẩm</a></li>
                            <li>Xem lịch sử đơn hàng của bạn</li>
                            <li>Cập nhật thông tin cá nhân</li>
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Statistics Section -->
            @if(is_admin())
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ $stats['total_products'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Tổng sản phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ $stats['total_orders'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Tổng đơn hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning">{{ $stats['total_users'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Tổng người dùng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info">{{ $stats['total_categories'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Danh mục</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- User Info Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle"></i> Thông tin của bạn
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Điện thoại:</strong> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Vai trò:</strong> 
                                @if(Auth::user()->role)
                                    <span class="badge bg-primary">{{ Auth::user()->role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">Không có vai trò</span>
                                @endif
                            </p>
                            <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>
                            <p><strong>Trạng thái:</strong> 
                                @if(Auth::user()->status === 'active')
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Tạm khóa</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm" disabled title="Tính năng sắp ra mắt">
                            <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                        </button>
                        <button class="btn btn-secondary btn-sm" disabled title="Tính năng sắp ra mắt">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </button>
                        <a href="/" class="btn btn-success btn-sm">
                            <i class="fas fa-home"></i> Quay lại trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
