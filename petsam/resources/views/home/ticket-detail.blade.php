@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $customerCare->subject }}</h5>
                            <small class="text-muted">
                                <i class="fas fa-ticket-alt"></i> Ticket #{{ $customerCare->id }}
                            </small>
                        </div>
                        <div>
                            @switch($customerCare->status)
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
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Tên:</strong> {{ $customerCare->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong> 
                                <a href="mailto:{{ $customerCare->email }}">{{ $customerCare->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if ($customerCare->phone)
                                <p class="mb-2">
                                    <strong>Số Điện Thoại:</strong> {{ $customerCare->phone }}
                                </p>
                            @endif
                            <p class="mb-2">
                                <strong>Ngày Gửi:</strong> {{ $customerCare->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4">
                        <h6 class="mb-2">Nội Dung Yêu Cầu:</h6>
                        <div class="bg-light p-3 rounded border-start border-primary">
                            {{ $customerCare->message }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response -->
            @if ($customerCare->response)
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-reply"></i> Phản Hồi Từ Admin
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded">
                            {{ nl2br($customerCare->response) }}
                        </div>
                        <small class="text-muted d-block mt-2">
                            <strong>Người Phản Hồi:</strong> {{ $customerCare->responder->name ?? 'Admin' }}
                            <br>
                            <strong>Thời Gian:</strong> {{ $customerCare->responded_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
