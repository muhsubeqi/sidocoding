@extends('admin.layouts.template')
@section('title', 'Admin | Tambah Postingan')
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
                    <h1>Data Postingan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.post') }}">Data Postingan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                    <h3 class="card-title">Tambah Postingan</h3>
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <!-- form start -->
                <form id="quickForm" action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="input" name="title" class="form-control" id="title"
                                placeholder="Masukkan Judul Artikel">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="input" name="slug" class="form-control" id="slug"
                                placeholder="Generate Slug Otomatis" readonly>
                        </div>
                        <div class="form-group">
                            <label for="content">Deskripsi</label>
                            <textarea name="content" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control select2bs4 w-100" name="categories_id" id="category">
                                <option value="">Pilih..</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Gambar</label><br>
                            <img class="profile-user-img img-fluid" id="img-preview"
                                style="width: 300px; height: 200px; object-fit:cover;" alt="Image">
                            <div class="custom-file mt-2">
                                <input type="file" class="custom-file-input" id="image" onchange="previewImage()"
                                    name="image" accept="image/*" capture="camera">
                                <label class="custom-file-label" for="customFile">Pilih file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag">Tags</label>
                            <select class="select2bs4" name="tags[]" multiple="multiple" data-placeholder="Masukkan Tag"
                                style="width: 100%;">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control select2bs4 w-100" name="status" id="status">
                                <option value="">Pilih..</option>
                                @foreach (App\Http\Services\Bulkdata::status as $status)
                                    <option>{{ $status }}</option>
                                @endforeach
                            </select>
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
    {{-- summernote --}}
    <script src="{{ asset('/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        // Generate Slug
        $("#title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });

        //add name to fileinput
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // Summernote
        $('#content').summernote({
            placeholder: 'Tulis Artikel ...',
            tabsize: 2,
            height: 200
        })
    </script>
    <script>
        $(document).ready(function() {
            $("#quickForm").submit(function() {
                if ($(this).valid()) { // in case you have some validation
                    $(this).find(":submit").prop('disabled', true);
                    $("*").css("cursor",
                        "wait"); // in case you want to show a waiting cursor after submit
                }
            });
            $(function() {
                $('#quickForm').validate({
                    rules: {
                        title: {
                            required: true,
                        },
                        slug: {
                            required: true,
                        },
                        image: {
                            extension: "png|jpe?g"
                        },
                        "tags[]": {
                            required: true
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
                        image: {
                            extension: "Hanya bisa format jpg/png"
                        },
                        "tags[]": {
                            required: "Perlu diisi minimal satu",
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
