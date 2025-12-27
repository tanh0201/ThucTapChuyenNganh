@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Sản Phẩm')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Sản Phẩm</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-shopping-bag"></i> Quản Lý Sản Phẩm
      @if($selectedCategory)
        <small class="text-muted">- {{ $categories->find($selectedCategory)->name ?? '' }}</small>
      @endif
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
      <i class="fa fa-plus"></i> Thêm Sản Phẩm
    </a>
    @if($selectedCategory)
      <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fa fa-times"></i> Xóa Lọc
      </a>
    @endif
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

<!-- Products List -->
<div class="card shadow">
  <div class="card-header py-3" style="background-color: #f8f9fa; border-bottom: 3px solid #2e59d9;">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h6 class="m-0 font-weight-bold text-primary">
          <i class="fa fa-list"></i> Danh Sách Sản Phẩm ({{ $products->total() }} sản phẩm)
        </h6>
      </div>
      <div class="col-md-4 text-right">
        <form method="GET" action="{{ route('admin.products.index') }}" style="display: inline-block;">
          <select name="category_id" class="form-control form-control-sm" style="width: auto; display: inline-block;" onchange="this.form.submit();">
            <option value="">-- Tất cả danh mục --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </form>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    @if($products->count() > 0)
      <div class="table-responsive">
        <table class="table mb-0" style="font-size: 14px;">
          <thead>
            <tr style="background-color: #2e59d9; color: white;">
              <th style="width: 5%; padding: 15px 12px; font-weight: 600; color: white; border: none;">STT</th>
              <th style="width: 30%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Tên Sản Phẩm</th>
              <th style="width: 12%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Danh Mục</th>
              <th style="width: 13%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: right;">Giá (VNĐ)</th>
              <th style="width: 10%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: center;">Tồn Kho</th>
              <th style="width: 10%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Cảnh Báo</th>
              <th style="width: 12%; padding: 15px 12px; font-weight: 600; color: white; border: none;">Trạng Thái</th>
              <th style="width: 18%; padding: 15px 12px; font-weight: 600; color: white; border: none; text-align: center;">Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $index => $product)
              <tr style="border-bottom: 1px solid #e3e6f0; background-color: #ffffff;">
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <strong>{{ ($products->currentPage() - 1) * 15 + $loop->iteration }}</strong>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <div class="d-flex align-items-center">
                  @if(!empty($product->image) && file_exists(public_path($product->image)))
                      <img id="currentImage" src="{{ asset($product->image) }}" 
                      alt="{{ $product->name }}" 
                           style="width: 45px; height: 45px; border-radius: 4px; margin-right: 10px; object-fit: cover; border: 1px solid #dee2e6;">
                    @else
                      <div style="width: 45px; height: 45px; background-color: #e9ecef; border-radius: 4px; margin-right: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid #dee2e6;">
                        <i class="fa fa-image text-muted"></i>
                      </div>
                    @endif
                    <div>
                      <strong style="color: #2c3e50; font-size: 14px; display: block;">{{ $product->name }}</strong>
                      <small class="text-muted" style="display: block; margin-top: 3px;">{{ Illuminate\Support\Str::limit($product->description, 45) }}</small>
                    </div>
                  </div>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: #36b9cc; color: white;">{{ $product->category->name }}</span>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: right;">
                  <strong style="font-size: 14px;">{{ number_format($product->price, 0, ',', '.') }}</strong>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: center;">
                  <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: {{ $product->stock > 0 ? '#1cc88a' : '#e74c3c' }}; color: white;">
                    {{ $product->stock }}
                  </span>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  @if ($product->stock <= 0)
                    <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: #e74c3c; color: white;">
                      <i class="fa fa-exclamation-circle me-1"></i>Hết Hàng
                    </span>
                  @elseif ($product->stock <= ($product->low_stock_threshold ?? 10))
                    <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: #f6c23e; color: white;">
                      <i class="fa fa-exclamation-triangle me-1"></i>Sắp Hết
                    </span>
                  @else
                    <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: #1cc88a; color: white;">
                      <i class="fa fa-check-circle me-1"></i>Còn Hàng
                    </span>
                  @endif
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none;">
                  <span class="badge" style="padding: 6px 10px; font-size: 12px; font-weight: 600; background-color: {{ $product->status === 'active' ? '#1cc88a' : '#e74c3c' }}; color: white;">
                    {{ $product->status === 'active' ? 'Hiển Thị' : 'Ẩn' }}
                  </span>
                </td>
                <td style="padding: 12px 12px; vertical-align: middle; color: #2c3e50; border: none; text-align: center;">
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning" title="Sửa" style="font-size: 12px; font-weight: 600; padding: 5px 8px;">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn {{ $product->status === 'active' ? 'btn-danger' : 'btn-success' }}" title="{{ $product->status === 'active' ? 'Ẩn' : 'Hiển thị' }}" style="font-size: 12px; font-weight: 600; padding: 5px 8px;">
                        <i class="fa {{ $product->status === 'active' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                      </button>
                    </form>
                    <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')" title="Xóa" style="font-size: 12px; font-weight: 600; padding: 5px 8px;">
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
      <div class="d-flex justify-content-center mt-4 p-3">
        {{ $products->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-shopping-bag fa-3x text-muted mb-3" style="display: block;"></i>
        <p class="text-muted">Chưa có sản phẩm nào.</p>
        <a href="/admin/products/create" class="btn btn-primary">
          <i class="fa fa-plus"></i> Thêm Sản Phẩm Mới
        </a>
      </div>
    @endif
  </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
  <div class="col-md-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="text-primary font-weight-bold text-uppercase mb-1">
          Tổng Sản Phẩm
        </div>
        <div class="h3 mb-0">
          <strong>{{ $products->total() }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="text-success font-weight-bold text-uppercase mb-1">
          Sản Phẩm Hoạt Động
        </div>
        <div class="h3 mb-0">
          <strong>{{ $products->where('status', 'active')->count() }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="text-danger font-weight-bold text-uppercase mb-1">
          Sản Phẩm Không Hoạt Động
        </div>
        <div class="h3 mb-0">
          <strong>{{ $products->where('status', 'inactive')->count() }}</strong>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Delete Product
function deleteProduct(id, name) {
  const message = `Bạn có chắc chắn muốn xóa sản phẩm "${name}" không?`;
  
  if (confirm(message)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/products/${id}`;
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

// Highlight row on hover
document.addEventListener('DOMContentLoaded', function() {
  const rows = document.querySelectorAll('tbody tr');
  rows.forEach(row => {
    row.addEventListener('mouseenter', function() {
      this.style.backgroundColor = '#f8f9fa';
    });
    
    row.addEventListener('mouseleave', function() {
      this.style.backgroundColor = '#ffffff';
    });
  });
});
</script>
@endsection
