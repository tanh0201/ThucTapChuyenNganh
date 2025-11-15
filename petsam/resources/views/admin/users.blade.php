@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Người Dùng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Người Dùng</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-users"></i> Quản Lý Người Dùng
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <button class="btn btn-primary" onclick="showAddForm()">
      <i class="fa fa-plus"></i> Thêm Người Dùng
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
      <i class="fa fa-plus"></i> Thêm Người Dùng Mới
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <form id="userForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="userId" name="user_id">
      <input type="hidden" id="formMethod" name="_method" value="POST">

      <div class="row">
        <!-- Name -->
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label" style="color: #333333;">
            <strong>Họ Tên <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="Nhập họ tên"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 required>
          @error('name')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label" style="color: #333333;">
            <strong>Email <span class="text-danger">*</span></strong>
          </label>
          <input type="email" 
                 class="form-control @error('email') is-invalid @enderror" 
                 id="email" 
                 name="email" 
                 placeholder="Nhập email"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 required>
          @error('email')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row">
        <!-- Phone -->
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label" style="color: #333333;">
            <strong>Số Điện Thoại</strong>
          </label>
          <input type="text" 
                 class="form-control @error('phone') is-invalid @enderror" 
                 id="phone" 
                 name="phone" 
                 placeholder="Nhập số điện thoại"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;">
          @error('phone')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Role -->
        <div class="col-md-6 mb-3">
          <label for="role_id" class="form-label" style="color: #333333;">
            <strong>Vai Trò <span class="text-danger">*</span></strong>
          </label>
          <select class="form-control @error('role_id') is-invalid @enderror" 
                  id="role_id" 
                  name="role_id" 
                  style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                  required>
            <option value="">-- Chọn vai trò --</option>
            @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
          @error('role_id')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Address -->
      <div class="mb-3">
        <label for="address" class="form-label" style="color: #333333;">
          <strong>Địa Chỉ</strong>
        </label>
        <textarea class="form-control @error('address') is-invalid @enderror" 
                  id="address" 
                  name="address" 
                  rows="2" 
                  placeholder="Nhập địa chỉ"
                  style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"></textarea>
        @error('address')
          <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password Alert -->
      <div class="alert alert-info mb-3" style="background-color: #e7f3ff; border: 1px solid #b3d9ff; color: #004085;">
        <i class="fa fa-info-circle"></i> <strong>Mật Khẩu:</strong> Chỉ cần nhập khi thêm người dùng mới hoặc muốn đổi mật khẩu
      </div>

      <div class="row">
        <!-- Password -->
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label" style="color: #333333;">
            <strong id="passwordLabel">Mật Khẩu <span class="text-danger">*</span></strong>
          </label>
          <input type="password" 
                 class="form-control @error('password') is-invalid @enderror" 
                 id="password" 
                 name="password" 
                 placeholder="Nhập mật khẩu"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 required>
          <small class="form-text" style="color: #666666;">Tối thiểu 8 ký tự</small>
          @error('password')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
          <label for="status" class="form-label" style="color: #333333;">
            <strong>Trạng Thái <span class="text-danger">*</span></strong>
          </label>
          <select class="form-control @error('status') is-invalid @enderror" 
                  id="status" 
                  name="status" 
                  style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                  required>
            <option value="active">Hoạt Động</option>
            <option value="inactive">Không Hoạt Động</option>
          </select>
          @error('status')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
          <i class="fa fa-save"></i> Lưu Người Dùng
        </button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="hideForm()">
          <i class="fa fa-times"></i> Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Filter & Search Bar -->
<div class="card shadow mb-4">
  <div class="card-body">
    <form method="GET" action="/admin/users" class="form-inline">
      <div class="form-group mr-3 mb-2">
        <label for="search" class="mr-2" style="color: #333333;"><strong>Tìm Kiếm:</strong></label>
        <input type="text" 
               class="form-control" 
               id="search" 
               name="search" 
               placeholder="Tên hoặc email..."
               style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
               value="{{ request('search') }}">
      </div>

      <button type="submit" class="btn btn-primary mb-2">
        <i class="fa fa-search"></i> Tìm Kiếm
      </button>
      <a href="/admin/users" class="btn btn-secondary mb-2 ml-2">
        <i class="fa fa-redo"></i> Reset
      </a>
    </form>
  </div>
</div>

