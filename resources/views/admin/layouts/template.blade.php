<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Mycss -->
    <link rel="stylesheet" href="{{ asset('/admin/dist/css/mycss.css') }}">
    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" id="theme-style">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('/visitor/img/my-image/icon.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        @include('admin.layouts.navbar')

        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('admin.layouts.footer')

        @include('admin.layouts.control-sidebar')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- momen js -->
    <script src="{{ asset('/admin/plugins/moment/moment.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('/admin/dist/js/demo.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- myscript -->
    <script src="{{ asset('/admin/dist/js/myscript.js') }}"></script>
    @stack('script')

    <script>
        function logout(event) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Kamu akan keluar dari sistem",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "OK!",
            }).then((result) => {
                if (result.value === true) {
                    document.getElementById("logout-form").submit();
                }
            });
        }
    </script>
    <script>
        const modeToggle = document.getElementById('mode-toggle');
        const themeStyle = document.getElementById('theme-style');
        const iconLight = document.getElementById('icon-light');
        const iconDark = document.getElementById('icon-dark');

        // Load the saved mode from cookie or default to 'light'
        const savedMode = getCookie('themeMode') || 'light';
        setTheme(savedMode);

        // Function to toggle between dark and light modes
        function toggleMode() {
            const currentMode = themeStyle.dataset.mode;
            console.log(currentMode);
            const newMode = currentMode === 'dark' ? 'light' : 'dark';
            setTheme(newMode);
            setCookie('themeMode', newMode, 90); // Set the cookie for 90 days
        }

        // Function to apply the selected theme
        function setTheme(mode) {
            themeStyle.dataset.mode = mode;
            document.body.className = `${mode}-mode sidebar-mini`;

            // Toggle icon visibility based on the mode
            if (mode === 'dark') {
                iconLight.style.display = 'inline';
                iconDark.style.display = 'none';
            } else {
                iconLight.style.display = 'none';
                iconDark.style.display = 'inline';
            }
        }

        // Function to get a cookie value by name
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Function to set a cookie
        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
            document.cookie = `${name}=${value}; expires=${expires}; path=/`;
        }

        // Attach event listener to the mode toggle button
        modeToggle.addEventListener('click', toggleMode);
    </script>

</body>

</html>
