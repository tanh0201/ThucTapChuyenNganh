@extends('admin.layout.base')

@section('title', 'PetSam Admin - Gợi Ý AI')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/admin">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Gợi Ý AI</li>
</ol>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="h3 mb-0">
      <i class="fa fa-lightbulb-o"></i> Hệ Thống Gợi Ý AI
    </h2>
  </div>
</div>

<!-- AI Stats Cards -->
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #4e73df; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tổng Gợi Ý</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ number_format($aiStats['total_recommendations']) }}
        </div>
        <small style="color: #666666;">Tất cả các gợi ý được tạo</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #1cc88a; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Người Dùng Hoạt Động</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ number_format($aiStats['active_users']) }}
        </div>
        <small style="color: #666666;">Người dùng nhận gợi ý</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #36b9cc; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Tỷ Lệ Chuyển Đổi</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ $aiStats['conversion_rate'] }}%
        </div>
        <small style="color: #666666;">Từ gợi ý thành mua hàng</small>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card shadow h-100" style="background-color: #ffffff; border: none;">
      <div class="card-body">
        <div style="color: #f6c23e; text-transform: uppercase; margin-bottom: 1rem;">
          <small class="font-weight-bold">Độ Chính Xác</small>
        </div>
        <div style="font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: 600; color: #333333;">
          {{ $aiStats['avg_recommendation_accuracy'] }}%
        </div>
        <small style="color: #666666;">Độ chính xác thuật toán</small>
      </div>
    </div>
  </div>
</div>

<!-- Main Content Row -->
<div class="row mb-4">
  <!-- Trend Chart -->
  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-line-chart"></i> Trend Gợi Ý 7 Ngày
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="trendChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>

  <!-- Behavior Analysis -->
  <div class="col-xl-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-bar-chart"></i> Hành Vi Danh Mục
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <canvas id="behaviorChart" style="max-height: 250px;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Top Recommended Products -->
<div class="card shadow mb-4" style="background-color: #ffffff;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-star"></i> Top 10 Sản Phẩm Được Gợi Ý
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    <div class="table-responsive">
      <table class="table table-hover mb-0" style="background-color: #ffffff;">
        <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
          <tr>
            <th style="padding: 1rem; color: #333333;"><strong>#</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Tên Sản Phẩm</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Giá</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Lần Gợi Ý</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Số Lượng Bán</strong></th>
          </tr>
        </thead>
        <tbody>
          @forelse($recommendedProducts as $index => $product)
            <tr style="border-bottom: 1px solid #dee2e6;">
              <td style="padding: 1rem; color: #333333;">
                <strong>{{ $index + 1 }}</strong>
              </td>
              <td style="padding: 1rem; color: #333333;">
                {{ $product->name }}
              </td>
              <td style="padding: 1rem; color: #333333;">
                {{ number_format($product->price, 0, ',', '.') }}₫
              </td>
              <td style="padding: 1rem;">
                <span class="badge" style="background-color: #4e73df; color: white; font-size: 12px; padding: 6px 10px;">
                  {{ $product->total_recommendations }}
                </span>
              </td>
              <td style="padding: 1rem; color: #333333;">
                <strong style="color: #1cc88a;">{{ $product->total_quantity }}</strong>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding: 2rem; text-align: center; color: #999999;">Chưa có dữ liệu</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- User Behavior Categories -->
