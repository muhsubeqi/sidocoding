@extends('admin.layouts.template')
@section('title', 'Admin | Edit Produk')
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
                    <h1>Data Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Data Produk</a></li>
                        <li class="breadcrumb-item active">Edit Produk</li>
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
                    <h3 class="card-title">Edit Produk</h3>
                    <div class="card-tools">
                        <!-- Maximize Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <!-- form start -->
                <form id="quickForm" action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ $product->name }}" placeholder="Masukkan Nama Produk">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug"
                                placeholder="Generate Slug Otomatis" value="{{ $product->slug }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control select2bs4 w-100" name="product_categories_id" id="category">
                                <option value="">Pilih..</option>
                                @foreach ($productCategories as $row)
                                    @php
                                        $categoryProduct = !empty($product->productCategory->name) ? $product->productCategory->name : '';
                                    @endphp
                                    @if ($row->name == $categoryProduct)
                                        <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            <input type="text" name="price" class="form-control" id="price"
                                value="{{ $product->price }}" placeholder="Masukkan Harga Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Gambar Produk</label><br>
                            @if ($product->image)
                                <img src="{{ asset("data/product/image/$product->image") }}"
                                    class="profile-user-img img-fluid" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="Product Image">
                            @else
                                <img class="profile-user-img img-fluid" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="Product Image">
                            @endif
                            <div class="custom-file mt-2">
                                <input type="hidden" name="image_lama" value="{{ $product->image }}">
                                <input type="file" class="custom-file-input" id="image" onchange="previewImage()"
                                    name="image" accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="customFile">Pilih file</label>
                                <small>*Kosongkan jika tidak ingin mengubah gambar</small>
                            </div>
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
        $("#name").keyup(function() {
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
                        name: {
                            required: true,
                        },
                        slug: {
                            required: true,
                        },
                        price: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "Perlu diisi",
                        },
                        slug: {
                            required: "Perlu diisi",
                        },
                        price: {
                            required: "Pilih diisi",
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
