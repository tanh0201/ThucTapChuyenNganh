@extends('admin.layout.base')

@section('title', 'PetSam Admin - Sửa Danh Mục')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('admin.categories.index') }}">Danh Mục</a>
  </li>
  <li class="breadcrumb-item active">Sửa: {{ $category->name }}</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-edit"></i> Sửa Danh Mục: {{ $category->name }}
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
  </div>
</div>

<div class="row">
  <!-- Form Section -->
  <div class="col-lg-8">
    <div class="card shadow">
      <div class="card-header py-3" style="background-color: #4e73df;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-folder"></i> Thông Tin Danh Mục
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

        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
          </div>
        @endif

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
          @csrf
          @method('PUT')

          <div class="row">
            <!-- Category Name -->
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">
                <strong>Tên Danh Mục <span class="text-danger">*</span></strong>
              </label>
              <input type="text" 
                     class="form-control @error('name') is-invalid @enderror" 
                     id="name" 
                     name="name" 
                     placeholder="Nhập tên danh mục"
                     value="{{ old('name', $category->name) }}"
                     required>
              @error('name')
                <div class="invalid-feedback d-block">
                  <i class="fa fa-times-circle"></i> {{ $message }}
                </div>
              @enderror
            </div>

            <!-- Status -->
            <div class="col-md-6 mb-3">
              <label for="status" class="form-label">
                <strong>Trạng Thái <span class="text-danger">*</span></strong>
              </label>
              <select class="form-control @error('status') is-invalid @enderror" 
                      id="status" 
                      name="status" 
                      required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="active" {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>
                  <i class="fa fa-check-circle"></i> Hoạt Động
                </option>
                <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>
                  <i class="fa fa-ban"></i> Không Hoạt Động
                </option>
              </select>
              @error('status')
                <div class="invalid-feedback d-block">
                  <i class="fa fa-times-circle"></i> {{ $message }}
                </div>
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
                      rows="4" 
                      placeholder="Nhập mô tả chi tiết về danh mục">{{ old('description', $category->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback d-block">
                <i class="fa fa-times-circle"></i> {{ $message }}
              </div>
            @enderror
            <small class="form-text text-muted">Giới hạn 1000 ký tự</small>
          </div>

          <!-- Image Upload -->
          <div class="mb-4">
            <label for="image" class="form-label">
              <strong>Ảnh Danh Mục</strong>
            </label>
            <div class="custom-file">
              <input type="file" 
                     class="custom-file-input @error('image') is-invalid @enderror" 
                     id="image" 
                     name="image" 
                     accept="image/jpeg,image/png,image/jpg,image/gif"
                     onchange="previewImage(this)">
              <label class="custom-file-label" for="image" id="imageLabel">
                Chọn ảnh mới (tùy chọn)...
              </label>
              @error('image')
                <div class="invalid-feedback d-block">
                  <i class="fa fa-times-circle"></i> {{ $message }}
                </div>
              @enderror
            </div>
            <small class="form-text text-muted d-block mt-2">
              <i class="fa fa-info-circle"></i> Định dạng: JPEG, PNG, JPG, GIF (Max: 5MB) - Để trống nếu không thay đổi
            </small>
          </div>

          <!-- Form Actions -->
          <div class="form-group mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fa fa-save"></i> Cập Nhật Danh Mục
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-lg">
              <i class="fa fa-times"></i> Hủy
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Info Section -->
  <div class="col-lg-4">
    <!-- Current Image -->
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="background-color: #858796;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-image"></i> Ảnh Hiện Tại
        </h6>
      </div>
      <div class="card-body text-center">
        @if(!empty($category->image) && file_exists(public_path($category->image)))
          <img id="currentImage" src="{{ asset($category->image) }}" 
               alt="{{ $category->name }}" 
               style="max-width: 100%; border-radius: 4px; border: 2px solid #dee2e6;">
          <div id="imagePreviewContainer" style="display: none; margin-top: 15px;">
            <h6 class="mb-2">Ảnh Mới:</h6>
            <img id="imagePreviewImg" src="" alt="Preview" style="max-width: 100%; border-radius: 4px; border: 2px solid #28a745;">
            <button type="button" class="btn btn-sm btn-danger mt-2 w-100" onclick="clearImage()">
              <i class="fa fa-trash"></i> Hủy Thay Đổi
            </button>
          </div>
        @else
          <div style="background-color: #e9ecef; padding: 2rem; border-radius: 4px;">
            <i class="fa fa-image fa-3x text-muted"></i>
            <p class="text-muted mt-2">Chưa có ảnh</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Category Info -->
    <div class="card shadow">
      <div class="card-header py-3" style="background-color: #858796;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-info-circle"></i> Thông Tin Cơ Bản
        </h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <small class="text-muted d-block"><strong>Slug:</strong></small>
          <code class="bg-light p-2" style="border-radius: 4px;">{{ $category->slug }}</code>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Trạng Thái:</strong></small>
          <span class="badge badge-{{ $category->status === 'active' ? 'success' : 'danger' }}">
            {{ $category->status === 'active' ? 'Hoạt Động' : 'Không Hoạt Động' }}
          </span>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Số Sản Phẩm:</strong></small>
          <span class="badge badge-info">{{ $category->products()->count() }}</span>
        </div>

        <hr>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Tạo Ngày:</strong></small>
          <p class="text-dark mb-0">{{ $category->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Cập Nhật Lần Cuối:</strong></small>
          <p class="text-dark mb-0">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <hr>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-info btn-block btn-sm">
          <i class="fa fa-list"></i> Xem Danh Sách Danh Mục
        </a>
      </div>
    </div>
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
  const currentImage = document.getElementById('currentImage');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imagePreviewImg.src = e.target.result;
      imagePreview.style.display = 'block';
      
      if (currentImage) {
        currentImage.style.opacity = '0.5';
      }
      
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
  const currentImage = document.getElementById('currentImage');

  imageInput.value = '';
  imagePreview.style.display = 'none';
  imageLabel.textContent = 'Chọn ảnh mới (tùy chọn)...';
  
  if (currentImage) {
    currentImage.style.opacity = '1';
  }
}

// Form Validation
document.getElementById('editForm').addEventListener('submit', function(e) {
  const name = document.getElementById('name').value.trim();
  const status = document.getElementById('status').value;

  if (!name) {
    e.preventDefault();
    alert('Vui lòng nhập tên danh mục');
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
  const fileName = e.target.files[0]?.name || 'Chọn ảnh mới (tùy chọn)...';
  document.getElementById('imageLabel').textContent = fileName;
});
</script>
@endsection