<!-- Users Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Người Dùng
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    @if($users->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="background-color: #ffffff;">
          <thead style="background-color: #4e73df; border-bottom: 2px solid #dee2e6;">
            <tr>
              <th style="padding: 1rem; color: #ffffff;"><strong>STT</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Họ Tên</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Email</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Số ĐT</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Vai Trò</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Trạng Thái</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Tham Gia</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Hành Động</strong></th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr style="border-bottom: 1px solid #dee2e6; background-color: #ffffff;">
                <td style="padding: 1rem; color: #333333;">
                  <strong>{{ $loop->iteration }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <strong class="d-block">{{ $user->name }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <a href="mailto:{{ $user->email }}" style="color: #4e73df; text-decoration: none;">{{ $user->email }}</a>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  {{ $user->phone ?? '-' }}
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @if($user->role)
                    <span class="badge badge-primary" style="background-color: #4e73df; color: white; font-size: 14px; padding: 8px 12px;">{{ $user->role->name }}</span>
                  @else
                    <span class="badge badge-secondary" style="background-color: #858796; color: white; font-size: 14px; padding: 8px 12px;">Chưa gán</span>
                  @endif
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @if($user->status === 'active')
                    <span class="badge badge-success" style="background-color: #1cc88a; color: white; font-size: 14px; padding: 8px 12px;">Hoạt Động</span>
                  @else
                    <span class="badge badge-secondary" style="background-color: #e74c3c; color: white; font-size: 14px; padding: 8px 12px;">Khóa</span>
                  @endif
                </td>
                <td style="padding: 1rem; color: #666666;">
                  <small class="d-block">{{ $user->created_at->format('d/m/Y') }}</small>
                </td>
                <td style="padding: 1rem;">
                  <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-primary edit-btn" 
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}" 
                            data-email="{{ $user->email }}"
                            data-phone="{{ $user->phone ?? '' }}"
                            data-address="{{ $user->address ?? '' }}"
                            data-role_id="{{ $user->role_id ?? '' }}"
                            data-status="{{ $user->status }}"
                            title="Sửa">
                      <i class="fa fa-edit"></i> Sửa
                    </button>
                    <button class="btn btn-info permissions-btn" 
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            title="Quản lý phân quyền">
                      <i class="fa fa-lock"></i> Quyền
                    </button>
                    <button class="btn btn-danger delete-btn" 
                            data-id="{{ $user->id }}"
                            title="Xóa">
                      <i class="fa fa-trash"></i> Xóa
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
        {{ $users->links() }}
      </div>
    @else
      <div class="text-center py-5" style="background-color: #ffffff;">
        <i class="fa fa-users fa-3x mb-3" style="color: #bbb;"></i>
        <p style="color: #666666; font-size: 16px;">Chưa có người dùng nào. <a href="#" onclick="showAddForm()" class="font-weight-bold" style="color: #4e73df;">Thêm người dùng mới</a></p>
      </div>
    @endif
  </div>
</div>

<!-- Permissions Modal -->
<div class="modal fade" id="permissionsModal" tabindex="-1" role="dialog" aria-labelledby="permissionsModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4e73df; color: white;">
        <h5 class="modal-title" id="permissionsModalLabel" style="color: white;">
          <i class="fa fa-lock"></i> Quản Lý Phân Quyền: <span id="userNameDisplay"></span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="permissionsForm" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body" style="max-height: 500px; overflow-y: auto; background-color: #ffffff;">
          <div id="permissionsContainer"></div>
        </div>
        <div class="modal-footer" style="background-color: #f8f9fa;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Lưu Quyền
          </button>
        </div>
      </form>
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
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-plus"></i> Thêm Người Dùng Mới';
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Tạo Người Dùng';
  document.getElementById('passwordLabel').innerHTML = 'Mật Khẩu <span class="text-danger">*</span>';
  document.getElementById('password').required = true;
  document.getElementById('userForm').action = '/admin/users';
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
  document.getElementById('userForm').reset();
  document.getElementById('userId').value = '';
}

// Edit User
function editUser(id, name, email, phone, address, role_id, status) {
  document.getElementById('name').value = name;
  document.getElementById('email').value = email;
  document.getElementById('phone').value = phone;
  document.getElementById('address').value = address;
  document.getElementById('role_id').value = role_id || '';
  document.getElementById('status').value = status;
  document.getElementById('userId').value = id;

  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-edit"></i> Sửa: ' + name;
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Cập Nhật';
  document.getElementById('passwordLabel').innerHTML = 'Mật Khẩu (để trống nếu không đổi)';
  document.getElementById('password').required = false;
  document.getElementById('userForm').action = `/admin/users/${id}`;
  document.getElementById('formMethod').value = 'PATCH';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete User
function deleteUser(id) {
  if (confirm('Xóa người dùng này?')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/users/${id}`;
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

// Show Permissions Modal
function showPermissionsModal(userId, userName) {
  document.getElementById('userNameDisplay').textContent = userName;
  document.getElementById('permissionsForm').action = `/admin/users/${userId}/permissions`;
  
  // Fetch permissions from server
  fetch(`/admin/users/${userId}/permissions`)
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById('permissionsContainer');
      container.innerHTML = '';
      
      data.permissions.forEach(permission => {
        const isChecked = data.userPermissions.includes(permission.id);
        const html = `
          <div class="form-check mb-3 p-2" style="background-color: #f8f9fa; border-radius: 4px; border-left: 4px solid #4e73df;">
            <input class="form-check-input" type="checkbox" id="perm_${permission.id}" 
                   name="permissions[]" value="${permission.id}" ${isChecked ? 'checked' : ''}>
            <label class="form-check-label" for="perm_${permission.id}" style="color: #333333; margin: 0;">
              <strong style="color: #4e73df;">${permission.name}</strong>
              <br>
              <small style="color: #666666;">${permission.description || 'Không có mô tả'}</small>
            </label>
          </div>
        `;
        container.innerHTML += html;
      });
      
      $('#permissionsModal').modal('show');
    })
    .catch(error => {
      alert('Lỗi tải quyền: ' + error);
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
  // Edit buttons
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      editUser(
        this.dataset.id,
        this.dataset.name,
        this.dataset.email,
        this.dataset.phone,
        this.dataset.address,
        this.dataset.role_id,
        this.dataset.status
      );
    });
  });

  // Delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      deleteUser(this.dataset.id);
    });
  });

  // Permissions buttons
  document.querySelectorAll('.permissions-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      showPermissionsModal(this.dataset.id, this.dataset.name);
    });
  });
});
</script>
@endsection
