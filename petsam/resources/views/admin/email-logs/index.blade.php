@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Email Logs')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Email Logs</li>
</ol>
@endsection

@section('content')
<div class="container-fluid"
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">📧 Quản Lý Email Logs</h2>
            <small class="text-muted">Theo dõi tất cả emails được gửi</small>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.email-logs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" class="form-control" placeholder="Email, chủ đề..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="sending" {{ request('status') === 'sending' ? 'selected' : '' }}>Đang gửi</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Đã gửi</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Loại Email</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="OrderConfirmationMail" {{ request('type') === 'OrderConfirmationMail' ? 'selected' : '' }}>
                            Xác nhận đơn hàng
                        </option>
                        <option value="OrderStatusUpdatedMail" {{ request('type') === 'OrderStatusUpdatedMail' ? 'selected' : '' }}>
                            Cập nhật trạng thái
                        </option>
                        <option value="NewOrderNotificationMail" {{ request('type') === 'NewOrderNotificationMail' ? 'selected' : '' }}>
                            Thông báo đơn mới
                        </option>
                        <option value="NewCustomerCareMail" {{ request('type') === 'NewCustomerCareMail' ? 'selected' : '' }}>
                            Hỗ trợ khách hàng
                        </option>
                        <option value="NewContactMail" {{ request('type') === 'NewContactMail' ? 'selected' : '' }}>
                            Liên hệ mới
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary grow">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                    <a href="{{ route('admin.email-logs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Logs Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Email</th>
                        <th>Chủ Đề</th>
                        <th>Loại</th>
                        <th style="width: 120px">Trạng Thái</th>
                        <th>Thời Gian</th>
                        <th style="width: 100px">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emailLogs as $log)
                    <tr>
                        <td><code>{{ $log->id }}</code></td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                  title="{{ $log->to_email }}">
                                {{ $log->to_email }}
                            </span>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 250px;" 
                                  title="{{ $log->subject }}">
                                {{ $log->subject }}
                            </span>
                        </td>
                        <td>
                            <small class="badge bg-info text-dark">{{ class_basename($log->mailable_class) }}</small>
                        </td>
                        <td>
                            @if($log->status === 'sent')
                                <span class="badge bg-success">✓ Đã gửi</span>
                            @elseif($log->status === 'failed')
                                <span class="badge bg-danger">✗ Thất bại</span>
                            @else
                                <span class="badge bg-warning text-dark">⏳ Đang gửi</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="modal" data-bs-target="#emailModal{{ $log->id }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <!-- Email Preview Modal -->
                            <div class="modal fade" id="emailModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-envelope"></i> {{ $log->subject }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-light p-3 mb-3">
                                                <p class="mb-2">
                                                    <strong>Đến:</strong> {{ $log->to_email }}<br>
                                                    <strong>Loại:</strong> {{ class_basename($log->mailable_class) }}<br>
                                                    <strong>Thời gian:</strong> {{ $log->created_at->format('d/m/Y H:i:s') }}
                                                </p>
                                                @if($log->status === 'failed')
                                                    <div class="alert alert-danger p-2 mb-0">
                                                        <strong>Lỗi:</strong> {{ $log->error_message }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if($log->body)
                                                <div style="border: 1px solid #ddd; border-radius: 4px; padding: 15px; background-color: #f9f9f9; max-height: 400px; overflow-y: auto;">
                                                    {!! $log->body !!}
                                                </div>
                                            @else
                                                <div class="alert alert-warning">Không có nội dung email</div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Đóng
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.5;"></i>
                                <p class="mt-2">Chưa có email logs</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($emailLogs->hasPages())
        <div class="card-footer bg-light">
            {{ $emailLogs->links() }}
        </div>
        @endif
    </div>

    <!-- Statistics Card -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Tổng Email</h5>
                    <h2 class="text-primary">{{ $emailLogs->total() ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Đã Gửi</h5>
                    <h2 class="text-success">{{ $stats['sent'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Thất Bại</h5>
                    <h2 class="text-danger">{{ $stats['failed'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Đang Gửi</h5>
                    <h2 class="text-warning">{{ $stats['sending'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

code {
    background-color: #f5f5f5;
    padding: 2px 6px;
    border-radius: 3px;
}
</style>
@endsection
