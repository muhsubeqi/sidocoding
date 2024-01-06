@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Detail Postingan
@endsection
@push('css')
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush
@section('content')
    <div id="heading-breadcrumbs" class="border-top-0 border-bottom-0">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-12">
                    <ul class="breadcrumb d-flex justify-content-start">
                        <li class="breadcrumb-item active">{{ $post->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <!-- LEFT COLUMN _________________________________________________________-->
                <div id="blog-post" class="col-md-9">
                    <p class="text-muted text-uppercase mb-small text-right text-sm">
                        By <a href="#">{{ $post->user->name }}</a> |
                        {{ date('d M Y', strtotime($post->updated_at)) }}
                    </p>
                    <div id="post-content">
                        <p style="text-align: center">
                            <img src="{{ asset('/data/post/image/' . $post->image) }}" alt="Example blog post alt"
                                class="img-fluid" />
                        </p>
                        <h2>{{ $post->title }}</h2>
                        <p>{!! $post->content !!}</p>

                    </div>
                    <div id="comments">
                        <h4 class="text-uppercase">{{ count($jmlComment) }} comments</h4>
                        @foreach ($comments as $comment)
                            @if ($comment->confirm == 'Setuju')
                                <div class="row comment">
                                    <div class="col-sm-3 col-md-2 text-center-xs">
                                        <p>
                                            <img src="{{ asset('/admin/dist/img/avatar5.png') }}" alt=""
                                                class="img-fluid rounded-circle" />
                                        </p>
                                    </div>
                                    <div class="col-sm-9 col-md-10">
                                        <h5 class="text-uppercase">{{ $comment->name }}</h5>
                                        <p class="posted">
                                            <i class="fa fa-clock-o"></i>
                                            {{ date('d M Y', strtotime($comment->updated_at)) }}
                                        </p>
                                        <p>
                                            {{ $comment->comment }}
                                        </p>
                                        <p class="reply">
                                            <a href="#name"><i class="fa fa-reply"></i> Reply</a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if (session()->has('posts_id') == $post->id)
                            <div class="row comment" style="opacity:0.5">
                                <div class="col-sm-3 col-md-2 text-center-xs">
                                    <p>
                                        <img src="{{ asset('/admin/dist/img/avatar5.png') }}" alt=""
                                            class="img-fluid rounded-circle" />
                                    </p>
                                </div>
                                <div class="col-sm-9 col-md-10">
                                    <small><i>Komentar anda sedang menunggu persetujuan.</i></small>
                                    <h5 class="text-uppercase">{{ session('name') }}</h5>
                                    <p>
                                        {{ session('comment') }}
                                    </p>
                                    <p class="reply">
                                        <a href="#name"><i class="fa fa-reply"></i> Reply</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="comment-form">
                        <h4 class="text-uppercase">Leave a comment</h4>
                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="posts_id" value="{{ $post->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name
                                            <span class="required text-primary">*</span></label>
                                        <input id="name" name="name" type="text" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email
                                            <span class="required text-primary">*</span></label>
                                        <input id="email" name="email" type="text" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="comment">Comment
                                            <span class="required text-primary">*</span></label>
                                        <textarea id="comment" name="comment" rows="4" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-template-outlined">
                                        <i class="fa fa-comment-o"></i> Post comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- RIGH COLUMN --}}
                <div class="col-md-3">
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
                            <h3 class="h4 panel-title">Tutorial {{ $getNameCategory }}</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($listPost as $lp)
                                    @if (isset($lp))
                                        <li class="nav-item">
                                            <a href="{{ route('postingan.detail', ['id' => $lp->id, 'slug' => $lp->slug]) }}"
                                                class="nav-link">{{ $i++ }}. {{ $lp->title }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Categories</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                @foreach ($categories as $category)
                                    @if (isset($category))
                                        <li class="nav-item">
                                            <a href="{{ route('tutorial.list', ['id' => $category->id]) }}"
                                                class="nav-link"> {{ $category->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="panel sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Tags</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="tag-cloud list-inline">
                                @foreach ($getTags as $tag)
                                    @if (isset($tag))
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-tags"></i> {{ $tag->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{!! Session::get('success') !!}",
                timer: 5000
            })
        @endif
        @if (Session::has('failed'))
            Swal.fire({
                icon: 'failed',
                title: 'failed',
                text: "{!! Session::get('failed') !!}",
                timer: 5000
            })
        @endif
    </script>
@endpush
