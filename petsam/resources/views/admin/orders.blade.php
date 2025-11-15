@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Đơn Hàng')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Đơn Hàng</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-shopping-cart"></i> Quản Lý Đơn Hàng
    </h2>
  </div>
  <div class="col-md-4 text-right">
    <a href="/admin" class="btn btn-info">
      <i class="fa fa-arrow-left"></i> Quay Lại
    </a>
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
    <i class="fa fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
@endif

<!-- Filter & Search Bar -->
<div class="card shadow mb-4">
  <div class="card-body">
    <form method="GET" action="/admin/orders" class="form-inline">
      <div class="form-group mr-3 mb-2">
        <label for="search" class="mr-2" style="color: #333333;"><strong>Tìm Kiếm:</strong></label>
        <input type="text" 
               class="form-control" 
               id="search" 
               name="search" 
               placeholder="Mã đơn hàng, email khách hàng..."
               style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;"
               value="{{ request('search') }}">
      </div>

      <div class="form-group mr-3 mb-2">
        <label for="status_filter" class="mr-2" style="color: #333333;"><strong>Trạng Thái:</strong></label>
        <select class="form-control" id="status_filter" name="status" style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;">
          <option value="">Tất Cả</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ Xử Lý</option>
          <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang Xử Lý</option>
          <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn Thành</option>
          <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã Hủy</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary mb-2">
        <i class="fa fa-search"></i> Tìm Kiếm
      </button>
      <a href="/admin/orders" class="btn btn-secondary mb-2 ml-2">
        <i class="fa fa-redo"></i> Reset
      </a>
    </form>
  </div>
</div>

<!-- Orders Table -->
<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #f8f9fa;">
    <h6 class="m-0 font-weight-bold text-primary">
      <i class="fa fa-list"></i> Danh Sách Đơn Hàng
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    @if($orders->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="background-color: #ffffff;">
          <thead style="background-color: #4e73df; border-bottom: 2px solid #dee2e6;">
            <tr>
              <th style="padding: 1rem; color: #ffffff;"><strong>STT</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Mã Đơn Hàng</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Khách Hàng</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Số Lượng</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Tổng Tiền</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Phương Thức</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Trạng Thái</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Ngày Đặt</strong></th>
              <th style="padding: 1rem; color: #ffffff;"><strong>Hành Động</strong></th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr style="border-bottom: 1px solid #dee2e6; background-color: #ffffff;">
                <td style="padding: 1rem; color: #333333;">
                  <strong>{{ $loop->iteration }}</strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <code style="background-color: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 3px;">
                    {{ $order->order_number }}
                  </code>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <div>
                    <strong class="d-block">{{ $order->user->name }}</strong>
                    <small style="color: #666666;">{{ $order->user->email }}</small>
                  </div>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <span class="badge badge-info badge-pill" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">
                    {{ $order->items()->count() }} sản phẩm
                  </span>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  <strong style="color: #28a745;">
                    {{ number_format($order->total_amount, 0, ',', '.') }}₫
                  </strong>
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @switch($order->payment_method)
                    @case('cash')
                      <span class="badge" style="background-color: #ffc107; color: #333333; font-size: 12px; padding: 6px 10px;">Tiền Mặt</span>
                      @break
                    @case('bank_transfer')
                      <span class="badge" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">Chuyển Khoản</span>
                      @break
                    @case('card')
                      <span class="badge" style="background-color: #4e73df; color: white; font-size: 12px; padding: 6px 10px;">Thẻ</span>
                      @break
                    @default
                      <span class="badge" style="background-color: #858796; color: white; font-size: 12px; padding: 6px 10px;">{{ $order->payment_method }}</span>
                  @endswitch
                </td>
                <td style="padding: 1rem; color: #333333;">
                  @switch($order->status)
                    @case('pending')
                      <span class="badge" style="background-color: #dc3545; color: white; font-size: 12px; padding: 6px 10px;">Chờ Xử Lý</span>
                      @break
                    @case('processing')
                      <span class="badge" style="background-color: #ffc107; color: #333333; font-size: 12px; padding: 6px 10px;">Đang Xử Lý</span>
                      @break
                    @case('completed')
                      <span class="badge" style="background-color: #28a745; color: white; font-size: 12px; padding: 6px 10px;">Hoàn Thành</span>
                      @break
                    @case('cancelled')
                      <span class="badge" style="background-color: #858796; color: white; font-size: 12px; padding: 6px 10px;">Đã Hủy</span>
                      @break
                  @endswitch
                </td>
                <td style="padding: 1rem; color: #666666;">
                  <small class="d-block">{{ $order->created_at->format('d/m/Y') }}</small>
                  <small style="color: #666666;">{{ $order->created_at->format('H:i') }}</small>
                </td>
                <td style="padding: 1rem;">
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="/admin/orders/{{ $order->id }}" 
                       class="btn btn-info" 
                       title="Xem Chi Tiết">
                      <i class="fa fa-eye"></i> Xem
                    </a>
                    <button class="btn btn-primary status-update-btn" 
                            data-id="{{ $order->id }}"
                            data-status="{{ $order->status }}"
                            title="Cập Nhật Trạng Thái">
                      <i class="fa fa-edit"></i> Sửa
                    </button>
                    <button class="btn btn-danger delete-btn" 
                            data-id="{{ $order->id }}"
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
        {{ $orders->links() }}
      </div>
    @else
      <div class="text-center py-5" style="background-color: #ffffff;">
        <i class="fa fa-inbox fa-3x mb-3" style="color: #bbb;"></i>
        <p style="color: #666666; font-size: 16px;">Chưa có đơn hàng nào. <a href="/admin" class="font-weight-bold" style="color: #4e73df;">Quay lại Dashboard</a></p>
      </div>
    @endif
  </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4e73df; color: white;">
        <h5 class="modal-title" style="color: white;">
          <i class="fa fa-edit"></i> Cập Nhật Trạng Thái Đơn Hàng
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="statusForm" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body" style="background-color: #ffffff;">
          <div class="form-group">
            <label for="newStatus" style="color: #333333;"><strong>Trạng Thái Mới:</strong></label>
            <select class="form-control" id="newStatus" name="status" style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;" required>
              <option value="pending">Chờ Xử Lý</option>
              <option value="processing">Đang Xử Lý</option>
              <option value="completed">Hoàn Thành</option>
              <option value="cancelled">Đã Hủy</option>
            </select>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #f8f9fa;">
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
// Status Update Button
document.addEventListener('DOMContentLoaded', function() {
  // Status update buttons
  document.querySelectorAll('.status-update-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const orderId = this.getAttribute('data-id');
      const currentStatus = this.getAttribute('data-status');
      
      document.getElementById('statusForm').action = `/admin/orders/${orderId}/status`;
      document.getElementById('newStatus').value = currentStatus;
      
      $('#statusModal').modal('show');
    });
  });

  // Delete buttons
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      deleteOrder(id);
    });
  });
});

// Delete Order
function deleteOrder(id) {
  if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
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
