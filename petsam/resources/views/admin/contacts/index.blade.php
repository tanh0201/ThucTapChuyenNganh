@extends('admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-envelope text-primary me-2"></i>Quản Lý Liên Hệ
            </h1>
            <p class="text-muted small mt-1">Quản lý tất cả tin nhắn liên hệ từ khách hàng</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-primary text-uppercase mb-1 small fw-bold">Tổng Liên Hệ</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-warning text-uppercase mb-1 small fw-bold">Chưa Đọc</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['new'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-info text-uppercase mb-1 small fw-bold">Đã Đọc</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['read'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-success text-uppercase mb-1 small fw-bold">Đã Phản Hồi</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['responded'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-6">
                    <label for="search" class="form-label small fw-semibold">Tìm Kiếm</label>
                    <input 
                        type="text" 
                        class="form-control form-control-sm" 
                        id="search" 
                        name="search" 
                        placeholder="Tìm theo tên, email, tiêu đề..."
                        value="{{ request('search') }}"
                    >
                </div>

                <!-- Status Filter -->
                <div class="col-md-4">
                    <label for="status" class="form-label small fw-semibold">Trạng Thái</label>
                    <select class="form-select form-select-sm" id="status" name="status">
                        <option value="">-- Tất Cả --</option>
                        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Chưa Đọc</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Đã Đọc</option>
                        <option value="responded" {{ request('status') === 'responded' ? 'selected' : '' }}>Đã Phản Hồi</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-2"></i>Tìm Kiếm
                    </button>
                </div>

                <!-- Reset Button -->
                <div class="col-md-2">
                    @if (request('search') || request('status'))
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-redo me-2"></i>Đặt Lại
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card shadow-sm">
        @if ($contacts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="small fw-bold">ID</th>
                            <th class="small fw-bold">Tên</th>
                            <th class="small fw-bold">Email</th>
                            <th class="small fw-bold">Tiêu Đề</th>
                            <th class="small fw-bold">Trạng Thái</th>
                            <th class="small fw-bold">Ngày Gửi</th>
                            <th class="small fw-bold text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td class="small">{{ $contact->id }}</td>
                                <td class="small">{{ $contact->name }}</td>
                                <td class="small">
                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                        {{ $contact->email }}
                                    </a>
                                </td>
                                <td class="small">
                                    <span title="{{ $contact->subject }}">
                                        {{ Str::limit($contact->subject, 30) }}
                                    </span>
                                </td>
                                <td class="small">
                                    @if ($contact->status === 'new')
                                        <span class="badge bg-warning">Chưa Đọc</span>
                                    @elseif ($contact->status === 'read')
                                        <span class="badge bg-info">Đã Đọc</span>
                                    @else
                                        <span class="badge bg-success">Đã Phản Hồi</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $contact->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="small text-center">
                                    <a 
                                        href="{{ route('admin.contacts.show', $contact->id) }}" 
                                        class="btn btn-sm btn-info text-white" 
                                        title="Xem Chi Tiết"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form 
                                        action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                        method="POST" 
                                        style="display:inline;"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($contacts->hasPages())
                <div class="card-footer bg-light">
                    {{ $contacts->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox text-muted fa-3x mb-3"></i>
                <p class="text-muted">Không có liên hệ nào</p>
            </div>
        @endif
    </div>
</div>
@endsection
