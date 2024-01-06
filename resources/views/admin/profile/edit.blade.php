@extends('admin.layouts.template')
@section('title', 'User | Edit Pegawai')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Profil</h3>
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <!-- form start -->
                <form id="quickForm" action="{{ route('admin.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="input" name="name" class="form-control" id="name"
                                placeholder="Masukkan nama" value="{{ $dataUser->user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Enter email" value="{{ $dataUser->user->email }}">
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="input" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                        placeholder="Masukkan tempat lahir" value="{{ $dataUser->tempat_lahir }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tanggal-lahir">Tanggal Lahir</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input"
                                            data-target="#reservationdate" name="tanggal_lahir" id="tanggal_lahir"
                                            placeholder="Pilih tanggal lahir" value="{{ $dataUser->tanggal_lahir }}" />
                                        <div class="input-group-append" data-target="#reservationdate"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control select2bs4 w-100" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">Pilih..</option>
                                @foreach (App\Http\Services\BulkData::jenisKelamin as $jk)
                                    @if ($jk == $dataUser->jenis_kelamin)
                                        <option selected>{{ $jk }}
                                        @else
                                        <option>{{ $jk }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alat">Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan alamat" name="alamat" id="alamat">{!! $dataUser->alamat !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomer Telepon</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="number" class="form-control" name="phone" id="phone"
                                    value="{{ $dataUser->phone }}">
                            </div>
                            <small>*Gunakan format seperti : 6285xxxxxxx</small>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label><br>
                            @php
                                $photo = $dataUser->user->photo;
                            @endphp
                            @if ($dataUser->user->photo)
                                <img src="{{ asset("/data/user/image/$photo") }}"
                                    class="profile-user-img img-fluid img-circle" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="User Image">
                            @else
                                <img class="profile-user-img img-fluid img-circle" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="User Image">
                            @endif
                            <div class="custom-file mt-2">
                                <input type="hidden" name="foto_lama" value="{{ $dataUser->user->photo }}">
                                <input type="file" class="custom-file-input" onchange="previewPhoto()" id="photo"
                                    name="photo" accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="collapse" id="f_password">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control " id="password"
                                    placeholder="Masukkan password" disabled>
                            </div>
                            <div class="form-group">
                                <label for="konfirmasi_password">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control"
                                    id="konfirmasi_password" placeholder="Masukkan ulang password" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a class="btn btn-warning text-light w-100 mb-2" data-toggle="collapse" href="#f_password"
                            role="button" aria-expanded="false" aria-controls="collapseExample"
                            onclick="showPassword()">
                            Ubah Password
                        </a>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <!-- jquery-validation -->
    <script src="{{ asset('/admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- daterange picker -->
    <script src="{{ asset('/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD-MM-yyyy'
        });
        //phone mask
        $('[data-mask]').inputmask()

        //add name to fileinput
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    <script>
        $(function() {
            $("#quickForm").submit(function() {
                if ($(this).valid()) { // in case you have some validation
                    $(this).find(":submit").prop('disabled', true);
                    $("*").css("cursor",
                        "wait"); // in case you want to show a waiting cursor after submit
                }
            });
            $('#quickForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    konfirmasi_password: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    password: {
                        required: 'Password tidak boleh kosong',
                        minlength: 'Minimal 8 karakter'
                    },
                    konfirmasi_password: {
                        required: 'Konfirmasi tidak boleh kosong',
                        equalTo: 'Password tidak sama'
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

    <script>
        var checkCollapse = true;

        function showPassword() {
            if (checkCollapse) {
                $('#password').attr("disabled", false);
                $('#konfirmasi_password').attr("disabled", false);
                checkCollapse = false;
            } else {
                $('#password').attr("disabled", true);
                $('#konfirmasi_password').attr("disabled", true);
                checkCollapse = true;
            }
        }

        function previewPhoto() {
            const photo = document.querySelector("#photo");
            const imgPreview = document.querySelector("#img-preview");

            const oFReader = new FileReader();
            oFReader.readAsDataURL(photo.files[0]);
            // oFReader.onLoad = function(oFREvent) {
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
@endpush
