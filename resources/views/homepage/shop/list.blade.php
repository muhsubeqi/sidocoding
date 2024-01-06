@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Shop
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Semua Produk</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Semua Produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <div class="col-md-9">
                    <p class="text-muted lead">Selamat datang di website sidocoding, terimakasih sudah memilih
                        untuk belajar dengan kami. berikut kumpulan produk produk dari sidocoding yang dapat kalian
                        order.
                    </p>
                    <div class="row products products-big">
                        @forelse ($products as $row)
                            <div class="col-lg-4 col-md-6">
                                <div class="product">
                                    <div class="image"><a href="{{ route('shop.detail', ['slug' => $row->slug]) }}"><img
                                                src="{{ asset('data/product/image/' . $row->image) }}" alt=""
                                                class="img-fluid image1"></a></div>
                                    <div class="text">
                                        <h3 class="h5"><a
                                                href="{{ route('shop.detail', ['slug' => $row->slug]) }}">{{ $row->name }}</a>
                                        </h3>
                                        <p class="price">
                                            <del>Rp. {{ number_format($row->price * 2, 0, '', '.') }}</del> Rp.
                                            {{ number_format($row->price, 0, '', '.') }}
                                        </p>
                                    </div>
                                    <div class="ribbon-holder">
                                        <div class="ribbon sale">SALE</div>
                                        <div class="ribbon new">NEW</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12 d-flex justify-content-center">Tidak ada data produk untuk
                                kategori ini</div>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-3">
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
                    <div class="banner"><a href="shop-category.html"><img src="img/banner.jpg" alt="sales 2022"
                                class="img-fluid"></a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- GET IT-->
    <div class="get-it">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center p-3">
                    <h3>Lihat Kumpulan Ebook Gratis dan Premium</h3>
                </div>
                <div class="col-lg-4 text-center p-3"> <a href="#" class="btn btn-template-outlined-white">Lihat
                        Sekarang </a></div>
            </div>
        </div>
    </div>
@endsection
