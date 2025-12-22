@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>Email Logs
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Summary Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded text-center">
                                <h5 class="text-success mb-0">{{ $totalSent }}</h5>
                                <small class="text-muted">Gửi thành công</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded text-center">
                                <h5 class="text-warning mb-0">{{ $totalPending }}</h5>
                                <small class="text-muted">Chờ gửi</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded text-center">
                                <h5 class="text-danger mb-0">{{ $totalFailed }}</h5>
                                <small class="text-muted">Gửi thất bại</small>
                            </div>
                        </div>
                    </div>

                    <!-- Email Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Ngày gửi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($emailLogs as $log)
                                    <tr>
                                        <td>{{ $log->to_email }}</td>
                                        <td>{{ $log->subject }}</td>
                                        <td>
                                            @switch($log->status)
                                                @case('sent')
                                                    <span class="badge bg-success">Gửi thành công</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Chờ gửi</span>
                                                    @break
                                                @case('failed')
                                                    <span class="badge bg-danger">Gửi thất bại</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Chưa có email nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $emailLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
