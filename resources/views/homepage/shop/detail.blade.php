@extends('homepage.layouts.template')
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">{{ $product->name }}</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <!-- LEFT COLUMN _________________________________________________________-->
                <div class="col-lg-9">
                    <p class="goToDescription"><a href="#details" class="scroll-to text-uppercase">Scroll untuk melihat
                            detail produk {{ $product->name }}</a></p>
                    <div id="productMain" class="row">
                        <div class="col-sm-6">
                            <div> <img src="{{ asset('data/product/image/' . $product->image) }}" alt=""
                                    class="img-fluid"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box">
                                <h2 class="text-center">{{ $product->name }}</h2>
                                <p class="price">Rp. {{ number_format($product->price, 0, '', '.') }}</p>
                                <p class="text-center">
                                    <button type="submit" class="btn btn-template-outlined"><i
                                            class="fa fa-shopping-cart"></i> Beli Sekarang</button>
                                    <button type="submit" data-toggle="tooltip" data-placement="top"
                                        class="btn btn-default"><i class="fa fa-whatsapp"></i></button>
                                </p>
                            </div>
                            <div data-slider-id="1" class="owl-thumbs">
                                <button class="owl-thumb-item"><img src="img/detailsquare.jpg" alt=""
                                        class="img-fluid"></button>
                                <button class="owl-thumb-item"><img src="img/detailsquare2.jpg" alt=""
                                        class="img-fluid"></button>
                                <button class="owl-thumb-item"><img src="img/detailsquare3.jpg" alt=""
                                        class="img-fluid"></button>
                            </div>
                        </div>
                    </div>
                    <div id="details" class="box mb-4 mt-4">
                        <p></p>
                        <h4>Detail Produk</h4>

                        <p class="mb-0">{!! $product->description !!}</p>

                        <blockquote class="blockquote">
                            <p class="mb-0"><em>"Terima kasih telah memilih produk kami! Kepercayaan Anda merupakan
                                    pendorong bagi kami untuk terus memberikan yang terbaik. Semoga produk ini membawa
                                    manfaat dan kepuasan dalam setiap penggunaannya. Kami senang bisa menjadi bagian dari
                                    perjalanan Anda dan berharap hubungan ini terus berlanjut. Terima kasih atas dukungan
                                    Anda!"</em></p>
                        </blockquote>
                    </div>
                    <div id="product-social" class="box social text-center mb-5 mt-5">
                        <h4 class="heading-light">Bagikan ke teman temanmu</h4>
                        <ul class="social list-inline">
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external facebook"><i class="fa fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external gplus"><i class="fa fa-google-plus"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external twitter"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="email"><i
                                        class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Cari Produk</h3>
                        </div>
                        <div class="panel-body">
                            <form role="search" action="{{ route('shop.search') }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" placeholder="Search" class="form-control" /><span
                                        class="input-group-btn">
                                        <button type="submit" class="btn btn-template-main">
                                            <i class="fa fa-search"></i></button></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- MENUS AND FILTERS-->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Filter Kategori</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm category-menu">
                                <li class="nav-item"><a href="#" onclick="return false"
                                        class="nav-link d-flex align-items-center justify-content-between"><span>Kategori
                                        </span><span class="badge badge-secondary">{{ $categories->count() }}</span></a>
                                    <ul class="nav nav-pills flex-column">
                                        @foreach ($categories as $c)
                                            <li class="nav-item"><a href="{{ route('shop.list', ['id' => $c->id]) }}"
                                                    class="nav-link"><i
                                                        class="{{ $c->icon }} text-{{ $c->color }}"
                                                        style="margin-right: 15px"></i>{{ $c->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Produk Terbaru</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                @foreach ($newProduct as $row)
                                    <li class="nav-item">
                                        <a href="{{ route('shop.detail', ['slug' => $row->slug]) }}"
                                            class="nav-link">{{ $row->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
