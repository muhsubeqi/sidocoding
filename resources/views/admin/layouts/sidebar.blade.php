<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('/visitor/img/my-image/icon.png') }}" alt="AdminLTE Logo" class="brand-image img-circle "
            style="opacity: .8">
        <span class="brand-text font-weight-light">Sidocoding</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @php
                $photo = auth()->user()->photo;
            @endphp
            @if ($photo != null)
                <div class="image">
                    <img src="{{ asset("/data/user/image/$photo") }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                </div>
            @else
                <div class="image">
                    <img src="{{ asset('/admin/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                </div>
            @endif
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-collapse-hide-child nav-child-indent flex-column"
                data-widget="treeview" role="menu" data-accordion="false" id="list-sidebar">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt bkg-blue"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- Data Master --}}
                <li
                    class="nav-item {{ request()->routeIs('admin.category') ? 'menu-open' : '' }}
                    {{ request()->routeIs('admin.productCategory') ? 'menu-open' : '' }}
                    {{ request()->routeIs('admin.tags*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.category') ? 'active' : '' }}
                        {{ request()->routeIs('admin.productCategory') ? 'active' : '' }}
                        {{ request()->routeIs('admin.tags*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-server bkg-yellow"></i>
                        <p>
                            Master Data
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-success right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.category') }}"
                                class="nav-link {{ request()->routeIs('admin.category') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.productCategory') }}"
                                class="nav-link {{ request()->routeIs('admin.productCategory') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tags') }}"
                                class="nav-link {{ request()->routeIs('admin.tags*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Data Blog --}}
                <li class="nav-item 
{{ request()->routeIs('admin.post*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link 
{{ request()->routeIs('admin.post*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-blog bkg-orange"></i>
                        <p>
                            Data Postingan
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-success right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.post') }}"
                                class="nav-link {{ request()->routeIs('admin.post') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Postingan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.post.create') }}"
                                class="nav-link {{ request()->routeIs('admin.post.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Postingan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Data Ebook --}}
                <li class="nav-item 
                {{ request()->routeIs('admin.ebook*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.ebook*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book bkg-purple"></i>
                        <p>
                            Data Ebook
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-success right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.ebook') }}"
                                class="nav-link {{ request()->routeIs('admin.ebook') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ebook</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ebook.create') }}"
                                class="nav-link {{ request()->routeIs('admin.ebook.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Ebook</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Data Product --}}
                <li class="nav-item 
                {{ request()->routeIs('admin.product*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-laptop bkg-purple"></i>
                        <p>
                            Data Produk
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-success right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.product') }}"
                                class="nav-link {{ request()->routeIs('admin.product') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.product.create') }}"
                                class="nav-link {{ request()->routeIs('admin.product.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Produk</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.comment') }}"
                        class="nav-link {{ request()->routeIs('admin.comment*') ? 'active' : '' }}">
                        <i class="far fa-comments nav-icon bkg-blue"></i>
                        <p>Daftar Komentar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}"
                        class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog bkg-grey"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
