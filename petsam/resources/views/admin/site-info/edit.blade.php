@extends('admin.layout.base')

@section('title', 'Chỉnh Sửa Thông Tin Trang Web - PetSam Admin')

@section('breadcrumb')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light px-4 py-3 rounded-lg">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.site-info.index') }}">Thông Tin Trang Web</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-edit text-primary"></i> Chỉnh Sửa
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>
                <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin trang web
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.site-info.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên trang web</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $siteInfo->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                id="address" name="address" value="{{ old('address', $siteInfo->address ?? '') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" name="phone" value="{{ old('phone', $siteInfo->phone ?? '') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $siteInfo->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4">{{ old('description', $siteInfo->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <h5 class="mb-3">Liên kết Mạng xã hội</h5>

                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook</label>
                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                id="facebook_url" name="facebook_url" placeholder="https://facebook.com/..." 
                                value="{{ old('facebook_url', $siteInfo->facebook_url ?? '') }}">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter</label>
                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                id="twitter_url" name="twitter_url" placeholder="https://twitter.com/..." 
                                value="{{ old('twitter_url', $siteInfo->twitter_url ?? '') }}">
                            @error('twitter_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram</label>
                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                id="instagram_url" name="instagram_url" placeholder="https://instagram.com/..." 
                                value="{{ old('instagram_url', $siteInfo->instagram_url ?? '') }}">
                            @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">YouTube</label>
                            <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                id="youtube_url" name="youtube_url" placeholder="https://youtube.com/..." 
                                value="{{ old('youtube_url', $siteInfo->youtube_url ?? '') }}">
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                            <a href="{{ route('admin.site-info.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
