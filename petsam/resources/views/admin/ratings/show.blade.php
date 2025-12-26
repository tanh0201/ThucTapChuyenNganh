@extends('admin.layout.app')

@section('title', 'Chi Tiết Đánh Giá - PetSam Admin')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-star text-warning me-2"></i> Chi Tiết Đánh Giá Sản Phẩm
        </h2>
        <small class="text-muted">Xem và quản lý đánh giá</small>
    </div>
    <a href="{{ route('admin.ratings.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Quay Lại
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Rating Detail Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-info-circle me-2 text-primary"></i> Thông Tin Đánh Giá
                </h6>
            </div>
            <div class="card-body">
                <!-- Customer Info -->
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Khách Hàng</label>
                        @if ($rating->user)
                            <p class="mb-0">
                                <strong class="text-dark">{{ $rating->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $rating->user->email }}</small>
                                @if ($rating->user->phone)
                                    <br>
                                    <small class="text-muted">{{ $rating->user->phone }}</small>
                                @endif
                            </p>
                        @else
                            <p class="mb-0 text-muted"><em>Khách ẩn danh</em></p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Sản Phẩm</label>
                        <p class="mb-0">
                            <strong class="text-dark">
                                <a href="{{ route('admin.products.show', $rating->product->id) }}" target="_blank" class="text-primary">
                                    {{ $rating->product->name }}
                                </a>
                            </strong>
                            @if ($rating->product->category)
                                <br>
                                <small class="text-muted">{{ $rating->product->category->name }}</small>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Rating Info -->
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Đánh Giá</label>
                        <div>
                            @for ($i = 0; $i < $rating->rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                            @for ($i = $rating->rating; $i < 5; $i++)
                                <i class="far fa-star text-warning"></i>
                            @endfor
                            <span class="ms-2 fw-bold text-dark">{{ $rating->rating }}/5</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Ngày Đánh Giá</label>
                        <p class="mb-0 text-dark">{{ $rating->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3 pb-3 border-bottom">
                    <label class="form-label fw-bold small text-muted">Trạng Thái</label>
                    <div>
                        @switch($rating->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-hourglass-start me-1"></i> Chờ Duyệt
                                </span>
                                @break
                            @case('approved')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Đã Duyệt
                                </span>
                                @break
                            @case('rejected')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i> Từ Chối
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Comment -->
                <div>
                    <label class="form-label fw-bold small text-muted">Bình Luận</label>
                    @if ($rating->comment)
                        <div class="bg-light p-3 rounded text-dark">
                            {{ $rating->comment }}
                        </div>
                    @else
                        <p class="text-muted mb-0"><em>Không có bình luận</em></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-edit me-2 text-primary"></i> Chỉnh Sửa
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Trạng Thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="approved" {{ $rating->status == 'approved' ? 'selected' : '' }}>Đã Hiển Thị</option>
                            <option value="rejected" {{ $rating->status == 'rejected' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label fw-bold">Bình Luận</label>
                        <textarea name="comment" id="comment" class="form-control" rows="5">{{ $rating->comment }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật
                        </button>
                        <a href="{{ route('admin.ratings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-bolt me-2 text-primary"></i> Hành Động Nhanh
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST" class="mb-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="rating" value="{{ $rating->rating }}">
                    <input type="hidden" name="comment" value="{{ $rating->comment }}">
                    <select name="status" class="form-select form-select-sm mb-2">
                        <option value="approved" {{ $rating->status == 'approved' ? 'selected' : '' }}>Đã Hiển Thị</option>
                        <option value="rejected" {{ $rating->status == 'rejected' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Cập Nhật
                    </button>
                </form>

                <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" 
                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Info -->
        @if ($rating->product)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-box me-2 text-primary"></i> Thông Tin Sản Phẩm
                    </h6>
                </div>
                <div class="card-body">
                    @if ($rating->product->image)
                        <img src="{{ asset('storage/' . $rating->product->image) }}" alt="{{ $rating->product->name }}" 
                             class="img-fluid rounded mb-3">
                    @endif
                    <p class="fw-bold text-dark mb-2">{{ $rating->product->name }}</p>
                    <p class="text-primary fw-bold mb-3">
                        {{ number_format($rating->product->price, 0, ',', '.') }} ₫
                    </p>
                    <a href="{{ route('admin.products.show', $rating->product->id) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-eye me-1"></i> Xem Sản Phẩm
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
