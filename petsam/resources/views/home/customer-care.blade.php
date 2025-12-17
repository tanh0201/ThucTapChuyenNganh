@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-headset"></i> Chăm Sóc Khách Hàng
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Lỗi!</strong>
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
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Bạn có bất kỳ câu hỏi hoặc vấn đề nào? Vui lòng điền vào mẫu bên dưới và chúng tôi sẽ sớm liên hệ với bạn.
                    </p>

                    <form action="{{ route('customer-care.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên của bạn <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                   value="{{ Auth::check() ? Auth::user()->name : old('name') }}" placeholder="Nhập tên của bạn" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                   value="{{ Auth::check() ? Auth::user()->email : old('email') }}" placeholder="Nhập email của bạn" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                                   value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}" placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" 
                                   value="{{ old('subject') }}" placeholder="Vd: Vấn đề về sản phẩm, Yêu cầu hỗ trợ,..." required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" 
                                      rows="6" placeholder="Mô tả chi tiết vấn đề hoặc yêu cầu của bạn..." required>{{ old('message') }}</textarea>
                            <small class="text-muted">Tối thiểu 10 ký tự</small>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi Yêu Cầu
                            </button>
                            <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list"></i> Xem Yêu Cầu Của Tôi
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border-left border-primary">
                        <div class="card-body">
                            <h6 class="text-primary">
                                <i class="fas fa-clock"></i> Thời Gian Phản Hồi
                            </h6>
                            <p class="mb-0">Chúng tôi thường trả lời trong vòng 24 giờ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border-left border-success">
                        <div class="card-body">
                            <h6 class="text-success">
                                <i class="fas fa-shield-alt"></i> An Toàn
                            </h6>
                            <p class="mb-0">Thông tin của bạn được bảo mật tuyệt đối</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left {
        border-left: 4px solid !important;
    }
</style>
@endsection
