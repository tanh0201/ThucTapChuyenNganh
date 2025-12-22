@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 fw-bold mb-4">
                <i class="fas fa-cog text-primary me-2"></i>Cài Đặt Tài Khoản
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
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" role="tablist">
                        <button class="nav-link active text-start" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab">
                            <i class="fas fa-user me-2"></i>Hồ Sơ
                        </button>
                        <button class="nav-link text-start" id="password-tab" data-bs-toggle="pill" data-bs-target="#password" type="button" role="tab">
                            <i class="fas fa-lock me-2"></i>Đổi Mật Khẩu
                        </button>
                        <button class="nav-link text-start" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">
                            <i class="fas fa-shopping-bag me-2"></i>Đơn Hàng
                        </button>
                        <button class="nav-link text-start" id="delete-tab" data-bs-toggle="pill" data-bs-target="#delete" type="button" role="tab">
                            <i class="fas fa-trash me-2 text-danger"></i>Xóa Tài Khoản
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Thông Tin Hồ Sơ</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.updateProfile') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Họ Tên</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Số Điện Thoại</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Địa Chỉ</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu Thay Đổi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Tab -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Đổi Mật Khẩu</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.updatePassword') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-semibold">Mật Khẩu Hiện Tại</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Mật Khẩu Mới</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Xác Nhận Mật Khẩu Mới</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>

                                <div class="alert alert-info">
                                    <small><i class="fas fa-info-circle me-2"></i>Mật khẩu phải có ít nhất 6 ký tự</small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Đổi Mật Khẩu
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Lịch Sử Đơn Hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Xem tất cả đơn hàng của bạn</p>
                            <a href="{{ route('checkout.myOrders') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>Xem Đơn Hàng Của Tôi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Delete Account Tab -->
                <div class="tab-pane fade" id="delete" role="tabpanel">
                    <div class="card shadow-sm border-0 border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Xóa Tài Khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Cảnh báo:</strong> Hành động này không thể được hoàn tác. Tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.
                            </div>

                            <form action="{{ route('settings.deleteAccount') }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này? Hành động này không thể hoàn tác!');">
                                @csrf

                                <div class="mb-3">
                                    <label for="delete_password" class="form-label fw-semibold">Nhập Mật Khẩu Để Xác Nhận</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="delete_password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input @error('confirm') is-invalid @enderror" 
                                           id="confirmDelete" name="confirm" value="yes" required>
                                    <label class="form-check-label" for="confirmDelete">
                                        Tôi hiểu rằng tài khoản của tôi sẽ bị xóa vĩnh viễn
                                    </label>
                                    @error('confirm')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Xóa Tài Khoản Của Tôi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
