@extends('admin.layout.base')

@section('title', 'PetSam Admin - Thêm Người Dùng Mới')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.users.index') }}">Người Dùng</a>
  </li>
  <li class="breadcrumb-item active">Thêm Người Dùng Mới</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-plus"></i> Thêm Người Dùng Mới
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
  </div>
</div>

<!-- Form Container -->
<div class="card shadow">
  <div class="card-header py-3" style="background-color: #4e73df;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-user"></i> Thông Tin Người Dùng
    </h6>
  </div>
  <div class="card-body">
    <!-- Error Messages -->
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fa fa-exclamation-circle"></i> Có lỗi xảy ra!</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">
          <span>&times;</span>
        </button>
      </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" id="createForm">
      @csrf

      <div class="row">
        <!-- User Name -->
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">
            <strong>Tên Người Dùng <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="Nhập tên người dùng"
                 value="{{ old('name') }}"
                 required>
          @error('name')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">
            <strong>Email <span class="text-danger">*</span></strong>
          </label>
          <input type="email" 
                 class="form-control @error('email') is-invalid @enderror" 
                 id="email" 
                 name="email" 
                 placeholder="Nhập email"
                 value="{{ old('email') }}"
                 required>
          @error('email')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row">
        <!-- Password -->
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label">
            <strong>Mật Khẩu <span class="text-danger">*</span></strong>
          </label>
          <input type="password" 
                 class="form-control @error('password') is-invalid @enderror" 
                 id="password" 
                 name="password" 
                 placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)"
                 required>
          @error('password')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6 mb-3">
          <label for="password_confirmation" class="form-label">
            <strong>Xác Nhận Mật Khẩu <span class="text-danger">*</span></strong>
          </label>
          <input type="password" 
                 class="form-control @error('password_confirmation') is-invalid @enderror" 
                 id="password_confirmation" 
                 name="password_confirmation" 
                 placeholder="Xác nhận mật khẩu"
                 required>
          @error('password_confirmation')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row">
        <!-- Phone -->
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label">
            <strong>Điện Thoại</strong>
          </label>
          <input type="text" 
                 class="form-control @error('phone') is-invalid @enderror" 
                 id="phone" 
                 name="phone" 
                 placeholder="Nhập số điện thoại"
                 value="{{ old('phone') }}">
          @error('phone')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Role -->
        <div class="col-md-6 mb-3">
          <label for="role" class="form-label">
            <strong>Vai Trò <span class="text-danger">*</span></strong>
          </label>
          <select class="form-control @error('role') is-invalid @enderror" 
                  id="role" 
                  name="role" 
                  required>
            <option value="">-- Chọn vai trò --</option>
            @foreach($roles as $role)
              <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
              </option>
            @endforeach
          </select>
          @error('role')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <!-- Address -->
      <div class="mb-3">
        <label for="address" class="form-label">
          <strong>Địa Chỉ</strong>
        </label>
        <textarea class="form-control @error('address') is-invalid @enderror" 
                  id="address" 
                  name="address" 
                  rows="3" 
                  placeholder="Nhập địa chỉ (tùy chọn)">{{ old('address') }}</textarea>
        @error('address')
          <div class="invalid-feedback d-block">
            <i class="fa fa-times-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Status -->
      <div class="mb-3">
        <label for="status" class="form-label">
          <strong>Trạng Thái <span class="text-danger">*</span></strong>
        </label>
        <select class="form-control @error('status') is-invalid @enderror" 
                id="status" 
                name="status" 
                required>
          <option value="">-- Chọn trạng thái --</option>
          <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Hoạt Động</option>
          <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Khóa</option>
        </select>
        @error('status')
          <div class="invalid-feedback d-block">
            <i class="fa fa-times-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4 pt-3 border-top">
        <button type="submit" class="btn btn-success btn-lg">
          <i class="fa fa-save"></i> Tạo Người Dùng
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
          <i class="fa fa-times"></i> Hủy
        </a>
      </div>
    </form>
  </div>
</div>

@endsection
