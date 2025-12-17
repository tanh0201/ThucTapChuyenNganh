@extends('admin.layout.app')

@section('title', 'Quản Lý Hỗ Trợ Khách Hàng - PetSam Admin')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-headset text-info me-2"></i> Quản Lý Hỗ Trợ Khách Hàng
        </h2>
        <small class="text-muted">Quản lý và trả lời các yêu cầu hỗ trợ từ khách hàng</small>
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
                        <h6 class="text-muted mb-1">Tổng Yêu Cầu</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                    <i class="fas fa-envelope fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Chờ Xử Lý</h6>
                        <h3 class="mb-0 text-danger fw-bold">{{ $stats['pending'] }}</h3>
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Đang Xử Lý</h6>
                        <h3 class="mb-0 text-warning fw-bold">{{ $stats['in_progress'] }}</h3>
                    </div>
                    <i class="fas fa-spinner fa-2x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100 border-left border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Đã Giải Quyết</h6>
                        <h3 class="mb-0 text-success fw-bold">{{ $stats['resolved'] }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
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
        <form method="GET" action="{{ route('admin.customer-care.index') }}" class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tên, email, chủ đề..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất Cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ Xử Lý</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang Xử Lý</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Đã Giải Quyết</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Tìm Kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fas fa-table me-2 text-primary"></i> Danh Sách Yêu Cầu Hỗ Trợ
        </h6>
    </div>
    @if ($tickets->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 20%">Khách Hàng</th>
                        <th style="width: 25%">Chủ Đề</th>
                        <th style="width: 15%">Trạng Thái</th>
                        <th style="width: 15%">Ngày Tạo</th>
                        <th style="width: 15%">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="align-middle">
                            <td>
                                <span class="badge bg-primary">{{ $ticket->id }}</span>
                            </td>
                            <td>
                                @if ($ticket->user)
                                    <div class="fw-bold text-dark">{{ $ticket->user->name }}</div>
                                    <small class="text-muted">{{ $ticket->user->email }}</small>
                                @else
                                    <div class="fw-bold text-dark">{{ $ticket->name }}</div>
                                    <small class="text-muted">{{ $ticket->email }}</small>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark">{{ Str::limit($ticket->subject, 40) }}</strong>
                            </td>
                            <td>
                                @switch($ticket->status)
                                    @case('pending')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-exclamation-circle"></i> Chờ Xử Lý
                                        </span>
                                        @break
                                    @case('in_progress')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-spinner"></i> Đang Xử Lý
                                        </span>
                                        @break
                                    @case('resolved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Đã Giải Quyết
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <small class="text-muted">{{ $ticket->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.customer-care.show', $ticket->id) }}" class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.customer-care.destroy', $ticket->id) }}" method="POST" class="d-inline" 
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
            {{ $tickets->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-5x text-muted opacity-50 mb-3 d-block"></i>
            <p class="text-muted fw-bold">Không có yêu cầu hỗ trợ nào</p>
        </div>
    @endif
</div>
@endsection
