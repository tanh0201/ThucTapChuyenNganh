@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Phân Quyền')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Phân Quyền</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-shield"></i> Quản Lý Phân Quyền (Roles)
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="/admin/permissions" class="btn btn-info mr-2">
      <i class="fa fa-key"></i> Quản Lý Quyền
    </a>
    <button class="btn btn-primary" onclick="showAddForm()">
      <i class="fa fa-plus"></i> Thêm Vai Trò
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

<!-- Add/Edit Form Container -->
<div id="formContainer" class="card shadow mb-4" style="display: none; background-color: #ffffff; z-index: 10;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" id="formTitle" style="color: white;">
      <i class="fa fa-plus"></i> Thêm Vai Trò Mới
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <form id="roleForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="roleId" name="role_id">
      <input type="hidden" id="formMethod" name="_method" value="POST">

      <div class="row">
        <!-- Role Name -->
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">
            <strong>Tên Vai Trò <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="Nhập tên vai trò (VD: Editor, Reviewer)"
                 required>
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
                  placeholder="Nhập mô tả vai trò"></textarea>
        @error('description')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <!-- Permissions Selection -->
      <div class="mb-4">
        <label class="form-label">
          <strong>Phân Quyền <span class="text-danger">*</span></strong>
        </label>
        <div class="card" style="border: 1px solid #dee2e6; padding: 1rem;">
          <div id="permissionsContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @foreach($permissions as $permission)
              <div class="form-check">
                <input class="form-check-input permission-checkbox" 
                       type="checkbox" 
                       id="permission_{{ $permission->id }}" 
                       name="permissions[]" 
                       value="{{ $permission->id }}">
                <label class="form-check-label" for="permission_{{ $permission->id }}">
                  <strong>{{ $permission->name }}</strong>
                  <br>
                  <small class="text-muted">{{ $permission->description ?? 'Không có mô tả' }}</small>
                </label>
              </div>
            @endforeach
          </div>
        </div>
        @if($permissions->isEmpty())
          <div class="alert alert-warning mt-2">
            <i class="fa fa-exclamation-triangle"></i> Chưa có quyền nào. <a href="/admin/permissions">Tạo quyền trước</a>
          </div>
        @endif
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
          <i class="fa fa-save"></i> Lưu Vai Trò
        </button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="hideForm()">
          <i class="fa fa-times"></i> Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Roles Grid -->
<div class="row">
  @if($roles->count() > 0)
    @foreach($roles as $role)
      <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3" style="background-color: #4e73df; color: white;">
            <h6 class="m-0 font-weight-bold" style="color: white;">
              <i class="fa fa-user-shield"></i> {{ $role->name }}
            </h6>
          </div>
          <div class="card-body">
            <!-- Description -->
            @if($role->description)
              <p class="text-muted mb-3">{{ $role->description }}</p>
            @endif

            <!-- Role Slug -->
            <div class="mb-3">
              <small class="text-muted d-block"><strong>Slug:</strong></small>
              <code style="background-color: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 3px;">{{ $role->slug }}</code>
            </div>

            <!-- Permissions -->
            <div class="mb-3">
              <small class="text-muted d-block mb-2"><strong>Quyền Hạn ({{ $role->permissions()->count() }})</strong>:</small>
              @if($role->permissions()->count() > 0)
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                  @foreach($role->permissions as $permission)
                    <span class="badge badge-success">{{ $permission->name }}</span>
                  @endforeach
                </div>
              @else
                <p class="text-muted mb-0">Chưa có quyền hạn</p>
              @endif
            </div>

            <!-- Created At -->
            <div class="mb-3">
              <small class="text-muted d-block"><strong>Tạo ngày:</strong></small>
              <p class="text-dark mb-0">{{ $role->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Actions -->
            <hr>
            <div>
              <button class="btn btn-sm btn-primary edit-btn" 
                      data-id="{{ $role->id }}"
                      data-name="{{ $role->name }}" 
                      data-description="{{ $role->description ?? '' }}"
                      data-permissions="{{ json_encode($role->permissions->pluck('id')->toArray()) }}">
                <i class="fa fa-edit"></i> Sửa
              </button>
              <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $role->id }}">
                <i class="fa fa-trash"></i> Xóa
              </button>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <!-- Pagination -->
    <div class="col-md-12">
      <div class="d-flex justify-content-center mt-4 p-3">
        {{ $roles->links() }}
      </div>
    </div>
  @else
    <div class="col-md-12">
      <div class="card text-center py-5">
        <i class="fa fa-shield fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có vai trò nào. <a href="#" onclick="showAddForm()" class="font-weight-bold">Tạo vai trò mới</a></p>
      </div>
    </div>
  @endif
</div>

@endsection

@section('additional-js')
<script>
// Show Add Form
function showAddForm() {
  resetForm();
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-plus"></i> Thêm Vai Trò Mới';
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Tạo Vai Trò';
  document.getElementById('roleForm').action = '/admin/roles';
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
  document.getElementById('roleForm').reset();
  document.getElementById('roleId').value = '';
  document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
}

// Edit Role
function editRole(id, name, description, permissions) {
  // Populate form
  document.getElementById('name').value = name;
  document.getElementById('description').value = description;
  document.getElementById('roleId').value = id;

  // Uncheck all first
  document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);

  // Check selected permissions
  const permissionIds = JSON.parse(permissions);
  permissionIds.forEach(permId => {
    const checkbox = document.getElementById(`permission_${permId}`);
    if (checkbox) {
      checkbox.checked = true;
    }
  });

  // Update form
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-edit"></i> Sửa Vai Trò: ' + name;
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Cập Nhật Vai Trò';
  document.getElementById('roleForm').action = `/admin/roles/${id}`;
  document.getElementById('formMethod').value = 'PATCH';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete Role
function deleteRole(id) {
  if (confirm('Bạn có chắc chắn muốn xóa vai trò này?')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/roles/${id}`;
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
        description: this.getAttribute('data-description'),
        permissions: this.getAttribute('data-permissions')
      };
      editRole(data.id, data.name, data.description, data.permissions);
    });
  });

  // Event listeners for delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deleteRole(id);
    });
  });
});
</script>
@endsection
