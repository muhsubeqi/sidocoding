@extends('admin.layouts.template')
@section('title', 'Admin | Dashboard')
@push('css')
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .todo-list li {
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">/ Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                {{ App\Models\Post::count() }}
                            </h3>
                            <p>Data Postingan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>
                                {{ App\Models\Ebook::count() }}
                            </h3>
                            <p>Data Ebook</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>
                                {{ App\Models\Product::count() }}
                            </h3>
                            <p>Data Produk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Info</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-box">
                                    <span class="info-box-icon"><img src="{{ asset('/admin/dist/img/manager.png') }}"
                                            width="200" alt=""></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Selamat Datang di Website Sidocoding,</span>
                                        <span class="info-box-text">Anda masuk dengan akun
                                            <b>{{ auth()->user()['email'] }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Produk Baru Ditambahkan</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $product = App\Models\Product::orderBy('id', 'DESC')
                                                ->limit(10)
                                                ->get();
                                        @endphp
                                        @forelse ($product as $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ @$row->productCategory->name }}</td>
                                                <td><span class="badge badge-secondary">Rp. {{ $row->price }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="4">Tidak ada data produk</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.product') }}" class="btn btn-sm btn-success w-100">Lihat
                                Selengkapnya...</a>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('script')
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (Session::has('success-login'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{!! Session::get('success-login') !!}",
                timer: 5000
            })
        @endif
    </script>
@endpush