<div class="card shadow mb-4" style="background-color: #ffffff;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-folder"></i> Phân Tích Danh Mục
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff; padding: 0;">
    <div class="table-responsive">
      <table class="table table-hover mb-0" style="background-color: #ffffff;">
        <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
          <tr>
            <th style="padding: 1rem; color: #333333;"><strong>Danh Mục</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Số Sản Phẩm</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Lần Mua</strong></th>
            <th style="padding: 1rem; color: #333333;"><strong>Độ Phổ Biến</strong></th>
          </tr>
        </thead>
        <tbody>
          @forelse($userBehaviorAnalysis as $category)
            <tr style="border-bottom: 1px solid #dee2e6;">
              <td style="padding: 1rem; color: #333333;">
                <strong>{{ $category->name }}</strong>
              </td>
              <td style="padding: 1rem;">
                <span class="badge" style="background-color: #17a2b8; color: white; font-size: 12px; padding: 6px 10px;">
                  {{ $category->product_count }}
                </span>
              </td>
              <td style="padding: 1rem; color: #333333;">
                {{ $category->purchase_count }}
              </td>
              <td style="padding: 1rem;">
                <div style="background-color: #f0f0f0; border-radius: 4px; height: 20px; overflow: hidden;">
                  <div style="background-color: #4e73df; height: 100%; width: {{ min($category->purchase_count * 2, 100) }}%;"></div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="padding: 2rem; text-align: center; color: #999999;">Chưa có dữ liệu</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- AI Tools Section -->
<div class="row mb-4">
  <div class="col-md-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-user"></i> Gợi Ý Cho Người Dùng
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <div class="form-group">
          <label for="userSelect" style="color: #333333;"><strong>Chọn Người Dùng:</strong></label>
          <select class="form-control" id="userSelect" style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;">
            <option value="">-- Chọn người dùng --</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-primary btn-block" id="recommendBtn">
          <i class="fa fa-lightbulb-o"></i> Lấy Gợi Ý
        </button>
        <div id="recommendationResult" style="margin-top: 1rem;"></div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow mb-4" style="background-color: #ffffff;">
      <div class="card-header py-3" style="background-color: #4e73df; color: white;">
        <h6 class="m-0 font-weight-bold" style="color: white;">
          <i class="fa fa-cubes"></i> Sản Phẩm Tương Tự
        </h6>
      </div>
      <div class="card-body" style="background-color: #ffffff;">
        <div class="form-group">
          <label for="productSelect" style="color: #333333;"><strong>Chọn Sản Phẩm:</strong></label>
          <select class="form-control" id="productSelect" style="color: #333333; background-color: #ffffff; border: 1px solid #ddd;">
            <option value="">-- Chọn sản phẩm --</option>
            @foreach($allProducts as $product)
              <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->category->name ?? 'N/A' }})</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-info btn-block" id="similarBtn">
          <i class="fa fa-sitemap"></i> Tìm Sản Phẩm Tương Tự
        </button>
        <div id="similarResult" style="margin-top: 1rem;"></div>
      </div>
    </div>
  </div>
</div>

<!-- Information Card -->
<div class="card shadow mb-4" style="background-color: #ffffff;">
  <div class="card-header py-3" style="background-color: #4e73df; color: white;">
    <h6 class="m-0 font-weight-bold" style="color: white;">
      <i class="fa fa-info-circle"></i> Về Hệ Thống Gợi Ý AI
    </h6>
  </div>
  <div class="card-body" style="background-color: #ffffff;">
    <div class="row">
      <div class="col-md-6">
        <h5 style="color: #4e73df; font-weight: bold; margin-bottom: 1rem;">📊 Tính Năng Chính</h5>
        <ul style="color: #333333; line-height: 2;">
          <li><strong>Phân tích hành vi người dùng</strong> - Theo dõi mô hình mua hàng</li>
          <li><strong>Gợi ý cá nhân hóa</strong> - Dựa trên lịch sử mua hàng</li>
          <li><strong>Sản phẩm tương tự</strong> - Tìm sản phẩm trong cùng danh mục</li>
          <li><strong>Tối ưu hóa giỏ hàng</strong> - Gợi ý bổ sung thích hợp</li>
        </ul>
      </div>
      <div class="col-md-6">
        <h5 style="color: #4e73df; font-weight: bold; margin-bottom: 1rem;">⚙️ Cách Hoạt Động</h5>
        <ul style="color: #333333; line-height: 2;">
          <li>🔍 Phân tích danh mục được mua nhiều nhất</li>
          <li>🧠 Học từ hành vi của tất cả người dùng</li>
          <li>🎯 Đề xuất sản phẩm phù hợp nhất</li>
          <li>📈 Cập nhật gợi ý thời gian thực</li>
        </ul>
      </div>
    </div>
    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #dee2e6;">
      <p style="color: #666666; margin: 0;">
        <strong>💡 Mẹo:</strong> Hệ thống AI sẽ học hỏi từ các mô hình mua hàng của khách hàng và cải thiện độ chính xác theo thời gian. 
        Tỷ lệ chuyển đổi hiện tại là 85%, có nghĩa là 85% gợi ý dẫn đến mua hàng.
      </p>
    </div>
  </div>
