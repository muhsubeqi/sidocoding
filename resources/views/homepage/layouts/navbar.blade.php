<header class="nav-holder make-sticky">
    <div id="navbar" role="navigation" class="navbar navbar-expand-lg">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand home"><img
                    src="{{ asset('/visitor/img/my-image/logo.png') }}" alt="Sidocoding logo"
                    class="d-none d-md-inline-block" /><img src="{{ asset('/visitor/img/my-image/logo.png') }}"
                    alt="Sidocoding logo" class="d-inline-block d-md-none" /><span class="sr-only">Sidocoding
                    - go to homepage</span></a>
            <button type="button" data-toggle="collapse" data-target="#navigation"
                class="navbar-toggler btn-template-outlined">
                <span class="sr-only">Toggle navigation</span><i class="fa fa-align-justify"></i>
            </button>
            <div id="navigation" class="navbar-collapse collapse">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home*') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home <b class="caret"></b></a>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('tutorial*') ? 'active' : '' }}
                        {{ request()->routeIs('list-category*') ? 'active' : '' }}">
                        <a href="{{ route('tutorial') }}">Tutorial<b class="caret"></b></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('ebook*') ? 'active' : '' }}">
                        <a href="{{ route('ebook') }}">Ebook <b class="caret"></b></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('shop*') ? 'active' : '' }}">
                        <a href="{{ route('shop') }}">Shop <b class="caret"></b></a>
                    </li>
                    @auth
                        <li class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">Dahboard <b class="caret"></b></a>
                        </li>
                    @endauth
                </ul>
            </div>
            <div id="search" class="collapse clearfix">
                <form role="search" class="navbar-form">
                    <div class="input-group">
                        <input type="text" placeholder="Search" class="form-control" /><span class="input-group-btn">
                            <button type="submit" class="btn btn-template-main">
                                <i class="fa fa-search"></i></button></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
