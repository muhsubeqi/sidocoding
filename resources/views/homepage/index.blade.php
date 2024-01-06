@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Home
@endsection
@section('content')
    <section
        style="
    background: url('visitor/img/my-image/bg-header.jpg') center center repeat;
    background-size: cover;
  "
        class="relative-positioned">
        <!-- Carousel Start-->
        <div class="home-carousel">
            <div class="dark-mask mask-primary"></div>
            <div class="container">
                <div class="homepage owl-carousel">
                    <div class="item">
                        <div class="row">
                            <div class="col-md-5 text-right mt-lg-4">
                                <p>
                                    <img src="{{ asset('/visitor/img/my-image/logo-putih.png') }}" alt=""
                                        class="ml-auto" />
                                </p>
                                <h1>Tutorial Belajar Pemrograman</h1>
                                <p>
                                    Sidocoding adalah situs web untuk belajar pemrograman web,
                                    lengkap dari dasar untuk pemula sampai mahir. tersedia
                                    juga tutorial berupa study kasus dan E-book yang dapat
                                    kalian pelajari dengan mudah.
                                </p>
                            </div>
                            <div class="col-md-7 text-center">
                                <img src="{{ asset('/visitor/img/my-image/bg1.png') }}" s alt=""
                                    class="img-fluid w-75 img-responsive center-block d-block mx-auto" />
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-7 text-center mx-auto">
                                <img src="{{ asset('/visitor/img/my-image/bg2.png') }}" alt=""
                                    class="img-fluid w-75 img-responsive center-block d-block mx-auto" />
                            </div>
                            <div class="col-md-5 mt-lg-4">
                                <p>
                                    <img src="{{ asset('/visitor/img/my-image/logo-putih.png') }}" alt=""
                                        class="me-auto" />
                                </p>
                                <h2>
                                    Download E-book <br />
                                    Gratis atau Premium
                                </h2>
                                <p>
                                    Sidocoding juga menyediakan E-book tentang pemrograman
                                    yang mana dapat kalian download secara gratis, tidak hanya
                                    itu sidocoding juga menyediakan ebook berbayar dengan
                                    materi yang lengkap dan terstuktur.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End-->
    </section>
    <section class="bar background-white no-mb">
        <div class="container">
            <div class="col-md-12 mt-5">
                <div class="heading text-center">
                    <h2>Kumpulan Ebook Kami</h2>
                </div>
                <div class="products-big">
                    <div class="row products">
                        @foreach ($ebooks as $ebook)
                            <div class="col-lg-3 col-md-4">
                                <div class="product">
                                    <div class="image" style="border: 1px solid #000">
                                        <a href="{{ GoogleDrive::link($ebook->path) }}" target="_blank"><img
                                                src="{{ asset('/data/ebook/cover/' . $ebook->cover) }}" alt=""
                                                class="img-fluid ebook image1"></a>
                                    </div>
                                    <div class="text">
                                        <h3 class="h5"><a data-toggle="tooltip" data-placement="top"
                                                title="{{ $ebook->title }}" href="#"
                                                onclick="return false;">{{ Str::limit($ebook->title, 50) }}</a>
                                        </h3>
                                        @if ($ebook->status == 'Premium')
                                        @else
                                            <a href="{{ GoogleDrive::link($ebook->path) }}"
                                                class="btn btn-sm btn-success text-white w-100" target="_blank">Baca
                                                Ebook</a>
                                        @endif
                                    </div>
                                    @if ($ebook->status == 'Premium')
                                        <div class="ribbon-holder">
                                            <div class="ribbon sale">Premium</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="heading text-center">
                    <h2>Artikel Kami</h2>
                </div>
                <p class="lead">
                    Selamat datang di website sidocoding, terimakasih sudah memilih
                    untuk belajar dengan kami. berikut artikel yang dapat kalian
                    pelajari dan semoga bermanfaat bagi kalian.
                </p>
                <div class="row">
                    @foreach ($posts as $post)
                        @if ($post->status == 'Publish')
                            <div class="col-lg-3">
                                <div class="home-blog-post">
                                    <div class="image">
                                        <img src="{{ asset('/data/post/image/' . $post->image) }}"
                                            style="width: 500px; height: 200px; object-fit:cover;" alt="..."
                                            class="img-fluid" />
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <a href="{{ route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                                class="btn btn-template-outlined-white"><i class="fa fa-chain">
                                                </i> Read More</a>
                                        </div>
                                    </div>
                                    <div class="text">
                                        <h4>
                                            <a href="#">{{ Str::limit($post->title, 30) }}</a>
                                        </h4>
                                        <p class="author-category">
                                            By <a href="#">{{ $post->user->name }}</a> in
                                            @if (isset($post->category->name) != null)
                                                <a href="blog.html">{{ $post->category->name }}</a>
                                            @else
                                                Uncategorized
                                            @endif
                                        </p>
                                        <a href="{{ route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                            class="btn btn-template-outlined">Continue
                                            Reading</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- GET IT-->
    <div class="get-it">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center p-3">
                    <h3>Lihat artikel lebih banyak?</h3>
                </div>
                <div class="col-lg-4 text-center p-3">
                    <a href="{{ route('postingan') }}" class="btn btn-template-outlined-white">Lihat Selengkapnya...</a>
                </div>
            </div>
        </div>
    </div>
@endsection
