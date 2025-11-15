@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Danh Mục')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
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
    <button class="btn btn-primary" onclick="showAddForm()">
      <i class="fa fa-plus"></i> Thêm Danh Mục
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
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Add/Edit Form Container -->
<div id="formContainer" class="card shadow mb-4" style="display: none; background-color: #ffffff; z-index: 10;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" id="formTitle" style="color: white;">
      <i class="fa fa-plus"></i> Thêm Danh Mục Mới
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <form id="categoryForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="categoryId" name="category_id">
      <input type="hidden" id="formMethod" name="_method" value="POST">

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
                 required>
          @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
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
            <option value="active">Hoạt Động</option>
            <option value="inactive">Không Hoạt Động</option>
          </select>
          @error('status')
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
                  rows="3" 
                  placeholder="Nhập mô tả danh mục"></textarea>
        @error('description')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <!-- Image -->
      <div class="mb-3">
        <label for="image" class="form-label">
          <strong>Ảnh Danh Mục</strong>
        </label>
        <input type="file" 
               class="form-control @error('image') is-invalid @enderror" 
               id="image" 
               name="image" 
               accept="image/*">
        <small class="form-text text-muted">Định dạng: JPEG, PNG, JPG, GIF</small>
        <div id="imagePreview" class="mt-2"></div>
        @error('image')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <!-- Form Actions -->
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
          <i class="fa fa-save"></i> Lưu Danh Mục
        </button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="hideForm()">
          <i class="fa fa-times"></i> Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Categories Accordion -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Danh Mục
    </h6>
  </div>
  <div class="card-body" style="background-color: #fff; padding: 0;">
    @if($categories->count() > 0)
      <div class="accordion" id="categoriesAccordion">
        @foreach($categories as $index => $category)
          <div class="card" style="border: none; border-bottom: 1px solid #dee2e6;">
            <div class="card-header" id="heading{{ $category->id }}" style="background-color: #f8f9fa; padding: 0;">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#collapse{{ $category->id }}" 
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-controls="collapse{{ $category->id }}"
                        style="text-decoration: none; padding: 1rem; font-size: 1rem;">
                  <i class="fa fa-chevron-down"></i>
                  <strong style="margin-left: 10px; color: #333;">{{ $category->name }}</strong>
                  <span class="badge badge-{{ $category->status === 'active' ? 'success' : 'danger' }} ml-2">
                    {{ $category->status === 'active' ? 'Hoạt Động' : 'Không Hoạt Động' }}
                  </span>
                  <span class="float-right text-muted" style="font-size: 0.9rem;">
                    <i class="fa fa-folder"></i> {{ $category->products()->count() }} sản phẩm
                  </span>
                </button>
              </h2>
            </div>

            <div id="collapse{{ $category->id }}" 
                 class="collapse {{ $index === 0 ? 'show' : '' }}" 
                 aria-labelledby="heading{{ $category->id }}" 
                 data-parent="#categoriesAccordion">
              <div class="card-body" style="background-color: #f8f9fa; padding: 1.5rem;">
                <!-- Category Info -->
                <div class="row mb-3">
                  <div class="col-md-8">
                    <!-- Description -->
                    <div class="mb-3">
                      <small class="text-muted d-block"><strong>Mô Tả:</strong></small>
                      <p class="text-dark">{{ $category->description ?? 'Chưa có mô tả' }}</p>
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                      <small class="text-muted d-block"><strong>Slug:</strong></small>
                      <code class="bg-light p-2" style="border-radius: 4px;">{{ $category->slug }}</code>
                    </div>

                    <!-- Created At -->
                    <div class="mb-3">
                      <small class="text-muted d-block"><strong>Tạo ngày:</strong></small>
                      <p class="text-dark">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                  </div>

                  <!-- Category Image -->
                  <div class="col-md-4">
                    @if(!empty($category->image) && file_exists(public_path('storage/' . $category->image)))
                      <img src="{{ asset('storage/' . $category->image) }}" 
                           alt="{{ $category->name }}" 
                           style="max-width: 100%; border-radius: 4px;">
                    @else
                      <div style="background-color: #e9ecef; padding: 2rem; border-radius: 4px; text-align: center;">
                        <i class="fa fa-image fa-3x text-muted"></i>
                        <p class="text-muted mt-2">Không có ảnh</p>
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Products List -->
                @if($category->products()->count() > 0)
                  <hr>
                  <div class="mt-3">
                    <strong class="text-dark d-block mb-2">
                      <i class="fa fa-shopping-bag"></i> Sản phẩm trong danh mục:
                    </strong>
                    <div class="table-responsive">
                      <table class="table table-sm table-striped">
                        <thead style="background-color: #e9ecef;">
                          <tr>
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($category->products()->limit(5)->get() as $product)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $product->name }}</td>
                              <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                              <td>
                                <span class="badge badge-info">{{ $product->stock }}</span>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    @if($category->products()->count() > 5)
                      <small class="text-muted">
                        ... và {{ $category->products()->count() - 5 }} sản phẩm khác
                      </small>
                    @endif
                  </div>
                @else
                  <hr>
                  <p class="text-muted mb-0"><i class="fa fa-info-circle"></i> Danh mục này chưa có sản phẩm nào</p>
                @endif

                <!-- Action Buttons -->
                <hr>
                <div class="mt-3">
                  <button class="btn btn-sm btn-primary edit-btn" 
                          data-id="{{ $category->id }}"
                          data-name="{{ $category->name }}" 
                          data-description="{{ $category->description ?? '' }}" 
                          data-status="{{ $category->status }}" 
                          data-image="{{ $category->image ?? '' }}">
                    <i class="fa fa-edit"></i> Sửa
                  </button>
                  <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}">
                    <i class="fa fa-trash"></i> Xóa
                  </button>
                  <a href="/admin/products?category_id={{ $category->id }}" class="btn btn-sm btn-info">
                    <i class="fa fa-shopping-bag"></i> Xem Sản Phẩm
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4 p-3">
        {{ $categories->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
        <p class="text-muted">Chưa có danh mục nào. <a href="#" onclick="showAddForm()" class="font-weight-bold">Thêm danh mục mới</a></p>
      </div>
    @endif
  </div>
</div>

@endsection

@section('additional-js')
<script>
// Show Add Form
function showAddForm() {
  resetForm();
  document.getElementById('formContainer').style.display = 'block';
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-plus"></i> Thêm Danh Mục Mới';
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Tạo Danh Mục';
  document.getElementById('categoryForm').action = '/admin/categories';
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
  document.getElementById('categoryForm').reset();
  document.getElementById('categoryId').value = '';
  document.getElementById('imagePreview').innerHTML = '';
}

// Edit Category
function editCategory(id, name, description, status, image) {
  // Populate form
  document.getElementById('name').value = name;
  document.getElementById('description').value = description;
  document.getElementById('status').value = status;
  document.getElementById('categoryId').value = id;

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
  document.getElementById('formTitle').innerHTML = '<i class="fa fa-edit"></i> Sửa Danh Mục: ' + name;
  document.getElementById('submitBtn').innerHTML = '<i class="fa fa-save"></i> Cập Nhật Danh Mục';
  document.getElementById('categoryForm').action = `/admin/categories/${id}`;
  document.getElementById('formMethod').value = 'PATCH';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete Category
function deleteCategory(id) {
  if (confirm('Bạn có chắc chắn muốn xóa danh mục này?\n\nLưu ý: Nếu danh mục có sản phẩm, bạn không thể xóa!')) {
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
        description: this.getAttribute('data-description'),
        status: this.getAttribute('data-status'),
        image: this.getAttribute('data-image')
      };
      editCategory(data.id, data.name, data.description, data.status, data.image);
    });
  });

  // Event listeners for delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deleteCategory(id);
    });
  });
});
</script>
@endsection
