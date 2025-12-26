@extends('admin.layout.app')

@section('title', 'Chỉnh Sửa Đánh Giá - PetSam Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-edit me-2 text-primary"></i> Chỉnh Sửa Đánh Giá
        </h2>
        <small class="text-muted">Cập nhật thông tin đánh giá sản phẩm</small>
    </div>
    <a href="{{ route('admin.ratings.show', $rating->id) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Quay Lại
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-pencil me-2 text-primary"></i> Thông Tin Chỉnh Sửa
                </h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><strong>Lỗi!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Product & User Info (Read-only) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Khách Hàng</label>
                            <input type="text" class="form-control" value="{{ $rating->user->name ?? 'Ẩn danh' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sản Phẩm</label>
                            <input type="text" class="form-control" value="{{ $rating->product->name }}" disabled>
                        </div>
                    </div>

                    <!-- Star Rating -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Đánh Giá (Số Sao) <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="star{{ $i }}" name="rating" 
                                           value="{{ $i }}" {{ $rating->rating == $i ? 'checked' : '' }} required>
                                    <label class="form-check-label cursor-pointer" for="star{{ $i }}">
                                        @for ($j = 0; $j < $i; $j++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        @for ($j = $i; $j < 5; $j++)
                                            <i class="far fa-star text-muted"></i>
                                        @endfor
                                        <span class="ms-1">{{ $i }}</span>
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">Trạng Thái <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="approved" {{ $rating->status == 'approved' ? 'selected' : '' }}>Đã Hiển Thị</option>
                            <option value="rejected" {{ $rating->status == 'rejected' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <!-- Comment -->
                    <div class="mb-4">
                        <label for="comment" class="form-label fw-bold">Bình Luận</label>
                        <textarea name="comment" id="comment" class="form-control" rows="5" 
                                  placeholder="Nhập bình luận của khách hàng...">{{ $rating->comment }}</textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật
                        </button>
                        <a href="{{ route('admin.ratings.show', $rating->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-info-circle me-2 text-primary"></i> Thông Tin Đánh Giá
                </h6>
            </div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="fw-bold small text-muted">ID Đánh Giá</dt>
                    <dd class="mb-3">
                        <span class="badge bg-primary">{{ $rating->id }}</span>
                    </dd>

                    <dt class="fw-bold small text-muted">Ngày Tạo</dt>
                    <dd class="mb-3">{{ $rating->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="fw-bold small text-muted">Lần Cập Nhật Cuối</dt>
                    <dd class="mb-3">{{ $rating->updated_at->format('d/m/Y H:i') }}</dd>

                    <dt class="fw-bold small text-muted">Sản Phẩm</dt>
                    <dd class="mb-3">
                        <a href="{{ route('admin.products.show', $rating->product->id) }}" class="text-primary" target="_blank">
                            {{ $rating->product->name }}
                            <i class="fas fa-external-link-alt fa-xs"></i>
                        </a>
                    </dd>

                    @if ($rating->user)
                        <dt class="fw-bold small text-muted">Khách Hàng</dt>
                        <dd class="mb-3">
                            <a href="{{ route('admin.users.show', $rating->user->id) }}" class="text-primary" target="_blank">
                                {{ $rating->user->name }}
                                <i class="fas fa-external-link-alt fa-xs"></i>
                            </a>
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
                        @csrf
                        @method('PUT')

                        <!-- Rating -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đánh Giá <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                           {{ $rating->rating == $i ? 'checked' : '' }} required class="d-none">
                                    <label for="star{{ $i }}" class="star-label" style="font-size: 40px; cursor: pointer; color: #ccc;">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <span id="rating-value" class="fw-bold">{{ $rating->rating }}/5</span>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-3">
                            <label for="comment" class="form-label fw-bold">Bình Luận</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" 
                                      rows="5" placeholder="Nội dung bình luận...">{{ old('comment', $rating->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Chọn Trạng Thái --</option>
                                <option value="pending" {{ old('status', $rating->status) == 'pending' ? 'selected' : '' }}>Chờ Duyệt</option>
                                <option value="approved" {{ old('status', $rating->status) == 'approved' ? 'selected' : '' }}>Đã Duyệt</option>
                                <option value="rejected" {{ old('status', $rating->status) == 'rejected' ? 'selected' : '' }}>Từ Chối</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Info (Read-only) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sản Phẩm</label>
                            <div class="alert alert-light">
                                <strong>{{ $rating->product->name }}</strong>
                                <br>
                                <small class="text-muted">SKU: {{ $rating->product->id }}</small>
                            </div>
                        </div>

                        <!-- User Info (Read-only) -->
                        @if ($rating->user)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Khách Hàng</label>
                                <div class="alert alert-light">
                                    <strong>{{ $rating->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $rating->user->email }}</small>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu Thay Đổi
                            </button>
                            <a href="{{ route('admin.ratings.show', $rating->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .star-label {
        transition: all 0.3s;
    }
    
    input[type="radio"]:checked ~ label,
    .star-label:hover {
        color: #ffc107;
    }
</style>

<script>
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('rating-value').textContent = this.value + '/5';
        });
    });
</script>
@endsection
