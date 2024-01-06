@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Tutorial
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Tutorial</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Tutorial</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row text-center mt-4">
                <div class="col-md-12">
                    <div class="heading text-center">
                        <h2>Tutorial</h2>
                    </div>
                    <p class="lead">
                        List tutorial pemrograman terlengkap bahasa indonesia dari dasar
                    </p>
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-3">
                                <div class="card" style="border-radius: 20px">
                                    <div class="card-body">
                                        <img src="{{ asset('/data/category/image/' . $category->image) }}"
                                            style="width: 100px; object-fit:cover" alt="Image" />
                                        <h5 class="card-title mt-2">{{ $category->name }}</h5>
                                        <a href="{{ route('tutorial.list', ['id' => $category->id]) }}"
                                            class="btn btn-primary" style="border-radius: 20px">Belajar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
