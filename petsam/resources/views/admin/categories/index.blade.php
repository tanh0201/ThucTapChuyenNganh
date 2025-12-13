@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Danh Mục')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Danh Mục</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-folder"></i> Quản Lý Danh Mục
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
      <i class="fa fa-plus"></i> Thêm Danh Mục
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

<!-- Categories Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Danh Mục ({{ $categories->total() }} danh mục)
    </h6>
  </div>
  <div class="card-body">
    @if($categories->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
          <thead style="background-color: #2e59d9; border-color: #1a3a70;">
            <tr>
              <th style="color: white; text-align: center; width: 60px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">STT</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Tên Danh Mục</th>
              <th style="color: white; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Mô Tả</th>
              <th style="color: white; text-align: center; width: 100px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Sản Phẩm</th>
              <th style="color: white; text-align: center; width: 100px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Trạng Thái</th>
              <th style="color: white; text-align: center; width: 160px; border-color: #1a3a70; font-weight: 700; letter-spacing: 0.5px;">Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $index => $category)
              <tr style="border-color: #dee2e6;">
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                <td style="color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">{{ $category->name }}</td>
                <td style="color: #333; padding: 12px; border-color: #dee2e6;">
                  @if($category->description)
                    {{ Str::limit($category->description, 50, '...') }}
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td style="text-align: center; color: #000; font-weight: 600; padding: 12px; border-color: #dee2e6;">
                  <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #17a2b8; border-radius: 12px;">{{ $category->products()->count() }}</span>
                </td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  @if($category->status === 'active')
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #28a745; border-radius: 12px;">
                      Hoạt Động
                    </span>
                  @else
                    <span style="display: inline-block; padding: 8px 12px; font-size: 13px; color: white; font-weight: 700; background-color: #dc3545; border-radius: 12px;">
                      Không Hoạt Động
                    </span>
                  @endif
                </td>
                <td style="text-align: center; padding: 12px; border-color: #dee2e6;">
                  <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                    <i class="fa fa-edit"></i>
                  </a>
                  <button class="btn btn-sm btn-danger" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')" title="Xóa">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có danh mục nào. <a href="{{ route('admin.categories.create') }}" class="font-weight-bold">Thêm danh mục mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Delete Category
function deleteCategory(id, name) {
  const message = `Bạn có chắc chắn muốn xóa danh mục "${name}" không?\n\nLưu ý: Nếu danh mục có sản phẩm, bạn không thể xóa!`;
  
  if (confirm(message)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/categories/${id}`;
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
