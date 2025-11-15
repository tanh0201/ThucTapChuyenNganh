<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="PetSam Admin Dashboard">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'PetSam Admin')</title>
  
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome (CDN) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Custom styles -->
  <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
  <!-- Dark Mode CSS -->
  <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet">
</head>

@php
  $theme = session('admin_theme', 'light');
@endphp

<body class="fixed-nav sticky-footer bg-dark @if($theme === 'dark') dark-mode @endif" id="page-top">
  <!-- Navigation -->
  @include('admin.layout.navbar')
  
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs -->
      @yield('breadcrumb')
      
      <!-- Main Content -->
      @yield('content')
    </div>
  </div>
  
  <!-- Footer -->
  @include('admin.layout.footer')

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery Easing -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <!-- Custom scripts -->
  <script src="{{ asset('js/sb-admin.min.js') }}"></script>
  <script src="{{ asset('js/sb-admin-charts.min.js') }}"></script>
  
  <!-- Dark Mode Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const themeToggle = document.getElementById('themeToggle');
      
      if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
          e.preventDefault();
          
          fetch('{{ route("admin.theme.toggle") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Apply theme to body
              const body = document.body;
              if (data.theme === 'dark') {
                body.classList.add('dark-mode');
              } else {
                body.classList.remove('dark-mode');
              }
              
              // Update icon
              const icon = themeToggle.querySelector('i');
              if (icon) {
                if (data.theme === 'dark') {
                  icon.classList.remove('fa-moon-o');
                  icon.classList.add('fa-sun-o');
                } else {
                  icon.classList.remove('fa-sun-o');
                  icon.classList.add('fa-moon-o');
                }
              }
              
              // Save to localStorage
              localStorage.setItem('admin_theme', data.theme);
            }
          })
          .catch(error => console.error('Theme toggle error:', error));
        });
      }
    });

    // Load Messages and Notifications
    function loadMessages() {
      fetch('{{ route("admin.messages.recent") }}')
        .then(r => r.json())
        .then(data => {
          const count = data.unreadCount || 0;
          document.getElementById('msgCount').textContent = count;
          
          if (data.messages.length === 0) {
            document.getElementById('messagesList').innerHTML = '<a class="dropdown-item" href="#">Không có tin nhắn</a>';
            return;
          }
          
          let html = '';
          data.messages.forEach(msg => {
            const time = new Date(msg.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
            const sender = msg.from_user?.name || 'Ẩn danh';
            html += `
              <a class="dropdown-item" href="#" onclick="openMessage(${msg.id})">
                <strong>${sender}</strong>
                <span class="small float-right text-muted">${time}</span>
                <div class="dropdown-message small">${msg.subject}</div>
              </a>
              <div class="dropdown-divider"></div>
            `;
          });
          document.getElementById('messagesList').innerHTML = html;
        })
        .catch(error => console.error('Error loading messages:', error));
    }

    function loadNotifications() {
      fetch('{{ route("admin.notifications.recent") }}')
        .then(r => r.json())
        .then(data => {
          const count = data.unreadCount || 0;
          document.getElementById('notifCount').textContent = count;
          
          if (data.notifications.length === 0) {
            document.getElementById('notificationsList').innerHTML = '<a class="dropdown-item" href="#">Không có thông báo</a>';
            return;
          }
          
          let html = '';
          data.notifications.forEach(notif => {
            const time = new Date(notif.created_at).toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
            const statusClass = {
              'success': 'text-success',
              'warning': 'text-warning',
              'error': 'text-danger',
              'pending': 'text-info'
            }[notif.status] || 'text-info';
            
            html += `
              <a class="dropdown-item" href="#" onclick="openNotification(${notif.id})">
                <span class="${statusClass}">
                  <strong>${notif.title}</strong>
                </span>
                <span class="small float-right text-muted">${time}</span>
                <div class="dropdown-message small">${notif.message}</div>
              </a>
              <div class="dropdown-divider"></div>
            `;
          });
          document.getElementById('notificationsList').innerHTML = html;
        })
        .catch(error => console.error('Error loading notifications:', error));
    }

    function openMessage(id) {
      const basePath = '{{ url("/admin/api/messages") }}';
      fetch(`${basePath}/${id}`)
        .then(r => r.json())
        .then(data => {
          const sender = data.from_user?.name || 'Ẩn danh';
          const time = new Date(data.created_at).toLocaleString('vi-VN');
          alert(`Từ: ${sender}\nTiêu đề: ${data.subject}\nNgày gửi: ${time}\n\n${data.body}`);
        })
        .catch(error => console.error('Error opening message:', error));
    }

    function openNotification(id) {
      const basePath = '{{ url("/admin/api/notifications") }}';
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      
      fetch(`${basePath}/${id}/read`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Content-Type': 'application/json'
        }
      })
        .then(r => r.json())
        .then(() => {
          loadNotifications();
        })
        .catch(error => console.error('Error opening notification:', error));
    }

    // Load on page load and refresh every 30 seconds
    document.addEventListener('DOMContentLoaded', function() {
      loadMessages();
      loadNotifications();
      
      setInterval(loadMessages, 30000);
      setInterval(loadNotifications, 30000);
    });
  </script>
  
  @yield('additional-js')
</body>

</html>
