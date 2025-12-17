@extends('admin.layout.app')

@section('title', 'Chi Tiết Yêu Cầu Hỗ Trợ - PetSam Admin')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-headset text-info me-2"></i> Chi Tiết Yêu Cầu Hỗ Trợ
        </h2>
        <small class="text-muted">Quản lý và xử lý yêu cầu</small>
    </div>
    <a href="{{ route('admin.customer-care.index') }}" class="btn btn-secondary btn-sm">
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
        <!-- Ticket Detail Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-info-circle me-2 text-primary"></i> Thông Tin Yêu Cầu
                </h6>
            </div>
            <div class="card-body">
                <!-- Customer Info -->
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Khách Hàng</label>
                        @if ($ticket->user)
                            <p class="mb-0">
                                <strong class="text-dark">{{ $ticket->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $ticket->user->email }}</small>
                                @if ($ticket->user->phone)
                                    <br>
                                    <small class="text-muted">{{ $ticket->user->phone }}</small>
                                @endif
                            </p>
                        @else
                            <p class="mb-0">
                                <strong class="text-dark">{{ $ticket->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $ticket->email }}</small>
                                @if ($ticket->phone)
                                    <br>
                                    <small class="text-muted">{{ $ticket->phone }}</small>
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Chủ Đề</label>
                        <p class="mb-0 text-dark">{{ $ticket->subject }}</p>
                    </div>
                </div>

                <!-- Status and Date -->
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Trạng Thái</label>
                        <div>
                            @switch($ticket->status)
                                @case('pending')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i> Chờ Xử Lý
                                    </span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-spinner me-1"></i> Đang Xử Lý
                                    </span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Đã Giải Quyết
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Ngày Yêu Cầu</label>
                        <p class="mb-0 text-dark">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Nội Dung Yêu Cầu</label>
                    <div class="bg-light p-3 rounded text-dark" style="min-height: 120px;">
                        {{ $ticket->message }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-reply me-2 text-primary"></i> Phản Hồi
                </h6>
            </div>
            <div class="card-body">
                @if ($ticket->response)
                    <div class="bg-light p-3 rounded mb-3 border-left border-success" style="border-left: 4px solid;">
                        <small class="text-muted d-block mb-2">
                            <i class="fas fa-user-tie me-1"></i> {{ $ticket->respondedBy->name ?? 'Admin' }} 
                            - {{ $ticket->responded_at?->format('d/m/Y H:i') }}
                        </small>
                        <p class="mb-0 text-dark">{{ $ticket->response }}</p>
                    </div>
                    <hr>
                @else
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-1"></i> Chưa có phản hồi
                    </div>
                @endif

                <form action="{{ route('admin.customer-care.update', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Cập Nhật Trạng Thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Chờ Xử Lý</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Đang Xử Lý</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Đã Giải Quyết</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="response" class="form-label fw-bold">Phản Hồi</label>
                        <textarea name="response" id="response" class="form-control" rows="6" 
                                  placeholder="Nhập phản hồi cho khách hàng...">{{ $ticket->response }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật
                        </button>
                        <a href="{{ route('admin.customer-care.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-bolt me-2 text-primary"></i> Hành Động Nhanh
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customer-care.update', $ticket->id) }}" method="POST" class="mb-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-spinner me-1"></i> Bắt Đầu Xử Lý
                    </button>
                </form>

                <form action="{{ route('admin.customer-care.update', $ticket->id) }}" method="POST" class="mb-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="resolved">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check-circle me-1"></i> Đánh Dấu Đã Giải Quyết
                    </button>
                </form>

                <form action="{{ route('admin.customer-care.destroy', $ticket->id) }}" method="POST" 
                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                </form>
            </div>
        </div>

        <!-- Ticket Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-file-alt me-2 text-primary"></i> Thông Tin Ticket
                </h6>
            </div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="fw-bold small text-muted">ID Ticket</dt>
                    <dd class="mb-3">
                        <span class="badge bg-primary">{{ $ticket->id }}</span>
                    </dd>

                    <dt class="fw-bold small text-muted">Ngày Tạo</dt>
                    <dd class="mb-3">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="fw-bold small text-muted">Lần Cập Nhật</dt>
                    <dd class="mb-3">{{ $ticket->updated_at->format('d/m/Y H:i') }}</dd>

                    @if ($ticket->responded_at)
                        <dt class="fw-bold small text-muted">Phản Hồi Vào</dt>
                        <dd class="mb-3">{{ $ticket->responded_at->format('d/m/Y H:i') }}</dd>
                    @endif

                    @if ($ticket->respondedBy)
                        <dt class="fw-bold small text-muted">Người Xử Lý</dt>
                        <dd class="mb-3">
                            <span class="badge bg-info">{{ $ticket->respondedBy->name }}</span>
                        </dd>
                    @endif

                    <dt class="fw-bold small text-muted">Số Ký Tự</dt>
                    <dd class="mb-0">
                        <span class="text-muted">{{ strlen($ticket->message) }} ký tự</span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
