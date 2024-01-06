@extends('homepage.layouts.template')
@section('title')
    Sidocoding | Ebook
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Semua Ebook</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">All Ebook</li>
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
                        <h2>Kumpulan Ebook Kami</h2>
                    </div>
                    <p class="lead">
                        Selamat datang di website sidocoding, terimakasih sudah memilih
                        untuk belajar dengan kami. berikut kumpulan ebook yang dapat kalian
                        download dan semoga bermanfaat bagi kalian.
                    </p>
                    <div class="panel-body mb-4">
                        <form method="POST">
                            <div class="input-group">
                                <input type="text" placeholder="Search" class="form-control" id="liveSearch">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover bg-light">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="products-big">
                        <div class="row products" id="data-wrapper">

                        </div>
                    </div>
                    <!-- Data Loader -->
                    <div class="auto-load text-center">
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                            viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <path fill="#000"
                                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                    dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#liveSearch').keypress(
                function(event) {
                    if (event.which == '13') {
                        event.preventDefault();
                    }
                });
        });
    </script>
    <script>
        var ENDPOINT = "{{ route('ebook') }}";
        var page = 1;
        infinteLoadMore(page);
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });

        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    if (response.length == 0) {
                        $('.auto-load').html("</br></br>" + "Data Ebook Sudah Tidak Ada lagi :( " + "</br></br>");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#liveSearch').keyup(function() {
                search();
            });

            search();

            function search() {
                var keyword = $('#liveSearch').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: "post",
                    url: "{{ route('ebook.search') }}",
                    data: {
                        keyword: keyword
                    },
                    success: function(response) {
                        showData(response);
                    }
                });
            }

            function showData(res) {
                let htmlView = '';
                if (res.ebooks.length <= 0) {
                    htmlView += ``;
                }
                for (let i = 0; i < res.ebooks.length; i++) {
                    htmlView += `
                        <tr>
                            <td><a href="#"><img src="data/ebook/cover/` + res.ebooks[i].cover + `" alt="" class="img-fluid"></a></td>
                            <td>` + res.ebooks[i].title + `</td>
                            <td><a href="https://drive.google.com/file/d/` + res.ebooks[i].path + `/view" class="btn btn-template-outlined btn-sm" target="_blank">View</a></td>
                        </tr>`;
                }
                $('tbody').html(htmlView);
            }
        });
    </script>
@endpush
