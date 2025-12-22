@extends('layout/app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại Danh Sách
            </a>

            <!-- Ticket Header -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="mb-2">{{ $customerCare->subject }}</h4>
                        <div class="d-flex gap-3 align-items-center">
                            <span class="badge bg-secondary">
                                <i class="fas fa-ticket-alt me-1"></i>Ticket #{{ $customerCare->id }}
                            </span>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>{{ $customerCare->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                    <div>
                        @switch($customerCare->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark py-2 px-3">
                                    <i class="fas fa-hourglass-start me-1"></i>Chờ Xử Lý
                                </span>
                                @break
                            @case('in_progress')
                                <span class="badge bg-info py-2 px-3">
                                    <i class="fas fa-spinner me-1"></i>Đang Xử Lý
                                </span>
                                @break
                            @case('resolved')
                                <span class="badge bg-success py-2 px-3">
                                    <i class="fas fa-check-circle me-1"></i>Đã Giải Quyết
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div>
                                <h6 class="text-muted fw-bold text-uppercase">Tên Liên Hệ</h6>
                                <p class="mb-3 h5">{{ $customerCare->name }}</p>
                            </div>
                            <div>
                                <h6 class="text-muted fw-bold text-uppercase">Email</h6>
                                <p class="mb-0">
                                    <a href="mailto:{{ $customerCare->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope me-2"></i>{{ $customerCare->email }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($customerCare->phone)
                                <div>
                                    <h6 class="text-muted fw-bold text-uppercase">Số Điện Thoại</h6>
                                    <p class="mb-3 h5">
                                        <a href="tel:{{ $customerCare->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-2"></i>{{ $customerCare->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            <div>
                                <h6 class="text-muted fw-bold text-uppercase">Trạng Thái</h6>
                                <p class="mb-0">
                                    @switch($customerCare->status)
                                        @case('pending')
                                            <span class="text-warning fw-bold">Chờ xử lý từ đội ngũ hỗ trợ</span>
                                            @break
                                        @case('in_progress')
                                            <span class="text-info fw-bold">Đội ngũ đang tìm hiểu vấn đề của bạn</span>
                                            @break
                                        @case('resolved')
                                            <span class="text-success fw-bold">Đã được giải quyết</span>
                                            @break
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Message Content -->
                    <div>
                        <h6 class="text-muted fw-bold text-uppercase mb-3">Nội Dung Yêu Cầu</h6>
                        <div class="bg-light p-4 rounded border-start border-5 border-primary">
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $customerCare->message }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Section -->
            @if ($customerCare->response)
                <div class="card border-success shadow-sm border-0">
                    <div class="card-header bg-success bg-opacity-10 border-bottom border-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-success">
                                <i class="fas fa-reply me-2"></i>Phản Hồi Từ Đội Hỗ Trợ
                            </h6>
                            <small class="text-muted">
                                {{ $customerCare->responded_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-4 rounded">
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $customerCare->response }}</p>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <strong>Người Phản Hồi:</strong> {{ $customerCare->responder->name ?? 'Admin' }}
                                <br>
                                <strong>Thời Gian:</strong> {{ $customerCare->responded_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info border-0 bg-info bg-opacity-10">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <strong>Thông Tin:</strong> Đội ngũ hỗ trợ của chúng tôi sẽ sớm xem xét và phản hồi yêu cầu của bạn.
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>Quay Lại Danh Sách
                </a>
                <form action="{{ route('customer-care.destroy', $customerCare->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa yêu cầu này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash me-2"></i>Xóa Yêu Cầu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
