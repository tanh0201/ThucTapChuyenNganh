<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'PetSam - Website bán phụ kiện thú cưng')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="PetSam - cửa hàng phụ kiện thú cưng có gợi ý sản phẩm bằng AI.">
    <meta name="keywords" content="PetSam, phụ kiện thú cưng, chó mèo, petshop, AI recommendation">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Icons & Libraries -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Spinner -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
    </div>

    {{-- HEADER --}}
    @include('layout.header')

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('layout.footer')

    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Main Script -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(window).on('load', function () {
            $('#spinner').removeClass('show');
            new WOW().init();
            if ($('.header-carousel').length) {
                $('.header-carousel').owlCarousel({
                    autoplay: true,
                    smartSpeed: 1000,
                    items: 1,
                    dots: true,
                    loop: true,
                    nav: false
                });
            }
        });
    </script>
</body>
</html>
