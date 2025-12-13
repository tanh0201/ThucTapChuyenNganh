@extends('admin.layout.base')

@section('title', 'PetSam Admin - Sửa Vai Trò')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.roles.index') }}">Vai Trò</a>
  </li>
  <li class="breadcrumb-item active">Sửa Vai Trò</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="h3 mb-0">
      <i class="fa fa-edit"></i> Sửa Vai Trò: <strong>{{ $role->display_name }}</strong>
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
          <i class="fa fa-info-circle"></i> Thông Tin Vai Trò
        </h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Hidden name field for validation -->
          <input type="hidden" name="name" value="{{ $role->name }}">

          <!-- Name (Read-only) -->
          <div class="form-group">
            <label for="name">
              <strong>Tên Vai Trò (Không được sửa)</strong>
            </label>
            <input type="text" class="form-control" id="name" value="{{ $role->name }}" readonly>
            <small class="form-text text-muted">Tên vai trò không thể thay đổi</small>
          </div>

          <!-- Display Name -->
          <div class="form-group">
            <label for="display_name">
              <strong>Tên Hiển Thị</strong>
              <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" 
              name="display_name" value="{{ old('display_name', $role->display_name) }}" required>
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
              name="description" rows="3">{{ old('description', $role->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <hr>

          <!-- Permissions Section -->
          <div class="form-group">
            <label>
              <strong><i class="fa fa-shield-alt"></i> Phân Quyền</strong>
            </label>
            <p class="text-muted small mb-3">Chọn các quyền mà vai trò này sẽ có:</p>

            @if($permissions->count() > 0)
              <div class="permission-search-container mb-3">
                <input type="text" id="permissionSearch" class="form-control" placeholder="🔍 Tìm kiếm quyền...">
              </div>

              <div class="permission-list row" id="permissionList">
                @foreach($permissions as $permission)
                  <div class="col-md-6 col-lg-4 mb-3 permission-item">
                    <div class="custom-control custom-checkbox h-100" style="padding: 12px; border: 1px solid #dee2e6; border-radius: 6px; background-color: #f8f9fa; transition: all 0.3s ease;">
                      <input type="checkbox" class="custom-control-input permission-checkbox" id="perm_{{ $permission->id }}" 
                        name="permissions[]" value="{{ $permission->id }}" 
                        data-name="{{ strtolower($permission->display_name) }}"
                        {{ in_array($permission->id, $rolePermissionIds) ? 'checked' : '' }}>
                      <label class="custom-control-label cursor-pointer w-100" for="perm_{{ $permission->id }}" style="cursor: pointer;">
                        <strong>{{ $permission->display_name }}</strong>
                        @if($permission->description)
                          <br>
                          <small class="text-muted d-block mt-1">{{ Str::limit($permission->description, 100) }}</small>
                        @endif
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
              
              <div id="noResults" class="alert alert-info mt-3" style="display: none;">
                <i class="fa fa-search"></i> Không tìm thấy quyền nào phù hợp
              </div>
            @else
              <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Chưa có quyền nào. <a href="{{ route('admin.permissions.create') }}">Tạo quyền mới</a>
              </div>
            @endif
          </div>

          <!-- Buttons -->
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Cập Nhật Vai Trò
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
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
          <strong>Số Quyền Hạn:</strong><br>
          <span style="display: inline-block; padding: 6px 12px; font-size: 14px; color: white; font-weight: 600; background-color: #6c757d; border-radius: 12px;">
            {{ $role->permissions()->count() }} quyền
          </span>
        </div>

        <hr>

        <div class="mb-3">
          <strong>Số Người Dùng:</strong><br>
          <span style="display: inline-block; padding: 6px 12px; font-size: 14px; color: white; font-weight: 600; background-color: #17a2b8; border-radius: 12px;">
            {{ $role->users()->count() }} người dùng
          </span>
        </div>

        <hr>

        <div class="mb-3">
          <strong>Ngày Tạo:</strong><br>
          <small class="text-muted">{{ $role->created_at->format('d/m/Y H:i') }}</small>
        </div>

        <div class="mb-3">
          <strong>Ngày Cập Nhật:</strong><br>
          <small class="text-muted">{{ $role->updated_at->format('d/m/Y H:i') }}</small>
        </div>

        <hr>

        <div class="alert alert-warning small mt-3">
          <strong><i class="fa fa-exclamation-triangle"></i> Chú Ý:</strong><br>
          Thay đổi quyền sẽ ảnh hưởng đến tất cả người dùng có vai trò này.
        </div>
      </div>
    </div>

    <!-- Users with this Role -->
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="background-color: #ffc107;">
        <h6 class="m-0 font-weight-bold" style="color: #000;">
          <i class="fa fa-users"></i> Người Dùng Có Vai Trò Này
        </h6>
      </div>
      <div class="card-body">
        @if($role->users()->count() > 0)
          <ul class="list-unstyled">
            @foreach($role->users()->limit(5)->get() as $user)
              <li class="mb-2">
                <small>
                  <strong>{{ $user->name }}</strong><br>
                  <span class="text-muted">{{ $user->email }}</span>
                </small>
              </li>
            @endforeach
          </ul>
          @if($role->users()->count() > 5)
            <small class="text-muted">+{{ $role->users()->count() - 5 }} người dùng khác...</small>
          @endif
        @else
          <p class="text-muted text-center small mb-0">Chưa có người dùng nào có vai trò này</p>
        @endif
      </div>
  </div>
</div>

@endsection

@section('additional-js')
<style>
  .permission-item label {
    cursor: pointer;
  }
  
  .permission-item .custom-checkbox:hover {
    background-color: #e7f3ff !important;
    border-color: #2e59d9 !important;
  }
  
  .permission-item .custom-checkbox input:checked ~ label {
    color: #2e59d9;
    font-weight: 600;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('permissionSearch');
    const permissionItems = document.querySelectorAll('.permission-item');
    const noResults = document.getElementById('noResults');

    if (searchInput) {
      searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        permissionItems.forEach(item => {
          const checkbox = item.querySelector('.permission-checkbox');
          const name = checkbox.dataset.name;
          
          if (name.includes(searchTerm)) {
            item.style.display = 'block';
            visibleCount++;
          } else {
            item.style.display = 'none';
          }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
      });
    }

    // Thêm hiệu ứng nhấp chuột vào label
    document.querySelectorAll('.permission-item label').forEach(label => {
      label.addEventListener('click', function(e) {
        if (e.target.tagName !== 'INPUT') {
          const checkbox = this.parentElement.querySelector('input[type="checkbox"]');
          checkbox.checked = !checkbox.checked;
        }
      });
    });
  });
</script>
@endsection
