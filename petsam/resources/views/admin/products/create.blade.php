@extends('admin.layout.base')

@section('title', 'PetSam Admin - Thêm Sản Phẩm Mới')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.products.index') }}">Sản Phẩm</a>
  </li>
  <li class="breadcrumb-item active">Thêm Sản Phẩm Mới</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-plus"></i> Thêm Sản Phẩm Mới
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
  </div>
</div>

<!-- Form Container -->
<div class="card shadow">
  <div class="card-header py-3" style="background-color: #4e73df;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-shopping-bag"></i> Thông Tin Sản Phẩm
    </h6>
  </div>
  <div class="card-body">
    <!-- Error Messages -->
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
      @csrf

      <div class="row">
        <!-- Product Name -->
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">
            <strong>Tên Sản Phẩm <span class="text-danger">*</span></strong>
          </label>
          <input type="text" 
                 class="form-control @error('name') is-invalid @enderror" 
                 id="name" 
                 name="name" 
                 placeholder="Nhập tên sản phẩm"
                 value="{{ old('name') }}"
                 required>
          @error('name')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <!-- Category -->
        <div class="col-md-6 mb-3">
          <label for="category_id" class="form-label">
            <strong>Danh Mục <span class="text-danger">*</span></strong>
          </label>
          <select class="form-control @error('category_id') is-invalid @enderror" 
                  id="category_id" 
                  name="category_id" 
                  required>
            <option value="">-- Chọn danh mục --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <!-- Price and Stock -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="price" class="form-label">
            <strong>Giá Sản Phẩm (VNĐ) <span class="text-danger">*</span></strong>
          </label>
          <input type="number" 
                 class="form-control @error('price') is-invalid @enderror" 
                 id="price" 
                 name="price" 
                 placeholder="0"
                 value="{{ old('price') }}"
                 min="0"
                 required>
          @error('price')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label for="stock" class="form-label">
            <strong>Số Lượng Tồn Kho <span class="text-danger">*</span></strong>
          </label>
          <input type="number" 
                 class="form-control @error('stock') is-invalid @enderror" 
                 id="stock" 
                 name="stock" 
                 placeholder="0"
                 value="{{ old('stock') }}"
                 min="0"
                 required>
          @error('stock')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <!-- Status -->
      <div class="mb-3">
        <label for="status" class="form-label">
          <strong>Trạng Thái <span class="text-danger">*</span></strong>
        </label>
        <select class="form-control @error('status') is-invalid @enderror" 
                id="status" 
                name="status" 
                required>
          <option value="">-- Chọn trạng thái --</option>
          <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
            <i class="fa fa-check-circle"></i> Hoạt Động
          </option>
          <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
            <i class="fa fa-ban"></i> Không Hoạt Động
          </option>
        </select>
        @error('status')
          <div class="invalid-feedback d-block">
            <i class="fa fa-times-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Description -->
      <div class="mb-3">
        <label for="description" class="form-label">
          <strong>Mô Tả Sản Phẩm</strong>
        </label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" 
                  name="description" 
                  rows="5" 
                  placeholder="Nhập mô tả chi tiết về sản phẩm">{{ old('description') }}</textarea>
        @error('description')
          <div class="invalid-feedback d-block">
            <i class="fa fa-times-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Image Upload -->
      <div class="mb-4">
        <label for="image" class="form-label">
          <strong>Ảnh Sản Phẩm</strong>
        </label>
        <div class="custom-file">
          <input type="file" 
                 class="custom-file-input @error('image') is-invalid @enderror" 
                 id="image" 
                 name="image" 
                 accept="image/jpeg,image/png,image/jpg,image/gif"
                 onchange="previewImage(this)">
          <label class="custom-file-label" for="image" id="imageLabel">
            Chọn ảnh...
          </label>
          @error('image')
            <div class="invalid-feedback d-block">
              <i class="fa fa-times-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
        <small class="form-text text-muted d-block mt-2">
          <i class="fa fa-info-circle"></i> Định dạng: JPEG, PNG, JPG, GIF (Max: 5MB)
        </small>

        <!-- Image Preview -->
        <div id="imagePreviewContainer" class="mt-3" style="display: none;">
          <div class="position-relative d-inline-block">
            <img id="imagePreviewImg" src="" alt="Preview" style="max-width: 300px; max-height: 300px; border-radius: 4px; border: 2px solid #dee2e6;">
            <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="clearImage()">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4 pt-3 border-top">
        <button type="submit" class="btn btn-success btn-lg">
          <i class="fa fa-save"></i> Tạo Sản Phẩm
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
          <i class="fa fa-times"></i> Hủy
        </a>
      </div>
    </form>
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Image Preview
function previewImage(input) {
  const imageLabel = document.getElementById('imageLabel');
  const imagePreview = document.getElementById('imagePreviewContainer');
  const imagePreviewImg = document.getElementById('imagePreviewImg');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imagePreviewImg.src = e.target.result;
      imagePreview.style.display = 'block';
      
      // Update label
      imageLabel.textContent = input.files[0].name;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// Clear Image
function clearImage() {
  const imageInput = document.getElementById('image');
  const imagePreview = document.getElementById('imagePreviewContainer');
  const imageLabel = document.getElementById('imageLabel');

  imageInput.value = '';
  imagePreview.style.display = 'none';
  imageLabel.textContent = 'Chọn ảnh...';
}

// Form Validation
document.getElementById('createForm').addEventListener('submit', function(e) {
  const name = document.getElementById('name').value.trim();
  const categoryId = document.getElementById('category_id').value;
  const price = document.getElementById('price').value;
  const stock = document.getElementById('stock').value;
  const status = document.getElementById('status').value;

  if (!name) {
    e.preventDefault();
    alert('Vui lòng nhập tên sản phẩm');
    return false;
  }

  if (!categoryId) {
    e.preventDefault();
    alert('Vui lòng chọn danh mục');
    return false;
  }

  if (!price || price < 0) {
    e.preventDefault();
    alert('Vui lòng nhập giá hợp lệ');
    return false;
  }

  if (!stock || stock < 0) {
    e.preventDefault();
    alert('Vui lòng nhập số lượng hợp lệ');
    return false;
  }

  if (!status) {
    e.preventDefault();
    alert('Vui lòng chọn trạng thái');
    return false;
  }
});

// Custom file input label
document.getElementById('image').addEventListener('change', function(e) {
  const fileName = e.target.files[0]?.name || 'Chọn ảnh...';
  document.getElementById('imageLabel').textContent = fileName;
});
</script>
@endsection
