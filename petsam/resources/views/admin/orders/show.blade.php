@extends('admin.layout.base')

@section('title', 'PetSam Admin - Chi Tiết Đơn Hàng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="/admin/orders">Đơn Hàng</a>
  </li>
  <li class="breadcrumb-item active">{{ $order->order_number }}</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-file-text"></i> Chi Tiết Đơn Hàng
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="/admin/orders" class="btn btn-info">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
  </div>
</div>

<!-- Flash Messages -->
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Order Header Info -->
<div class="row mb-4">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-info-circle"></i> Thông Tin Đơn Hàng
        </h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <small class="text-muted d-block"><strong>Mã Đơn Hàng:</strong></small>
          <code style="background-color: #f0f0f0; padding: 0.5rem; border-radius: 4px; font-size: 0.9rem;">
            {{ $order->order_number }}
          </code>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Trạng Thái:</strong></small>
          <div>
            @switch($order->status)
              @case('pending')
                <span class="badge badge-danger badge-lg">Chờ Xử Lý</span>
                @break
              @case('processing')
                <span class="badge badge-warning badge-lg">Đang Xử Lý</span>
                @break
              @case('completed')
                <span class="badge badge-success badge-lg">Hoàn Thành</span>
                @break
              @case('cancelled')
                <span class="badge badge-secondary badge-lg">Đã Hủy</span>
                @break
            @endswitch
          </div>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Phương Thức Thanh Toán:</strong></small>
          <p class="mb-0">
            @switch($order->payment_method)
              @case('cash')
                <i class="fa fa-money"></i> Tiền Mặt
                @break
              @case('bank_transfer')
                <i class="fa fa-bank"></i> Chuyển Khoản Ngân Hàng
                @break
              @case('card')
                <i class="fa fa-credit-card"></i> Thẻ Tín Dụng
                @break
              @default
                {{ $order->payment_method }}
            @endswitch
          </p>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Ngày Đặt Hàng:</strong></small>
          <p class="mb-0">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        </div>

        <hr>

        <div class="mb-0">
          <button class="btn btn-primary btn-sm" id="updateStatusBtn">
            <i class="fa fa-edit"></i> Cập Nhật Trạng Thái
          </button>
          <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $order->id }}">
            <i class="fa fa-trash"></i> Xóa Đơn Hàng
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header" style="background-color: #1cc88a; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-user"></i> Thông Tin Khách Hàng
        </h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <small class="text-muted d-block"><strong>Tên Khách Hàng:</strong></small>
          <p class="mb-0">{{ $order->user->name }}</p>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Email:</strong></small>
          <p class="mb-0">
            <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
          </p>
        </div>

        <div class="mb-3">
          <small class="text-muted d-block"><strong>Số Điện Thoại:</strong></small>
          <p class="mb-0">
            {{ $order->user->phone ?? 'Chưa cập nhật' }}
          </p>
        </div>

        <div class="mb-0">
          <small class="text-muted d-block"><strong>Địa Chỉ:</strong></small>
          <p class="mb-0">{{ $order->user->address ?? 'Chưa cập nhật' }}</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Order Items -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-shopping-bag"></i> Chi Tiết Sản Phẩm ({{ $order->items()->count() }} sản phẩm)
    </h6>
  </div>
  <div class="card-body" style="background-color: #fff; padding: 0;">
    <div class="table-responsive">
      <table class="table table-hover mb-0" style="background-color: #fff;">
        <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
          <tr>
            <th style="padding: 1rem;">STT</th>
            <th style="padding: 1rem;">Tên Sản Phẩm</th>
            <th style="padding: 1rem;">Danh Mục</th>
            <th style="padding: 1rem;">Đơn Giá</th>
            <th style="padding: 1rem;">Số Lượng</th>
            <th style="padding: 1rem;">Thành Tiền</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->items as $item)
            <tr style="border-bottom: 1px solid #dee2e6;">
              <td style="padding: 1rem;">{{ $loop->iteration }}</td>
              <td style="padding: 1rem;">
                <strong>{{ $item->product->name }}</strong>
              </td>
              <td style="padding: 1rem;">
                <span class="badge badge-light">{{ $item->product->category->name }}</span>
              </td>
              <td style="padding: 1rem;">
                <strong>{{ number_format($item->price, 0, ',', '.') }}₫</strong>
              </td>
              <td style="padding: 1rem; text-align: center;">
                <span class="badge badge-info badge-pill">{{ $item->quantity }}</span>
              </td>
              <td style="padding: 1rem;">
                <strong class="text-success">
                  {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                </strong>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Order Summary -->
<div class="row mb-4">
  <div class="col-md-6 ml-auto">
    <div class="card shadow">
      <div class="card-header" style="background-color: #858796; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-calculator"></i> Tóm Tắt Đơn Hàng
        </h6>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span>Tổng Sản Phẩm:</span>
          <strong>{{ $order->items()->sum('quantity') }}</strong>
        </div>

        <div class="d-flex justify-content-between mb-2">
          <span>Giá Trị Hàng:</span>
          <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
        </div>

        <div class="d-flex justify-content-between mb-2">
          <span>Phí Vận Chuyển:</span>
          <strong>0₫</strong>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
          <strong class="text-lg">Tổng Cộng:</strong>
          <strong class="text-lg text-success">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Notes Section -->
@if($order->notes)
  <div class="card shadow">
    <div class="card-header" style="background-color: #f8f9fa;">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fa fa-sticky-note"></i> Ghi Chú
      </h6>
    </div>
    <div class="card-body">
      <p>{{ $order->notes }}</p>
    </div>
  </div>
@endif

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cập Nhật Trạng Thái Đơn Hàng</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form id="statusForm" method="POST" action="/admin/orders/{{ $order->id }}/status">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="form-group">
            <label for="newStatus"><strong>Trạng Thái Mới:</strong></label>
            <select class="form-control form-control-lg" id="newStatus" name="status" required>
              <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ Xử Lý</option>
              <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang Xử Lý</option>
              <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn Thành</option>
              <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã Hủy</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Cập Nhật
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('additional-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('updateStatusBtn').addEventListener('click', function() {
    $('#statusModal').modal('show');
  });

  // Delete button
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deleteOrder(id);
    });
  });
});

// Delete Order
function deleteOrder(id) {
  if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?\n\nHành động này không thể hoàn tác!')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/orders/${id}`;
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
