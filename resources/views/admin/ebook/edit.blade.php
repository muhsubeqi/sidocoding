@extends('admin.layouts.template')
@section('title', 'Admin | Edit Ebook')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Summernote --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Ebook</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.ebook') }}">Data Ebook</a></li>
                        <li class="breadcrumb-item active">Edit Ebook</li>
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
                    <h3 class="card-title">Edit Ebook</h3>
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <!-- form start -->
                <form id="quickForm" action="{{ route('admin.ebook.update', ['id' => $ebook->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="input" name="title" class="form-control" id="title"
                                value="{{ $ebook->title }}" placeholder="Masukkan Judul Buku">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="input" name="slug" class="form-control" id="slug"
                                placeholder="Generate Slug Otomatis" value="{{ $ebook->slug }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control select2bs4 w-100" name="categories_id" id="category">
                                <option value="">Pilih..</option>
                                @foreach ($categories as $category)
                                    @php
                                        $categoryEbook = !empty($ebook->category->name) ? $ebook->category->name : '';
                                    @endphp
                                    @if ($category->name == $categoryEbook)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description">{{ $ebook->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Link mockup untuk convert 3D Ebook</label>
                            <p><a href="https://diybookcovers.com/3Dmockups/"
                                    target="_blank">https://diybookcovers.com/3Dmockups/</a></p>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Cover Buku</label><br>
                            @if ($ebook->cover)
                                <img src="{{ asset("data/ebook/cover/$ebook->cover") }}" class="profile-user-img img-fluid"
                                    id="img-preview" style="width: 100px; height: 100px; object-fit:cover;"
                                    alt="User Image">
                            @else
                                <img class="profile-user-img img-fluid" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="User Image">
                            @endif
                            <div class="custom-file mt-2">
                                <input type="hidden" name="cover_lama" value="{{ $ebook->cover }}">
                                <input type="file" class="custom-file-input" id="image" onchange="previewImage()"
                                    name="cover" accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="customFile">Pilih Cover Ebook</label>
                                <small>*Kosongkan jika tidak ingin mengubah gambar</small>
                                <small>*Pastikan cover ebook yang di upload sudah di mockup 3D Ebook</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload File Buku</label><br>
                            @if ($ebook->cover)
                                <img src="{{ asset('visitor/img/my-image/pdf.png') }}" id="img-preview"
                                    style="width: 55px; height: 70px;" alt="Ebook Image">
                            @endif
                            <div class="custom-file mt-2">
                                <input type="hidden" name="file_lama" value="{{ $ebook->file }}">
                                <input type="file" class="custom-file-input" id="file" name="file">
                                <label class="custom-file-label" for="customFile">Pilih file Ebook</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control select2bs4 w-100" name="status" id="status">
                                <option value="">Pilih..</option>
                                @foreach (App\Http\Services\BulkData::statusEbook as $status)
                                    @if ($status == $ebook->status)
                                        <option selected>{{ $status }}</option>
                                    @else
                                        <option>{{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small>*Gunakan status "Premium" jika ebook yang di bagikan harus berbayar
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100">Save</button>
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
    <!-- InputMask -->
    <script src="{{ asset('/admin/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    {{-- summernote --}}
    <script src="{{ asset('/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //add name to fileinput
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        // Summernote
        $('#description').summernote({
            placeholder: 'Tulis Deskripsi Ebook ...',
            tabsize: 2,
            height: 200
        })
        // Generate Slug
        $("#title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });
    </script>

    <script>
        $(document).ready(function() {
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
                        title: {
                            required: true,
                        },
                        slug: {
                            required: true,
                        },
                        cover: {
                            extension: "png|jpe?g"
                        },
                        file: {
                            extension: "pdf"
                        },
                        status: {
                            required: true,
                        },
                    },
                    messages: {
                        title: {
                            required: "Perlu diisi",
                        },
                        slug: {
                            required: "Perlu diisi",
                        },
                        cover: {
                            extension: "Hanya bisa format jpg/png"
                        },
                        file: {
                            extension: "Hanya bisa format pdf"
                        },
                        status: {
                            required: "Pilih salah satu",
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
        });
    </script>
    <script>
        function previewImage() {
            const image = document.querySelector("#image");
            const imgPreview = document.querySelector("#img-preview");
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
@endpush
