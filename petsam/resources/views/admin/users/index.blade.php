@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Người Dùng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
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
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
      <i class="fa fa-plus"></i> Thêm Người Dùng
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

<!-- Filter Section -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-filter"></i> Tìm Kiếm & Lọc
    </h6>
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline">
      <div class="form-group mr-3 mb-2">
        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, email, điện thoại..." 
               value="{{ request('search') }}">
      </div>
      <div class="form-group mr-3 mb-2">
        <select name="role" class="form-control">
          <option value="">-- Chọn vai trò --</option>
          <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Người Dùng</option>
          <option value="moderator" {{ request('role') === 'moderator' ? 'selected' : '' }}>Moderator</option>
        </select>
      </div>
      <div class="form-group mr-3 mb-2">
        <select name="status" class="form-control">
          <option value="">-- Chọn trạng thái --</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hoạt Động</option>
          <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Khóa</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mb-2">
        <i class="fa fa-search"></i> Tìm Kiếm
      </button>
      <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-2 ml-2">
        <i class="fa fa-times"></i> Xóa Lọc
      </a>
    </form>
  </div>
</div>

<!-- Users Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #2e59d9;">
    <h6 class="m-0 font-weight-bold text-white">
      <i class="fa fa-list"></i> Danh Sách Người Dùng ({{ $users->total() }} người dùng)
    </h6>
  </div>
  <div class="card-body">
    @if($users->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
          <thead style="background-color: #2e59d9; border-color: #1a3a70;">
            <tr>
              <th style="color: white; text-align: center; width: 60px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">STT</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Người Dùng</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Email</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Điện Thoại</th>
              <th style="color: white; text-align: center; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Vai Trò</th>
              <th style="color: white; text-align: center; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Trạng Thái</th>
              <th style="color: white; text-align: center; width: 200px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $index => $user)
              <tr style="border-color: #dee2e6;">
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td style="color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  {{ $user->name }}
                  @if(auth()->id() === $user->id)
                    <span class="badge badge-info ml-2" style="padding: 6px 10px; font-size: 12px; color: white;">Tôi</span>
                  @endif
                </td>
                <td style="color: #333; padding: 12px; border-color: #dee2e6;">{{ $user->email }}</td>
                <td style="color: #333; padding: 12px; border-color: #dee2e6;">{{ $user->phone ?? '-' }}</td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  @if($user->role === 'admin')
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #dc3545; border-radius: 12px;">
                      Admin
                    </span>
                  @elseif($user->role === 'moderator')
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #ffc107; border-radius: 12px;">
                      Moderator
                    </span>
                  @else
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #17a2b8; border-radius: 12px;">
                      User
                    </span>
                  @endif
                </td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  @if($user->status === 'active')
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #28a745; border-radius: 12px;">
                      Hoạt Động
                    </span>
                  @else
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #dc3545; border-radius: 12px;">
                      Khóa
                    </span>
                  @endif
                </td>
                <td style="text-align: center;">
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                    <i class="fa fa-edit"></i>
                  </a>
                  @if(auth()->id() !== $user->id)
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'danger' : 'success' }}" 
                              title="{{ $user->status === 'active' ? 'Khóa' : 'Kích Hoạt' }}">
                        <i class="fa fa-{{ $user->status === 'active' ? 'lock' : 'unlock' }}"></i>
                      </button>
                    </form>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" title="Xóa">
                      <i class="fa fa-trash"></i>
                    </button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-users fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có người dùng nào. <a href="{{ route('admin.users.create') }}" class="font-weight-bold">Thêm người dùng mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Delete User
function deleteUser(id, name) {
  const message = `Bạn có chắc chắn muốn xóa người dùng "${name}" không?`;
  
  if (confirm(message)) {
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
</script>
@endsection
