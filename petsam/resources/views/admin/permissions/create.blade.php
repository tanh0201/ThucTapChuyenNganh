@extends('admin.layout.base')

@section('title', 'PetSam Admin - Thêm Quyền Hạn')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.permissions.index') }}">Quyền Hạn</a>
  </li>
  <li class="breadcrumb-item active">Thêm Quyền Hạn</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="h3 mb-0">
      <i class="fa fa-plus-circle"></i> Thêm Quyền Hạn Mới
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
        <form action="{{ route('admin.permissions.store') }}" method="POST">
          @csrf

          <!-- Name -->
          <div class="form-group">
            <label for="name">
              <strong>Tên Quyền (Không chứa khoảng trắng)</strong>
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
              placeholder="Ví dụ: view_products, edit_products, delete_products" value="{{ old('name') }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Tên quyền sẽ được sử dụng trong code (snake_case)</small>
          </div>

          <!-- Display Name -->
          <div class="form-group">
            <label for="display_name">
              <strong>Tên Hiển Thị</strong>
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" 
              name="display_name" placeholder="Ví dụ: Xem Sản Phẩm, Chỉnh Sửa Sản Phẩm" value="{{ old('display_name') }}" required>
            @error('display_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Tên được hiển thị cho người dùng</small>
          </div>

          <!-- Description -->
          <div class="form-group">
            <label for="description">
              <strong>Mô Tả</strong>
            </label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
              name="description" rows="3" placeholder="Mô tả chi tiết về quyền này...">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Buttons -->
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Lưu Quyền Hạn
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
          <i class="fa fa-lightbulb"></i> Gợi Ý
        </h6>
      </div>
      <div class="card-body">
        <h6 class="font-weight-bold mb-3">Các Quyền Phổ Biến:</h6>
        <ul class="list-unstyled small">
          <li class="mb-2">
            <strong>view_dashboard</strong> - Xem bảng điều khiển
          </li>
          <li class="mb-2">
            <strong>view_products</strong> - Xem danh sách sản phẩm
          </li>
          <li class="mb-2">
            <strong>create_products</strong> - Tạo sản phẩm mới
          </li>
          <li class="mb-2">
            <strong>edit_products</strong> - Chỉnh sửa sản phẩm
          </li>
          <li class="mb-2">
            <strong>delete_products</strong> - Xóa sản phẩm
          </li>
          <li class="mb-2">
            <strong>view_categories</strong> - Xem danh mục
          </li>
          <li class="mb-2">
            <strong>manage_users</strong> - Quản lý người dùng
          </li>
          <li class="mb-2">
            <strong>manage_roles</strong> - Quản lý vai trò
          </li>
        </ul>

        <div class="alert alert-info mt-3 small">
          <strong><i class="fa fa-info-circle"></i> Lưu Ý:</strong><br>
          Sau khi tạo quyền, bạn có thể gán nó cho các vai trò.
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
