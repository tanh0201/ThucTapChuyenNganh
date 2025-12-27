@extends('admin.layout.base')

@section('title', 'PetSam Admin - Quản Lý Email Logs')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Email Logs</li>
</ol>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">📧 Quản Lý Email Logs</h2>
            <small class="text-muted">Theo dõi tất cả emails được gửi</small>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.email-logs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" class="form-control" placeholder="Email, chủ đề..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="sending" {{ request('status') === 'sending' ? 'selected' : '' }}>Đang gửi</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Đã gửi</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Loại Email</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="OrderConfirmationMail" {{ request('type') === 'OrderConfirmationMail' ? 'selected' : '' }}>
                            Xác nhận đơn hàng
                        </option>
                        <option value="OrderStatusUpdatedMail" {{ request('type') === 'OrderStatusUpdatedMail' ? 'selected' : '' }}>
                            Cập nhật trạng thái
                        </option>
                        <option value="NewOrderNotificationMail" {{ request('type') === 'NewOrderNotificationMail' ? 'selected' : '' }}>
                            Thông báo đơn mới
                        </option>
                        <option value="NewCustomerCareMail" {{ request('type') === 'NewCustomerCareMail' ? 'selected' : '' }}>
                            Hỗ trợ khách hàng
                        </option>
                        <option value="NewContactMail" {{ request('type') === 'NewContactMail' ? 'selected' : '' }}>
                            Liên hệ mới
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary grow">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                    <a href="{{ route('admin.email-logs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Logs Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h6 class="mb-0 fw-bold">📧 Danh Sách Email Logs ({{ $emailLogs->total() ?? 0 }} emails)</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 200px;">Email</th>
                        <th style="width: 250px;">Chủ Đề</th>
                        <th style="width: 120px;">Loại</th>
                        <th style="width: 100px;">Trạng Thái</th>
                        <th style="width: 130px;">Thời Gian</th>
                        <th style="width: 70px;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emailLogs as $log)
                    <tr>
                        <td><small><code>{{ $log->id }}</code></small></td>
                        <td>
                            <small>
                                @if(trim($log->to_email))
                                    <a href="mailto:{{ htmlspecialchars(trim($log->to_email)) }}" class="text-decoration-none">
                                        {{ htmlspecialchars(trim($log->to_email)) }}
                                    </a>
                                @else
                                    <span class="text-muted">(không rõ)</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            <small class="text-truncate" style="display: block; max-width: 250px;" title="{{ $log->subject }}">
                                {{ Illuminate\Support\Str::limit($log->subject, 40) }}
                            </small>
                        </td>
                        <td>
                            <small><span class="badge bg-info text-dark">{{ class_basename($log->mailable_class) }}</span></small>
                        </td>
                        <td>
                            @if($log->status === 'sent')
                                <span class="badge bg-success" style="font-size: 11px;">✓ Gửi</span>
                            @elseif($log->status === 'failed')
                                <span class="badge bg-danger" style="font-size: 11px;">✗ Thất bại</span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size: 11px;">⏳ Gửi</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted" style="white-space: nowrap;">{{ $log->created_at->format('d/m H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-xs btn-outline-primary view-email-btn" 
                                    data-log-id="{{ $log->id }}"
                                    data-to="{{ htmlspecialchars(trim($log->to_email), ENT_QUOTES) }}"
                                    data-subject="{{ htmlspecialchars($log->subject, ENT_QUOTES) }}"
                                    data-type="{{ class_basename($log->mailable_class) }}"
                                    data-status="{{ $log->status }}"
                                    data-body='{{ json_encode(trim($log->body ?? "")) }}'
                                    data-error="{{ htmlspecialchars($log->error_message ?? "", ENT_QUOTES) }}"
                                    title="Xem">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3;"></i>
                                <p class="mt-3 mb-0">Chưa có email logs</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($emailLogs->hasPages())
        <div class="card-footer bg-light border-top">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Tổng cộng {{ $emailLogs->total() }} emails</small>
                {{ $emailLogs->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-primary mb-2"><i class="fas fa-envelope" style="font-size: 24px;"></i></div>
                    <h6 class="text-muted mb-1">Tổng Email</h6>
                    <h2 class="mb-0">{{ $emailLogs->total() ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-success mb-2"><i class="fas fa-check-circle" style="font-size: 24px;"></i></div>
                    <h6 class="text-muted mb-1">Đã Gửi</h6>
                    <h2 class="mb-0">{{ $stats['sent'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-danger mb-2"><i class="fas fa-times-circle" style="font-size: 24px;"></i></div>
                    <h6 class="text-muted mb-1">Thất Bại</h6>
                    <h2 class="mb-0">{{ $stats['failed'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-warning mb-2"><i class="fas fa-hourglass-half" style="font-size: 24px;"></i></div>
                    <h6 class="text-muted mb-1">Đang Gửi</h6>
                    <h2 class="mb-0">{{ $stats['sending'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Preview Modal (Single Reusable Modal) -->
<div class="modal fade" id="emailPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-envelope me-2"></i><span id="modalSubject"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Email Info -->
                <div class="row mb-4 pb-4 border-bottom">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold text-muted text-uppercase mb-1">
                            <i class="fas fa-envelope text-primary me-2"></i>Đến
                        </label>
                        <p class="h6 mb-0">
                            <a href="#" id="modalTo" class="text-decoration-none"></a>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold text-muted text-uppercase mb-1">
                            <i class="fas fa-layer-group text-primary me-2"></i>Loại
                        </label>
                        <p class="h6 mb-0"><span id="modalType" class="badge bg-info text-dark"></span></p>
                    </div>
                </div>

                <!-- Error Alert -->
                <div id="errorAlert" class="alert alert-danger d-none mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i><strong>Lỗi:</strong><br>
                    <small id="errorMsg"></small>
                </div>

                <!-- Email Body -->
                <div class="mb-3">
                    <label class="small fw-bold text-muted text-uppercase mb-2 d-block">
                        <i class="fas fa-file-alt text-primary me-2"></i>Nội Dung
                    </label>
                    <div class="email-preview border rounded p-3" style="background-color: #f9f9f9; max-height: 400px; overflow-y: auto;">
                        <div id="modalBody"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-sm" id="quickReplyBtn" onclick="openQuickReplyModal()">
                    <i class="fas fa-reply me-1"></i> Phản Hồi Nhanh
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Reply Modal -->
<div class="modal fade" id="quickReplyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="quickReplyForm" method="POST" action="{{ route('admin.email-logs.quick-reply') }}">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-reply me-2"></i>Phản Hồi Nhanh
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Đến:</label>
                        <input type="email" class="form-control" id="replyTo" name="to_email" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chủ đề:</label>
                        <input type="text" class="form-control" id="replySubject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung:</label>
                        <textarea class="form-control" id="replyMessage" name="message" rows="8" required placeholder="Nhập nội dung phản hồi..."></textarea>
                        <small class="text-muted">Tối thiểu 10 ký tự</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-paper-plane me-1"></i>Gửi Phản Hồi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.table-sm td { padding: 0.5rem; }
.btn-xs { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
.email-preview { font-size: 0.9rem; line-height: 1.5; }
.email-preview img { max-width: 100%; height: auto; display: none; }
.email-preview a { color: #007bff; }
.email-preview p { margin-bottom: 0.5rem; }
code { background-color: #f5f5f5; padding: 2px 6px; border-radius: 3px; font-size: 0.85rem; }
</style>

<script>
document.querySelectorAll('.view-email-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const subject = this.getAttribute('data-subject');
        const to = this.getAttribute('data-to');
        const type = this.getAttribute('data-type');
        const status = this.getAttribute('data-status');
        let body = this.getAttribute('data-body');
        const error = this.getAttribute('data-error');
        const logId = this.getAttribute('data-log-id');

        // Parse JSON body
        try {
            body = JSON.parse(body) || '';
        } catch (e) {
            body = '';
        }

        document.getElementById('modalSubject').textContent = subject;
        
        // Set email link
        const emailLink = document.getElementById('modalTo');
        if (to) {
            emailLink.href = 'mailto:' + to;
            emailLink.textContent = to;
        } else {
            emailLink.href = '#';
            emailLink.textContent = '(không rõ)';
            emailLink.classList.add('text-muted');
        }
        
        document.getElementById('modalType').textContent = type;
        
        // Display body - check if it looks like HTML
        if (body) {
            if (body.includes('<') && body.includes('>')) {
                // Try to render as HTML
                document.getElementById('modalBody').innerHTML = body;
            } else {
                // Display as plain text
                document.getElementById('modalBody').innerHTML = '<pre style="white-space: pre-wrap; word-wrap: break-word; font-family: monospace;">' + escapeHtml(body) + '</pre>';
            }
        } else {
            document.getElementById('modalBody').innerHTML = '<p class="text-warning">Không có nội dung email</p>';
        }
        
        document.getElementById('quickReplyBtn').setAttribute('data-to', to);
        document.getElementById('quickReplyBtn').setAttribute('data-subject', 'Re: ' + subject);

        const errorAlert = document.getElementById('errorAlert');
        if (error) {
            errorAlert.classList.remove('d-none');
            document.getElementById('errorMsg').textContent = error;
        } else {
            errorAlert.classList.add('d-none');
        }

        new bootstrap.Modal(document.getElementById('emailPreviewModal')).show();
    });
});

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

function openQuickReplyModal() {
    const to = document.getElementById('quickReplyBtn').getAttribute('data-to');
    const subject = document.getElementById('quickReplyBtn').getAttribute('data-subject');
    
    if (!to) {
        alert('Không có email để phản hồi');
        return;
    }
    
    // Set values in quick reply form
    document.getElementById('replyTo').value = to;
    document.getElementById('replySubject').value = subject;
    document.getElementById('replyMessage').value = '';
    
    // Close preview modal and open quick reply modal
    bootstrap.Modal.getInstance(document.getElementById('emailPreviewModal')).hide();
    new bootstrap.Modal(document.getElementById('quickReplyModal')).show();
}

document.getElementById('quickReplyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang gửi...';
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new FormData(form)
    })
    .then(response => response.json())
    .catch(() => location.reload())
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        setTimeout(() => location.reload(), 500);
    });
});
</script>
@endsection
