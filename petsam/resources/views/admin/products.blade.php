@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Sản Phẩm')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Sản Phẩm</li>
</ol>
@endsection

@section('content')

<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-shopping-bag"></i> Quản Lý Sản Phẩm
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <button class="btn btn-primary" onclick="showAddForm()">
      <i class="fa fa-plus"></i> Thêm Sản Phẩm
    </button>
  </div>
</div>


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
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif


<div id="formContainer" class="card shadow mb-4" style="display: none; background-color: #ffffff; z-index: 10;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" id="formTitle" style="color: white;">
      <i class="fa fa-plus"></i> Thêm Sản Phẩm Mới
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <form id="productForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="productId" name="product_id">
      <input type="hidden" id="formMethod" name="_method" value="POST">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label" style="color: #333333;">
            <strong>Tên Sản Phẩm <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="Nhập tên sản phẩm"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 required>
          @error('name')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>


        <div class="col-md-6 mb-3">
          <label for="category_id" class="form-label" style="color: #333333;">
            <strong>Danh Mục <span class="text-danger">*</span></strong>
          </label>
          <select class="form-control @error('category_id') is-invalid @enderror" 
                  id="category_id" 
                  name="category_id" 
                  style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                  required>
            <option value="">-- Chọn danh mục --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="price" class="form-label" style="color: #333333;">
            <strong>Giá (₫) <span class="text-danger">*</span></strong>
          </label>
          <input type="number" 
                 class="form-control @error('price') is-invalid @enderror" 
                 id="price" 
                 name="price" 
                 placeholder="0"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 min="0"
                 required>
          @error('price')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label for="stock" class="form-label" style="color: #333333;">
            <strong>Số Lượng <span class="text-danger">*</span></strong>
          </label>
          <input type="number" 
                 class="form-control @error('stock') is-invalid @enderror" 
                 id="stock" 
                 name="stock" 
                 placeholder="0"
                 style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
                 min="0"
                 required>
          @error('stock')
            <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4 mb-3">
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

      
      <div class="mb-3">
        <label for="description" class="form-label" style="color: #333333;">
          <strong>Mô Tả</strong>
        </label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" 
                  name="description" 
                  rows="3" 
                  placeholder="Nhập mô tả sản phẩm"
                  style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"></textarea>
        @error('description')
          <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="image" class="form-label" style="color: #333333;">
          <strong>Ảnh Sản Phẩm</strong>
        </label>
        <input type="file" 
               class="form-control @error('image') is-invalid @enderror" 
               id="image" 
               name="image" 
               accept="image/*"
               style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;">
        <small class="form-text" style="color: #666666;">Định dạng: JPEG, PNG, JPG, GIF</small>
        <div id="imagePreview" class="mt-2"></div>
        @error('image')
          <div class="invalid-feedback d-block" style="color: #dc3545;">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
          <i class="fa fa-save"></i> Lưu Sản Phẩm
        </button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="hideForm()">
          <i class="fa fa-times"></i> Hủy
        </button>
      </div>
    </form>
  </div>
