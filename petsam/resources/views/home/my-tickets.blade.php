@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>
                    <i class="fas fa-list"></i> Yêu Cầu Hỗ Trợ Của Tôi
                </h3>
                <a href="{{ route('customer-care.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tạo Yêu Cầu Mới
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($tickets && $tickets->count() > 0)
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tiêu Đề</th>
                                    <th>Trạng Thái</th>
                                    <th>Ngày Gửi</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td class="fw-bold text-primary">#{{ $ticket->id }}</td>
                                        <td>
                                            <strong>{{ $ticket->subject }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($ticket->message, 60) }}</small>
                                        </td>
                                        <td>
                                            @switch($ticket->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-hourglass-start"></i> Chờ Xử Lý
                                                    </span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info">
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
                                            <small>{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('customer-care.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-2 d-block opacity-50"></i>
                                            Bạn chưa có yêu cầu nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $tickets->links('pagination::bootstrap-5') }}
            @else
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-inbox fa-5x text-muted mb-3 d-block opacity-50"></i>
                        <h5 class="text-muted">Bạn chưa có yêu cầu nào</h5>
                        <p class="text-muted mb-3">Hãy tạo yêu cầu mới để chúng tôi hỗ trợ bạn</p>
                        <a href="{{ route('customer-care.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tạo Yêu Cầu Mới
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
