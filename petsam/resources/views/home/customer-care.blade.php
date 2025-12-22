@extends('layout/app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-headset text-primary"></i> Hỗ Trợ Khách Hàng
                </h2>
                @auth
                <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list me-2"></i>Xem Yêu Cầu Của Tôi
                </a>
                @endauth
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Gửi Yêu Cầu Hỗ Trợ
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><strong>Lỗi Xác Thực!</strong>
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
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Chúng tôi ở đây để giúp bạn!</strong> Vui lòng mô tả chi tiết vấn đề của bạn và đội ngũ hỗ trợ sẽ phản hồi trong vòng 24 giờ.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

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

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi Yêu Cầu
                            </button>
                            @auth
                            <a href="{{ route('customer-care.my-tickets') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list me-2"></i>Xem Lịch Sử
                            </a>
                            @endauth
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mt-5 g-3">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-clock text-primary fa-2x"></i>
                            </div>
                            <h6 class="card-title fw-bold">Phản Hồi Nhanh</h6>
                            <p class="card-text small text-muted mb-0">Chúng tôi thường trả lời trong vòng 24 giờ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-success bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-shield-alt text-success fa-2x"></i>
                            </div>
                            <h6 class="card-title fw-bold">Bảo Mật Tuyệt Đối</h6>
                            <p class="card-text small text-muted mb-0">Thông tin của bạn được bảo vệ an toàn</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-info bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-headset text-info fa-2x"></i>
                            </div>
                            <h6 class="card-title fw-bold">Hỗ Trợ 24/7</h6>
                            <p class="card-text small text-muted mb-0">Đội ngũ hỗ trợ sẵn sàng giúp bạn bất cứ lúc nào</p>
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
