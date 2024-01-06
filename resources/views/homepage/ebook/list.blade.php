@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Daftar Ebook
@endsection
@section('content')
    <div id="heading-breadcrumbs" class="border-top-0 border-bottom-0">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">{{ $category->name }}</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }} </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <!-- LEFT COLUMN _________________________________________________________-->
                <div id="blog-listing-small" class="col-lg-9">
                    <div class="row">
                        @foreach ($listEbook as $le)
                            <div class="col-lg-4 col-md-6">
                                <div class="home-blog-post">
                                    <div class="image">
                                        <img src="{{ asset('/data/ebook/image/' . $le->cover) }}"
                                            style="width: 500px; height: 200px; object-fit:cover;" alt="..."
                                            class="img-fluid" />
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <a href="{{ GoogleDrive::link($ebook->path) }}"
                                                class="btn btn-template-outlined-white"><i class="fa fa-chain"> </i> Read
                                                More</a>
                                        </div>
                                    </div>
                                    <div class="text">
                                        <h4><a href="#" onclick="return false;">{{ Str::limit($le->title, 30) }}</a>
                                        </h4>
                                        <p class="author-category">
                                            By <a href="#">{{ $le->user->name }}</a>
                                        </p>
                                        <a href="{{ GoogleDrive::link($ebook->path) }}"
                                            class="btn btn-template-outlined">Continue
                                            Reading</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <ul class="pager list-unstyled d-flex align-items-center justify-content-between">
                        <li class="previous">
                            <a href="#" class="btn btn-template-outlined">← Older</a>
                        </li>
                        <li class="next disabled">
                            <a href="#" class="btn btn-template-outlined">Newer →</a>
                        </li>
                    </ul> --}}
                </div>
                <!--  RIGHT COLUMN _________________________________________________________-->
                <div class="col-lg-3">
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">{{ $category->name }}</h3>
                        </div>
                        <div class="panel-body text-widget">
                            <p>
                                {{ $category->description }}
                            </p>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Search</h3>
                        </div>
                        <div class="panel-body">
                            <form role="search">
                                <div class="input-group">
                                    <input type="text" placeholder="Search" class="form-control" /><span
                                        class="input-group-btn">
                                        <button type="submit" class="btn btn-template-main">
                                            <i class="fa fa-search"></i></button></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Categories</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                @foreach ($categoryList as $cl)
                                    <li class="nav-item">
                                        <a href="{{ route('ebook.list', ['id' => $cl->id]) }}"
                                            class="nav-link">{{ $cl->name }}</a>
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
