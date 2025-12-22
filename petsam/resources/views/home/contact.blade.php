@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-5 text-center">
                <h1 class="h2 fw-bold mb-2">Liên Hệ Với Chúng Tôi</h1>
                <p class="text-muted">Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn. Hãy gửi tin nhắn cho chúng tôi ngay hôm nay!</p>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Có lỗi xảy ra!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Contact Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('contact.store') }}" method="POST" novalidate>
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user text-primary me-2"></i>Họ Tên
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                placeholder="Nhập họ tên của bạn"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope text-primary me-2"></i>Email
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="your.email@example.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Field (Optional) -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="fas fa-phone text-primary me-2"></i>Số Điện Thoại
                                <span class="text-muted">(Tùy chọn)</span>
                            </label>
                            <input 
                                type="tel" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" 
                                name="phone" 
                                placeholder="0123 456 789"
                                value="{{ old('phone') }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">
                                <i class="fas fa-heading text-primary me-2"></i>Tiêu Đề
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('subject') is-invalid @enderror" 
                                id="subject" 
                                name="subject" 
                                placeholder="Chủ đề của tin nhắn"
                                value="{{ old('subject') }}"
                                required
                            >
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">
                                <i class="fas fa-comment text-primary me-2"></i>Nội Dung
                                <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="6" 
                                placeholder="Vui lòng nhập nội dung tin nhắn của bạn..."
                                required
                            >{{ old('message') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>Tối thiểu 10 ký tự
                            </small>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button 
                                type="submit" 
                                class="btn btn-primary btn-lg fw-semibold"
                            >
                                <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted mb-0">
                                <small>
                                    Chúng tôi sẽ phản hồi trong vòng 24 giờ làm việc
                                    <i class="fas fa-clock text-warning ms-1"></i>
                                </small>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="row mt-5 pt-3 border-top">
                <div class="col-md-4 mb-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-map-marker-alt text-primary fa-lg"></i>
                        </div>
                        <h5 class="mt-3 fw-semibold">Địa Chỉ</h5>
                        <p class="text-muted small">123 Đường ABC, TP. HCM</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-phone text-primary fa-lg"></i>
                        </div>
                        <h5 class="mt-3 fw-semibold">Điện Thoại</h5>
                        <p class="text-muted small">+84 123 456 789</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-envelope text-primary fa-lg"></i>
                        </div>
                        <h5 class="mt-3 fw-semibold">Email</h5>
                        <p class="text-muted small">info@petsam.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
