<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="PetSam Admin Dashboard">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'PetSam Admin')</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome (Latest) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  
  <!-- Modern Admin Styles -->
  <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet">
  
  @yield('additional-css')
</head>

<body id="page-top">
  <!-- Navigation -->
  @include('admin.layout.navbar')

  <div class="content-wrapper">
    <div class="container-fluid px-4 py-4">
      <!-- Breadcrumbs -->
      @yield('breadcrumb')

      <!-- Main Content -->
      @yield('content')
    </div>
  </div>

  <!-- Footer -->
  @include('admin.layout.footer')

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  
  <!-- jQuery Easing -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  
  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  
  @yield('additional-js')
</body>

</html>