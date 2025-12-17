@extends('admin.layout.app')

@section('title', 'Quản Lý Đánh Giá - PetSam Admin')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-star text-warning me-2"></i> Quản Lý Đánh Giá Sản Phẩm
        </h2>
        <small class="text-muted">Duyệt và quản lý đánh giá từ khách hàng</small>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Tổng Đánh Giá</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                    <i class="fas fa-star fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Chờ Duyệt</h6>
                        <h3 class="mb-0 text-warning fw-bold">{{ $stats['pending'] }}</h3>
                    </div>
                    <i class="fas fa-hourglass-start fa-2x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Đã Duyệt</h6>
                        <h3 class="mb-0 text-success fw-bold">{{ $stats['approved'] }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Từ Chối</h6>
                        <h3 class="mb-0 text-danger fw-bold">{{ $stats['rejected'] }}</h3>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fas fa-filter me-2 text-primary"></i> Bộ Lọc Tìm Kiếm
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.ratings.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold small">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tên, email, bình luận..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold small">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất Cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ Duyệt</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã Duyệt</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ Chối</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold small">Số sao</label>
                <select name="rating" class="form-select">
                    <option value="">Tất Cả</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ 2</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ 1</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold small">Sắp xếp</label>
                <select name="sort" class="form-select">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới Nhất</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ Nhất</option>
                    <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Sao Cao</option>
                    <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Sao Thấp</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Tìm Kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Ratings Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fas fa-table me-2 text-primary"></i> Danh Sách Đánh Giá
        </h6>
    </div>
    @if ($ratings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 20%">Khách Hàng</th>
                        <th style="width: 20%">Sản Phẩm</th>
                        <th style="width: 10%">Đánh Giá</th>
                        <th style="width: 15%">Trạng Thái</th>
                        <th style="width: 15%">Ngày Tạo</th>
                        <th style="width: 15%">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                        <tr class="align-middle">
                            <td>
                                <span class="badge bg-primary">{{ $rating->id }}</span>
                            </td>
                            <td>
                                @if ($rating->user)
                                    <div class="fw-bold text-dark">{{ $rating->user->name }}</div>
                                    <small class="text-muted">{{ $rating->user->email }}</small>
                                @else
                                    <span class="text-muted"><em>Ẩn danh</em></span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $rating->product->id) }}" class="text-primary fw-bold" target="_blank">
                                    {{ Str::limit($rating->product->name, 30) }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    @for ($i = 0; $i < $rating->rating; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    @for ($i = $rating->rating; $i < 5; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                @switch($rating->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-hourglass-start"></i> Chờ Duyệt
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Đã Duyệt
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Từ Chối
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <small class="text-muted">{{ $rating->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.ratings.show', $rating->id) }}" class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light border-top">
            {{ $ratings->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card-body text-center py-5">
            <i class="fas fa-star fa-5x text-muted opacity-50 mb-3 d-block"></i>
            <p class="text-muted fw-bold">Không có đánh giá nào</p>
        </div>
    @endif
</div>
@endsection
