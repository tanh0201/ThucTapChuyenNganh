@extends('layout/app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-list text-primary"></i> Yêu Cầu Hỗ Trợ Của Tôi
                    </h2>
                    <p class="text-muted mb-0">Quản lý và theo dõi tất cả yêu cầu hỗ trợ của bạn</p>
                </div>
                <a href="{{ route('customer-care.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tạo Yêu Cầu Mới
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($tickets && $tickets->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0 fw-bold">Danh Sách Yêu Cầu ({{ $tickets->total() }} yêu cầu)</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">Ticket</th>
                                    <th class="fw-bold">Tiêu Đề</th>
                                    <th class="fw-bold">Trạng Thái</th>
                                    <th class="fw-bold">Ngày Tạo</th>
                                    <th class="fw-bold text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr class="align-middle">
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="fas fa-ticket-alt me-1"></i>#{{ $ticket->id }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $ticket->subject }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($ticket->message, 50) }}</small>
                                        </td>
                                        <td>
                                            @switch($ticket->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-hourglass-start me-1"></i>Chờ Xử Lý
                                                    </span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-spinner me-1"></i>Đang Xử Lý
                                                    </span>
                                                    @break
                                                @case('resolved')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Đã Giải Quyết
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i>{{ $ticket->created_at->format('d/m/Y') }}
                                                <br>
                                                <i class="far fa-clock"></i> {{ $ticket->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('customer-care.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                <i class="fas fa-eye me-1"></i>Xem
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block opacity-50"></i>
                                            <strong class="d-block text-muted mb-2">Bạn chưa có yêu cầu nào</strong>
                                            <p class="text-muted mb-3">Hãy tạo yêu cầu mới để chúng tôi có thể hỗ trợ bạn</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $tickets->links('pagination::bootstrap-5') }}
            @else
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-inbox fa-5x text-muted mb-3 d-block opacity-50"></i>
                        <h5 class="text-muted fw-bold mb-2">Bạn chưa có yêu cầu nào</h5>
                        <p class="text-muted mb-4">Hãy tạo yêu cầu mới để chúng tôi có thể hỗ trợ bạn</p>
                        <a href="{{ route('customer-care.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Tạo Yêu Cầu Đầu Tiên
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
