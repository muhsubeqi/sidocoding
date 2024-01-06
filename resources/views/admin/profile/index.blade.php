@extends('admin.layouts.template')
@section('title', 'Admin | Profil')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">/ Profil</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success</h5>
                    {!! Session::get('message') !!}
                </div>
            @endif
            @if (Session::has('failed'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Failed</h5>
                    {!! Session::get('message') !!}
                </div>
            @endif
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Update Profil</a>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset("/data/user/image/$photo") }}"
                            style="width: 100px;height:100px;object-fit:cover" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->user->name }}</h3>

                    <p class="text-muted text-center mb-0">{{ $user->user->email }}</p>
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-primary text-center">
                    {{ $user->phone }}
                </div>
                <!-- About Me Box -->
                <div class="card card-primary mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong>Nomor Telephone</strong>
                        <p class="text-muted">{{ $user->phone }}</p>
                        <hr>
                        <strong>Jenis Kelamin</strong>
                        <p class="text-muted">{{ $user->jenis_kelamin }}</p>
                        <hr>
                        <strong>Tempat, Tanggal Lahir</strong>
                        <p class="text-muted">{{ $user->ttl }}</p>
                        <hr>
                        <strong>Umur</strong>
                        <p class="text-muted">{{ $umur }}</p>
                        <hr>
                        <strong>Alamat</strong>
                        <p class="text-muted">{{ $user->alamat }}</p>
                        <hr>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
