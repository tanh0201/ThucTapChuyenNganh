@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Vai Trò')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Vai Trò</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-user-secret"></i> Quản Lý Vai Trò
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
      <i class="fa fa-plus"></i> Thêm Vai Trò
    </a>
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

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Roles Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #2e59d9;">
    <h6 class="m-0 font-weight-bold text-white">
      <i class="fa fa-list"></i> Danh Sách Vai Trò ({{ $roles->total() }} vai trò)
    </h6>
  </div>
  <div class="card-body">
    @if($roles->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 role-table">
          <thead style="background-color: #2e59d9; border-color: #1a3a70;">
            <tr>
              <th style="color: white; text-align: center; width: 60px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">STT</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Vai Trò</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Hiển Thị</th>
              <th style="color: white; text-align: center; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Quyền / Người Dùng</th>
              <th style="color: white; text-align: center; width: 180px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $index => $role)
              <tr style="border-color: #dee2e6;">
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
                <td style="color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  <i class="fa fa-user-secret"></i> {{ $role->name }}
                </td>
                <td style="color: #333; padding: 12px; border-color: #dee2e6;">{{ $role->display_name }}</td>
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  <span class="badge-permissions" title="Số quyền">
                    <i class="fa fa-shield-alt"></i> {{ $role->permissions->count() }} quyền
                  </span>
                  <br>
                  <span style="display: inline-block; margin-top: 6px; padding: 6px 12px; font-size: 12px; color: #fff; font-weight: 600; background-color: #17a2b8; border-radius: 12px;" title="Số người dùng">
                    <i class="fa fa-users"></i> {{ $role->users->count() }} users
                  </span>
                </td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  <div class="btn-group-actions">
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                      <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="deleteRole({{ $role->id }}, '{{ $role->display_name }}')" title="Xóa">
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
      <div class="d-flex justify-content-center mt-4">
        {{ $roles->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-user-secret fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có vai trò nào. <a href="{{ route('admin.roles.create') }}" class="font-weight-bold">Thêm vai trò mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<style>
  .role-table tbody tr {
    transition: background-color 0.3s ease;
  }

  .role-table tbody tr:hover {
    background-color: #f5f5f5;
  }

  .badge-permissions {
    display: inline-block;
    padding: 8px 12px;
    font-size: 12px;
    color: white;
    font-weight: 600;
    background-color: #6c757d;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .badge-permissions:hover {
    background-color: #5a6268;
    transform: scale(1.05);
  }

  .btn-group-actions {
    display: flex;
    gap: 5px;
  }

  .btn-sm {
    padding: 6px 10px;
    font-size: 12px;
  }
</style>

<script>
// Delete Role
function deleteRole(id, name) {
  const message = `Bạn có chắc chắn muốn xóa vai trò "${name}" không?\n\nLưu ý: Nếu vai trò có người dùng, bạn không thể xóa!`;
  
  if (confirm(message)) {
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
</script>
@endsection
