@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Quyền Hạn')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Quyền Hạn</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-key"></i> Quản Lý Quyền Hạn
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
      <i class="fa fa-plus"></i> Thêm Quyền
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

<!-- Permissions Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #2e59d9;">
    <h6 class="m-0 font-weight-bold text-white">
      <i class="fa fa-list"></i> Danh Sách Quyền Hạn ({{ $permissions->total() }} quyền)
    </h6>
  </div>
  <div class="card-body">
    @if($permissions->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 permission-table">
          <thead style="background-color: #2e59d9; border-color: #1a3a70;">
            <tr>
              <th style="color: white; text-align: center; width: 60px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">STT</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Quyền</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Hiển Thị</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Mô Tả</th>
              <th style="color: white; text-align: center; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Vai Trò</th>
              <th style="color: white; text-align: center; width: 180px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $index => $permission)
              <tr style="border-color: #dee2e6;">
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}</td>
                <td style="color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  <i class="fa fa-key"></i> {{ $permission->name }}
                </td>
                <td style="color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">{{ $permission->display_name }}</td>
                <td style="color: #333; padding: 12px; border-color: #dee2e6;">
                  <span class="description-column" title="{{ $permission->description ?? '(Không có)' }}">
                    {{ $permission->description ?? '(Không có)' }}
                  </span>
                </td>
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  <span class="badge-roles" title="Số vai trò">
                    <i class="fa fa-users"></i> {{ $permission->roles->count() }} vai trò
                  </span>
                </td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  <div class="btn-group-actions">
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                      <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="deletePermission({{ $permission->id }}, '{{ $permission->display_name }}')" title="Xóa">
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
        {{ $permissions->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-key fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có quyền nào. <a href="{{ route('admin.permissions.create') }}" class="font-weight-bold">Thêm quyền mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<style>
  .permission-table tbody tr {
    transition: background-color 0.3s ease;
  }

  .permission-table tbody tr:hover {
    background-color: #f5f5f5;
  }

  .badge-roles {
    display: inline-block;
    padding: 8px 12px;
    font-size: 12px;
    color: white;
    font-weight: 600;
    background-color: #6c757d;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .badge-roles:hover {
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

  .description-column {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>

<script>
// Delete Permission
function deletePermission(id, name) {
  const message = `Bạn có chắc chắn muốn xóa quyền "${name}" không?\n\nLưu ý: Nếu quyền đã được gán cho vai trò, bạn không thể xóa!`;
  
  if (confirm(message)) {
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
</script>
@endsection
