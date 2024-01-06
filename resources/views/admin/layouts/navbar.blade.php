<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Lihat Website</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link active fw-bold" href="#" role="button">
                {{ date('H:i | d M Y') }}
            </a>
        </li>
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-globe"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="mode-toggle" role="button">
                <span id="icon-light"><i class="fas fa-sun"></i></span>
                <span id="icon-dark"><i class="fas fa-moon"></i></span>
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                @if (auth()->user()->photo != null)
                    <img src="{{ asset('/data/user/image/' . auth()->user()->photo) }}"
                        class="user-image img-circle elevation-2" style="object-fit:cover" alt="User Image">
                @else
                    <img src="{{ asset('/admin/dist/img/avatar5.png') }}" class="user-image img-circle elevation-2"
                        style="object-fit:cover" alt="User Image">
                @endif
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <li class="user-header bg-primary">
                    @if (auth()->user()->photo != null)
                        <img src="{{ asset('/data/user/image/' . auth()->user()->photo) }}"
                            class="user-image img-circle elevation-2" style="object-fit:cover" alt="User Image">
                    @else
                        <img src="{{ asset('/admin/dist/img/avatar5.png') }}" class="user-image img-circle elevation-2"
                            style="object-fit:cover" alt="User Image">
                    @endif
                    <p>
                        {{ auth()->user()->name }} - {{ auth()->user()->role }}
                        <small>{{ auth()->user()->email }}</small>
                    </p>
                </li>

                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                    {{-- <a href="#" class="btn btn-default btn-flat float-right">Sign out</a> --}}
                    <a href="{{ route('logout') }}" onclick="logout(event)"
                        class="btn btn-default btn-flat float-right">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
