<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="all,follow" />
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('/visitor/vendor/bootstrap/css/bootstrap.min.css') }}" />
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('/visitor/vendor/font-awesome/css/font-awesome.min.css') }}" />
    <!-- Google fonts - Roboto-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" />
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="{{ asset('/visitor/vendor/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <!-- owl carousel-->
    <link rel="stylesheet" href="{{ asset('/visitor/vendor/owl.carousel/assets/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('/visitor/vendor/owl.carousel/assets/owl.theme.default.css') }}" />
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('/visitor/css/style.blue.css') }}" id="theme-stylesheet" />
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('/visitor/css/custom.css') }}" />
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @stack('css')
    <style>
        .owl-carousel {
            -ms-touch-action: pan-y;
            touch-action: pan-y;
        }
    </style>
</head>

<body>
    <div id="all">
        <!-- Top bar-->
        @include('homepage.layouts.topbar')
        <!-- Top bar end-->
        <!-- Navbar Start-->
        @include('homepage.layouts.navbar')
        <!-- Navbar End-->
        {{-- Content --}}
        @yield('content')

        <!-- FOOTER -->
        @include('homepage.layouts.footer')
    </div>
    <!-- Javascript files-->
    <script src="{{ asset('/visitor/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
    <script src="{{ asset('/visitor/js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/visitor/vendor/jquery.scrollto/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('/visitor/js/front.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @stack('script')
    <script>
        @if (Session::has('failed-login'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{!! Session::get('failed-login') !!}",
                timer: 5000
            })
        @endif
    </script>
    <script>
        function logout(event) {
            event.preventDefault();
            var confirmLogout = confirm('Apakah kamu yakin ingin keluar?');
            if (confirmLogout == true) {
                document.getElementById('logout-form').submit();
            }
        }

        function showPasswordLogin() {
            var x = document.getElementById("password_modal");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>