</div>
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Sản Phẩm
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    @if($products->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="productsTable" style="background-color: #ffffff;">
          <thead style="background-color: #4e73df; border-bottom: 2px solid #dee2e6;">
            <tr>
              <th style="padding: 1rem; color: #ffffff;"><strong>STT</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Ảnh</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Tên Sản Phẩm</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Danh Mục</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Giá</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Số Lượng</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Trạng Thái</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Hành Động</strong></th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
              <tr id="product-row-{{ $product->id }}" style="border-bottom: 1px solid #dee2e6; background-color: #ffffff;">
                <td style="padding: 1rem; color: #333333;">
                  <strong>{{ $loop->iteration }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @if(!empty($product->image) && file_exists(public_path('storage/' . $product->image)))
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         style="height:45px; width: 45px; object-fit: cover; border-radius: 4px;">
                  @else
                    <span class="badge badge-secondary" style="background-color: #858796; color: white; font-size: 12px; padding: 6px 10px;">Ảnh</span>
                  @endif
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <strong class="d-block">{{ $product->name }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <span class="badge badge-primary" style="background-color: #4e73df; color: white; font-size: 12px; padding: 6px 10px;">{{ $product->category->name }}</span>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <strong style="color: #f6c23e; font-size: 14px;">{{ number_format($product->price, 0, ',', '.') }}₫</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <span class="badge badge-pill" style="background-color: {{ $product->stock > 10 ? '#1cc88a' : ($product->stock > 0 ? '#ffc107' : '#e74c3c') }}; color: #fff; font-size: 12px; padding: 6px 10px;">
                    {{ $product->stock }}
                  </span>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @if($product->status === 'active')
                    <span class="badge badge-success" style="background-color: #1cc88a; color: white; font-size: 12px; padding: 6px 10px;">Hoạt Động</span>
                  @else
                    <span class="badge badge-secondary" style="background-color: #e74c3c; color: white; font-size: 12px; padding: 6px 10px;">Không Hoạt Động</span>
                  @endif
                </td>
                <td style="padding: 1rem;">
                  <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-primary edit-btn" 
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" 
                            data-category-id="{{ $product->category_id }}" 
                            data-price="{{ $product->price }}" 
                            data-stock="{{ $product->stock }}" 
                            data-status="{{ $product->status }}" 
                            data-description="{{ $product->description ?? '' }}" 
                            data-image="{{ $product->image ?? '' }}"
                            title="Sửa">
                      <i class="fa fa-edit"></i> Sửa
                    </button>
                    <button class="btn btn-danger delete-btn" 
                            data-id="{{ $product->id }}"
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
        {{ $products->links() }}
      </div>
    @else
      <div class="text-center py-5" style="background-color: #ffffff;">
        <i class="fa fa-inbox fa-3x mb-3" style="color: #bbb;"></i>
        <p style="color: #666666; font-size: 16px;">Chưa có sản phẩm nào. <a href="#" onclick="showAddForm()" class="font-weight-bold" style="color: #4e73df;">Thêm sản phẩm mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Get all categories (for form)
const categoriesData = {!! json_encode($categories) !!};

// Show Add Form
function showAddForm() {
  resetForm();
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-plus"></i> Thêm Sản Phẩm Mới';
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Tạo Sản Phẩm';
  document.getElementById('productForm').action = '/admin/products';
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
  document.getElementById('productForm').reset();
  document.getElementById('productId').value = '';
  document.getElementById('imagePreview').innerHTML = '';
}

// Edit Product - Data passed from server via data attributes
function editProduct(id, name, categoryId, price, stock, status, description, image) {
  // Populate form
  document.getElementById('name').value = name;
  document.getElementById('category_id').value = categoryId;
  document.getElementById('price').value = price;
  document.getElementById('stock').value = stock;
  document.getElementById('status').value = status;
  document.getElementById('description').value = description;
  document.getElementById('productId').value = id;

  // Show image preview
  if (image && image.trim()) {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = `
      <div class="position-relative d-inline-block">
        <img src="/storage/${image}" alt="Preview" style="max-width: 150px; border-radius: 4px;">
        <small class="d-block text-muted mt-1">Chọn ảnh mới để thay thế</small>
      </div>
    `;
  }

  // Update form
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-edit"></i> Sửa Sản Phẩm: ' + name;
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Cập Nhật Sản Phẩm';
  document.getElementById('productForm').action = `/admin/products/${id}`;
  document.getElementById('formMethod').value = 'PATCH';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete Product
function deleteProduct(id) {
  if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
    // Create and submit form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/products/${id}`;
    form.style.display = 'none';
    
    // Add CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    form.innerHTML = `
      <input type="hidden" name="_token" value="${csrfToken}">
      <input type="hidden" name="_method" value="DELETE">
    `;
    
    document.body.appendChild(form);
    form.submit();
  }
}

// Image Preview
document.getElementById('image').addEventListener('change', function(e) {
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('imagePreview').innerHTML = `
        <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 4px;">
      `;
    };
    reader.readAsDataURL(this.files[0]);
  }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
  // Event listeners for edit buttons
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const data = {
        id: this.getAttribute('data-id'),
        name: this.getAttribute('data-name'),
        categoryId: this.getAttribute('data-category-id'),
        price: this.getAttribute('data-price'),
        stock: this.getAttribute('data-stock'),
        status: this.getAttribute('data-status'),
        description: this.getAttribute('data-description'),
        image: this.getAttribute('data-image')
      };
      editProduct(data.id, data.name, data.categoryId, data.price, data.stock, data.status, data.description, data.image);
    });
  });

  // Event listeners for delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deleteProduct(id);
    });
  });
});
</script>
@endsection
