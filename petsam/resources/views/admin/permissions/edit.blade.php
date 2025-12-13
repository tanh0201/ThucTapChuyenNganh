@extends('admin.layout.base')

@section('title', 'PetSam Admin - Sửa Quyền Hạn')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.permissions.index') }}">Quyền Hạn</a>
  </li>
  <li class="breadcrumb-item active">Sửa Quyền Hạn</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="h3 mb-0">
      <i class="fa fa-edit"></i> Sửa Quyền Hạn: <strong>{{ $permission->display_name }}</strong>
    </h2>
  </div>
</div>

<!-- Flash Messages -->
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

<div class="row">
  <!-- Form Section -->
  <div class="col-lg-8">
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="background-color: #2e59d9;">
        <h6 class="m-0 font-weight-bold text-white">
          <i class="fa fa-info-circle"></i> Thông Tin Quyền Hạn
        </h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Hidden name field for validation -->
          <input type="hidden" name="name" value="{{ $permission->name }}">

          <!-- Name (Read-only) -->
          <div class="form-group">
            <label for="name">
              <strong>Tên Quyền (Không được sửa)</strong>
            </label>
            <input type="text" class="form-control" id="name" value="{{ $permission->name }}" readonly>
            <small class="form-text text-muted">Tên quyền không thể thay đổi</small>
          </div>

          <!-- Display Name -->
          <div class="form-group">
            <label for="display_name">
              <strong>Tên Hiển Thị</strong>
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" 
              name="display_name" value="{{ old('display_name', $permission->display_name) }}" required>
            @error('display_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Description -->
          <div class="form-group">
            <label for="description">
              <strong>Mô Tả</strong>
            </label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
              name="description" rows="3">{{ old('description', $permission->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Buttons -->
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Cập Nhật Quyền Hạn
            </button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
              <i class="fa fa-arrow-left"></i> Quay Lại
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Info Section -->
  <div class="col-lg-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="background-color: #17a2b8;">
        <h6 class="m-0 font-weight-bold text-white">
          <i class="fa fa-chart-pie"></i> Thống Kê
        </h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <strong>Số Vai Trò Sử Dụng:</strong><br>
          <span style="display: inline-block; padding: 6px 12px; font-size: 14px; color: white; font-weight: 600; background-color: #6c757d; border-radius: 12px;">
            {{ $permission->roles()->count() }} vai trò
          </span>
        </div>

        <hr>

        <div class="mb-3">
          <strong>Ngày Tạo:</strong><br>
          <small class="text-muted">{{ $permission->created_at->format('d/m/Y H:i') }}</small>
        </div>

        <div class="mb-3">
          <strong>Ngày Cập Nhật:</strong><br>
          <small class="text-muted">{{ $permission->updated_at->format('d/m/Y H:i') }}</small>
        </div>

        <hr>

        <div class="alert alert-warning small mt-3">
          <strong><i class="fa fa-exclamation-triangle"></i> Chú Ý:</strong><br>
          Thay đổi thông tin quyền sẽ ảnh hưởng đến tất cả vai trò sử dụng quyền này.
        </div>
      </div>
    </div>

    <!-- Roles using this Permission -->
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="background-color: #28a745;">
        <h6 class="m-0 font-weight-bold" style="color: #fff;">
          <i class="fa fa-user-secret"></i> Vai Trò Sử Dụng
        </h6>
      </div>
      <div class="card-body">
        @if($permission->roles()->count() > 0)
          <ul class="list-unstyled">
            @foreach($permission->roles()->limit(5)->get() as $role)
              <li class="mb-2">
                <small>
                  <strong>{{ $role->display_name }}</strong><br>
                  <span class="text-muted">{{ $role->name }}</span>
                </small>
              </li>
            @endforeach
          </ul>
          @if($permission->roles()->count() > 5)
            <small class="text-muted">+{{ $permission->roles()->count() - 5 }} vai trò khác...</small>
          @endif
        @else
          <p class="text-muted text-center small mb-0">Chưa có vai trò nào sử dụng quyền này</p>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
