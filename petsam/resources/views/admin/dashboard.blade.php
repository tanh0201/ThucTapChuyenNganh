@extends('admin.layout.base')

@section('title', 'Dashboard Quản Lý - PetSam Admin')

@section('breadcrumb')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light px-4 py-3 rounded-lg">
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-home text-primary"></i> Dashboard
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="h2 text-dark fw-bold mb-1">
                <i class="fas fa-tachometer-alt text-primary"></i> Dashboard Quản Lý
            </h1>
            <p class="text-muted mb-0">Chào mừng quay lại, tổng quan hệ thống của bạn</p>
        </div>
        <div class="text-end">
            <span class="badge bg-success px-3 py-2 fs-6">
                <i class="fas fa-clock me-2"></i> Cập nhật: {{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row g-4 mb-5">
        <!-- Total Products Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg h-100 stats-card" style="border-left: 4px solid #4e73df;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase fs-7 fw-bold mb-2">
                                <i class="fas fa-shopping-bag text-primary"></i> Tổng Sản Phẩm
                            </p>
                            <h2 class="text-dark fw-bold mb-0 display-5">{{ $totalProducts }}</h2>
                            <small class="text-muted">Tất cả sản phẩm trong hệ thống</small>
                        </div>
                        <div class="stats-icon" style="font-size: 2.5rem; color: #4e73df; opacity: 0.2;">
                            <i class="fas fa-cube"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg h-100 stats-card" style="border-left: 4px solid #1cc88a;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase fs-7 fw-bold mb-2">
                                <i class="fas fa-check-circle text-success"></i> Hoạt Động
                            </p>
                            <h2 class="text-dark fw-bold mb-0 display-5">{{ $activeProducts }}</h2>
                            <small class="text-success">{{ $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0 }}% tổng số</small>
                        </div>
                        <div class="stats-icon" style="font-size: 2.5rem; color: #1cc88a; opacity: 0.2;">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg h-100 stats-card" style="border-left: 4px solid #36b9cc;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase fs-7 fw-bold mb-2">
                                <i class="fas fa-folder text-info"></i> Danh Mục
                            </p>
                            <h2 class="text-dark fw-bold mb-0 display-5">{{ $totalCategories }}</h2>
                            <small class="text-muted">Danh mục sản phẩm</small>
                        </div>
                        <div class="stats-icon" style="font-size: 2.5rem; color: #36b9cc; opacity: 0.2;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg h-100 stats-card" style="border-left: 4px solid #f6c23e;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase fs-7 fw-bold mb-2">
                                <i class="fas fa-users text-warning"></i> Người Dùng
                            </p>
                            <h2 class="text-dark fw-bold mb-0 display-5">{{ $totalUsers }}</h2>
                            <small class="text-muted">Người dùng hệ thống</small>
                        </div>
                        <div class="stats-icon" style="font-size: 2.5rem; color: #f6c23e; opacity: 0.2;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-light border-0 py-3 px-4">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-lightning text-warning"></i> Thao Tác Nhanh
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 py-3 rounded-lg fw-bold">
                                <i class="fas fa-plus me-2"></i> Thêm Sản Phẩm
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-info w-100 py-3 rounded-lg fw-bold">
                                <i class="fas fa-folder-plus me-2"></i> Thêm Danh Mục
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-success w-100 py-3 rounded-lg fw-bold">
                                <i class="fas fa-list me-2"></i> Xem Sản Phẩm
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning w-100 py-3 rounded-lg fw-bold">
                                <i class="fas fa-user-tie me-2"></i> Quản Lý Người Dùng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products Section -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-light border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-star text-warning"></i> Sản Phẩm Mới Nhất
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Xem Tất Cả
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentProducts->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light border-bottom">
                                    <tr>
                                        <th class="px-4 py-3 text-dark fw-bold">STT</th>
                                        <th class="px-4 py-3 text-dark fw-bold">Tên Sản Phẩm</th>
                                        <th class="px-4 py-3 text-dark fw-bold">Danh Mục</th>
                                        <th class="px-4 py-3 text-dark fw-bold text-end">Giá</th>
                                        <th class="px-4 py-3 text-dark fw-bold text-center">Tồn Kho</th>
                                        <th class="px-4 py-3 text-dark fw-bold">Trạng Thái</th>
                                        <th class="px-4 py-3 text-dark fw-bold text-center">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $index => $product)
                                        <tr class="border-bottom hover-row">
                                            <td class="px-4 py-3">
                                                <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                    <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div>
                                                        <p class="mb-0 fw-bold text-dark">{{ Illuminate\Support\Str::limit($product->name, 30) }}</p>
                                                        @if($product->description)
                                                        <small class="text-muted">{{ Illuminate\Support\Str::limit($product->description, 40) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-info">{{ $product->category->name ?? 'Khác' }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <span class="fw-bold text-dark">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($product->status === 'active')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-circle text-white" style="font-size: 0.5rem;"></i> Hoạt Động
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-circle text-white" style="font-size: 0.5rem;"></i> Ẩn
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-outline-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block; opacity: 0.3;"></i>
                            <p class="text-muted fs-5">Chưa có sản phẩm nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Info Row -->
    <div class="row g-4 mt-3">
        <!-- System Information -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-light border-0 py-3 px-4">
                    <h6 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-info-circle text-primary"></i> Thông Tin Hệ Thống
                    </h6>
                </div>
                <div class="card-body px-4 py-3">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted fw-bold">Phiên Bản Ứng Dụng:</small>
                        <span class="badge bg-light text-dark">PetSam v1.0</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted fw-bold">Framework:</small>
                        <span class="badge bg-danger">Laravel {{ \Illuminate\Foundation\Application::VERSION }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted fw-bold">PHP Version:</small>
                        <span class="badge bg-primary">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted fw-bold">Database:</small>
                        <span class="badge bg-success">MySQL / PostgreSQL</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features List -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-light border-0 py-3 px-4">
                    <h6 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-tasks text-success"></i> Tính Năng Chính
                    </h6>
                </div>
                <div class="card-body px-4 py-3">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Quản lý sản phẩm:</strong> Thêm, sửa, xóa sản phẩm
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Quản lý danh mục:</strong> Tổ chức sản phẩm
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Quản lý người dùng:</strong> Phân quyền & vai trò
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Gợi ý AI:</strong> Sản phẩm được đề xuất thông minh
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stats-card {
        transition: all 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    .hover-row:hover {
        background-color: #f8f9fa;
    }
    .rounded-lg {
        border-radius: 0.75rem !important;
    }
</style>

@endsection
