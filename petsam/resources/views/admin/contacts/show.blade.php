@extends('admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-envelope-open text-primary me-2"></i>Chi Tiết Liên Hệ
            </h1>
            <p class="text-muted small mt-1">ID: {{ $contact->id }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay Lại
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Status Badge -->
                    <div class="mb-4">
                        @if ($contact->status === 'new')
                            <span class="badge bg-warning fs-6">Chưa Đọc</span>
                        @elseif ($contact->status === 'read')
                            <span class="badge bg-info fs-6">Đã Đọc</span>
                        @else
                            <span class="badge bg-success fs-6">Đã Phản Hồi</span>
                        @endif
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted text-uppercase mb-1">
                                <i class="fas fa-user text-primary me-2"></i>Tên
                            </label>
                            <p class="h6 mb-0">{{ $contact->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted text-uppercase mb-1">
                                <i class="fas fa-envelope text-primary me-2"></i>Email
                            </label>
                            <p class="h6 mb-0">
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </p>
                        </div>
                        @if ($contact->phone)
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold text-muted text-uppercase mb-1">
                                    <i class="fas fa-phone text-primary me-2"></i>Số Điện Thoại
                                </label>
                                <p class="h6 mb-0">{{ $contact->phone }}</p>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted text-uppercase mb-1">
                                <i class="fas fa-calendar text-primary me-2"></i>Ngày Gửi
                            </label>
                            <p class="h6 mb-0">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4 pb-4 border-bottom">
                        <label class="small fw-bold text-muted text-uppercase mb-2 d-block">
                            <i class="fas fa-heading text-primary me-2"></i>Tiêu Đề
                        </label>
                        <h5 class="mb-0">{{ $contact->subject }}</h5>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="small fw-bold text-muted text-uppercase mb-2 d-block">
                            <i class="fas fa-comment text-primary me-2"></i>Nội Dung Tin Nhắn
                        </label>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0 text-break">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks text-primary me-2"></i>Hành Động
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Mark as Responded Button -->
                    @if ($contact->status !== 'responded')
                        <form action="{{ route('contacts.mark-responded', $contact->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Đánh Dấu Đã Phản Hồi
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success mb-2" role="alert">
                            <i class="fas fa-check-circle me-2"></i>Đã phản hồi
                        </div>
                    @endif

                    <!-- Delete Button -->
                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Thông Tin
                    </h6>
                </div>
                <div class="card-body small">
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="fw-bold text-muted mb-1 d-block">Trạng Thái</label>
                        @if ($contact->status === 'new')
                            <span class="badge bg-warning">Chưa Đọc</span>
                        @elseif ($contact->status === 'read')
                            <span class="badge bg-info">Đã Đọc</span>
                        @else
                            <span class="badge bg-success">Đã Phản Hồi</span>
                        @endif
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="fw-bold text-muted mb-1 d-block">Ngày Tạo</label>
                        <p class="mb-0">{{ $contact->created_at->format('d/m/Y') }}</p>
                        <small class="text-muted">{{ $contact->created_at->format('H:i') }}</small>
                    </div>
                    <div>
                        <label class="fw-bold text-muted mb-1 d-block">Lần Cập Nhật Cuối</label>
                        <p class="mb-0">{{ $contact->updated_at->format('d/m/Y') }}</p>
                        <small class="text-muted">{{ $contact->updated_at->format('H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