</div>

@endsection

@section('additional-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
  // Data from backend
  const trendData = {!! json_encode($recommendationTrends) !!};
  const behaviorData = {!! json_encode($userBehaviorAnalysis) !!};

  // Colors
  const colors = {
    primary: '#4e73df',
    success: '#1cc88a',
    info: '#36b9cc',
    warning: '#f6c23e',
    danger: '#dc3545',
  };

  // Trend Chart
  const trendCtx = document.getElementById('trendChart');
  if (trendCtx) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: trendData.labels,
        datasets: [{
          label: 'Gợi ý (Lần)',
          data: trendData.data,
          borderColor: colors.primary,
          backgroundColor: 'rgba(78, 115, 223, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: colors.primary,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: true } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
        },
      },
    });
  }

  // Behavior Chart
  const behaviorCtx = document.getElementById('behaviorChart');
  if (behaviorCtx && behaviorData.length > 0) {
    const labels = behaviorData.map(cat => cat.name);
    const data = behaviorData.map(cat => cat.purchase_count);
    
    new Chart(behaviorCtx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Lần Mua',
          data: data,
          backgroundColor: colors.success,
          borderColor: colors.success,
          borderWidth: 1,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: { legend: { display: true } },
        scales: { x: { beginAtZero: true } },
      },
    });
  }

  // Get Recommendations
  document.getElementById('recommendBtn').addEventListener('click', function() {
    const userId = document.getElementById('userSelect').value;
    
    if (!userId) {
      alert('Vui lòng chọn người dùng');
      return;
    }

    fetch(`/admin/api/ai/recommendations?user_id=${userId}&limit=5`)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          let html = '<h6 style="color: #4e73df; font-weight: bold; margin-bottom: 1rem;">Gợi Ý Cho Người Dùng:</h6>';
          
          if (data.recommendations.length > 0) {
            html += '<ul style="color: #333333;">';
            data.recommendations.forEach((product, index) => {
              html += `
                <li style="margin-bottom: 0.5rem;">
                  <strong>${product.name}</strong>
                  <br>
                  <small style="color: #666666;">
                    Danh mục: ${product.category.name} | 
                    Giá: ${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(product.price)}
                  </small>
                </li>
              `;
            });
            html += '</ul>';
          }
          
          document.getElementById('recommendationResult').innerHTML = html;
        }
      })
      .catch(err => console.error('Error:', err));
  });

  // Get Similar Products
  document.getElementById('similarBtn').addEventListener('click', function() {
    const productId = document.getElementById('productSelect').value;
    
    if (!productId) {
      alert('Vui lòng chọn sản phẩm');
      return;
    }

    fetch(`/admin/api/ai/similar-products?product_id=${productId}&limit=5`)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          let html = '<h6 style="color: #4e73df; font-weight: bold; margin-bottom: 1rem;">Sản Phẩm Tương Tự:</h6>';
          
          if (data.similar_products.length > 0) {
            html += '<ul style="color: #333333;">';
            data.similar_products.forEach(product => {
              html += `
                <li style="margin-bottom: 0.5rem;">
                  <strong>${product.name}</strong>
                  <br>
                  <small style="color: #666666;">
                    Giá: ${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(product.price)}
                  </small>
                </li>
              `;
            });
            html += '</ul>';
          }
          
          document.getElementById('similarResult').innerHTML = html;
        }
      })
      .catch(err => console.error('Error:', err));
  });
</script>
@endsection
