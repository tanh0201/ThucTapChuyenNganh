@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Quyền')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="/admin/roles">Phân Quyền</a>
  </li>
  <li class="breadcrumb-item active">Quản Lý Quyền</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-key"></i> Quản Lý Quyền (Permissions)
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="/admin/roles" class="btn btn-info mr-2">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
    <button class="btn btn-primary" onclick="showAddForm()">
      <i class="fa fa-plus"></i> Thêm Quyền
    </button>
  </div>
</div>

<!-- Flash Messages -->
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Có lỗi xảy ra!</strong>
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Add Permission Form Container -->
<div id="formContainer" class="card shadow mb-4" style="display: none; background-color: #ffffff; z-index: 10;">
  <div class="card-header py-3" style="background-color: #1cc88a; color: white;">
    <h6 class="m-0 font-weight-bold" id="formTitle" style="color: white;">
      <i class="fa fa-plus"></i> Thêm Quyền Mới
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <form id="permissionForm" method="POST">
      @csrf
      <input type="hidden" id="permissionId" name="permission_id">
      <input type="hidden" id="formMethod" name="_method" value="POST">

      <div class="row">
        <!-- Permission Name -->
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">
            <strong>Tên Quyền <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="VD: create-product, edit-user"
                 required>
          <small class="form-text text-muted">Tên phải là dạng kebab-case (vd: create-product)</small>
          @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Description -->
      <div class="mb-3">
        <label for="description" class="form-label">
          <strong>Mô Tả</strong>
        </label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" 
                  name="description" 
                  rows="2" 
                  placeholder="Nhập mô tả quyền"></textarea>
        @error('description')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
          <i class="fa fa-save"></i> Lưu Quyền
        </button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="hideForm()">
          <i class="fa fa-times"></i> Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Permissions Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Quyền
    </h6>
  </div>
  <div class="card-body" style="background-color: #fff; padding: 0;">
    @if($permissions->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="background-color: #fff;">
          <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <tr>
              <th style="padding: 1rem;">STT</th>
              <th style="padding: 1rem;">Tên Quyền</th>
              <th style="padding: 1rem;">Slug</th>
              <th style="padding: 1rem;">Mô Tả</th>
              <th style="padding: 1rem;">Vai Trò Sử Dụng</th>
              <th style="padding: 1rem;">Hành Động</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
              <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 1rem;">
                  <strong>{{ $loop->iteration }}</strong>
                </td>
                <td style="padding: 1rem;">
                  <strong class="d-block">{{ $permission->name }}</strong>
                </td>
                <td style="padding: 1rem;">
                  <code style="background-color: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 3px;">
                    {{ $permission->slug }}
                  </code>
                </td>
                <td style="padding: 1rem;">
                  {{ $permission->description ?? '-' }}
                </td>
                <td style="padding: 1rem;">
                  @php
                    $rolesUsingPermission = $permission->roles()->count();
                  @endphp
                  @if($rolesUsingPermission > 0)
                    <span class="badge badge-success">{{ $rolesUsingPermission }} vai trò</span>
                  @else
                    <span class="badge badge-light">Không sử dụng</span>
                  @endif
                </td>
                <td style="padding: 1rem;">
                  <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-primary edit-btn" 
                            data-id="{{ $permission->id }}"
                            data-name="{{ $permission->name }}"
                            data-description="{{ $permission->description ?? '' }}"
                            title="Sửa">
                      <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" 
                            data-id="{{ $permission->id }}"
                            title="Xóa">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center p-3" style="background-color: #f8f9fa;">
        {{ $permissions->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-key fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có quyền nào. <a href="#" onclick="showAddForm()" class="font-weight-bold">Tạo quyền mới</a></p>
      </div>
    @endif
  </div>
</div>

<!-- Default Permissions Template Card -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #36b9cc; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-lightbulb-o"></i> Quyền Mặc Định Được Khuyến Nghị
    </h6>
  </div>
  <div class="card-body">
    <p class="text-muted mb-3">Các quyền sau được khuyến nghị để tạo một hệ thống quản lý đầy đủ:</p>
    <div class="row">
      <div class="col-md-6">
        <h6 class="font-weight-bold mb-2"><i class="fa fa-shopping-bag"></i> Sản Phẩm</h6>
        <ul style="padding-left: 1.5rem; line-height: 1.8;">
          <li><code>view-products</code> - Xem danh sách sản phẩm</li>
          <li><code>create-product</code> - Tạo sản phẩm mới</li>
          <li><code>edit-product</code> - Sửa sản phẩm</li>
          <li><code>delete-product</code> - Xóa sản phẩm</li>
        </ul>
      </div>
      <div class="col-md-6">
        <h6 class="font-weight-bold mb-2"><i class="fa fa-folder"></i> Danh Mục</h6>
        <ul style="padding-left: 1.5rem; line-height: 1.8;">
          <li><code>view-categories</code> - Xem danh mục</li>
          <li><code>create-category</code> - Tạo danh mục</li>
          <li><code>edit-category</code> - Sửa danh mục</li>
          <li><code>delete-category</code> - Xóa danh mục</li>
        </ul>
      </div>
      <div class="col-md-6">
        <h6 class="font-weight-bold mb-2"><i class="fa fa-shopping-cart"></i> Đơn Hàng</h6>
        <ul style="padding-left: 1.5rem; line-height: 1.8;">
          <li><code>view-orders</code> - Xem đơn hàng</li>
          <li><code>edit-order</code> - Cập nhật đơn hàng</li>
          <li><code>delete-order</code> - Xóa đơn hàng</li>
        </ul>
      </div>
      <div class="col-md-6">
        <h6 class="font-weight-bold mb-2"><i class="fa fa-users"></i> Người Dùng</h6>
        <ul style="padding-left: 1.5rem; line-height: 1.8;">
          <li><code>view-users</code> - Xem người dùng</li>
          <li><code>create-user</code> - Tạo người dùng</li>
          <li><code>edit-user</code> - Sửa người dùng</li>
          <li><code>delete-user</code> - Xóa người dùng</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Show Add Form
function showAddForm() {
  resetForm();
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-plus"></i> Thêm Quyền Mới';
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Tạo Quyền';
  document.getElementById('permissionForm').action = '/admin/permissions';
  document.getElementById('formMethod').value = 'POST';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Hide Form
function hideForm() {
  document.getElementById('formContainer').style.display = 'none';
  resetForm();
}

// Reset Form
function resetForm() {
  document.getElementById('permissionForm').reset();
  document.getElementById('permissionId').value = '';
}

// Edit Permission
function editPermission(id, name, description) {
  document.getElementById('name').value = name;
  document.getElementById('description').value = description;
  document.getElementById('permissionId').value = id;

  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-edit"></i> Sửa Quyền: ' + name;
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Cập Nhật Quyền';
  document.getElementById('permissionForm').action = `/admin/permissions/${id}`;
  document.getElementById('formMethod').value = 'PATCH';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete Permission
function deletePermission(id) {
  if (confirm('Bạn có chắc chắn muốn xóa quyền này?\n\nLưu ý: Nếu quyền đang được sử dụng bởi vai trò, bạn cần xóa khỏi các vai trò trước!')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/permissions/${id}`;
    form.style.display = 'none';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    form.innerHTML = `
      <input type="hidden" name="_token" value="${csrfToken}">
      <input type="hidden" name="_method" value="DELETE">
    `;
    
    document.body.appendChild(form);
    form.submit();
  }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
  // Event listeners for edit buttons
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const data = {
        id: this.getAttribute('data-id'),
        name: this.getAttribute('data-name'),
        description: this.getAttribute('data-description')
      };
      editPermission(data.id, data.name, data.description);
    });
  });

  // Event listeners for delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deletePermission(id);
    });
  });
});
</script>
@endsection
