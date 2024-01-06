@extends('admin.layouts.template')
@section('title')
    Admin | Data Kategori
@endsection
@push('css')
    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">/ Data Kategori</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-danger">
                    <h5> <i class="fa fa-info text-danger"></i> PENTING!!!</h5>
                    <p>Hati-hati, jika data kategori terhapus, data yang memakai kategori
                        tersebut, akan di set uncategorized.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data</h3>
                    </div>
                    <form action="#" method="POST" id="form_add" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="name" class="form-control" name="name" id="name"
                                    placeholder="Masukkan Nama">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="slug" class="form-control" name="slug" id="slug"
                                    placeholder="Generate slug otomatis" readonly>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Masukkan Deskripsi"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Gambar</label><br>
                                <img class="profile-user-img img-fluid img-circle" id="img-preview"
                                    style="width: 100px; height: 100px; object-fit:cover;" alt="Image">
                                <div class="custom-file mt-2">
                                    <input type="file" class="custom-file-input" id="image" onchange="previewImage()"
                                        name="image">
                                    <label class="custom-file-label" for="customFile" id="fileInputId">Pilih file</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar</h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        {{-- Modal Edit --}}
        <form action="#" method="POST" enctype="multipart/form-data" id="form_edit">
            @csrf
            <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title_edit">Edit </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id_edit">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name_edit"
                                    placeholder="Input Category Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" class="form-control" id="slug_edit"
                                    placeholder="Input Slug Name" value="{{ old('slug') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description_edit"></textarea>
                            </div>
                            <div class="custom-file mt-2">
                                <input type="hidden" name="image_old" id="image-old" value="{{ old('image') }}">
                                <input type="file" class="custom-file-input" id="image_edit" name="image_edit"
                                    accept="image/png, image/jpeg">
                                <label class="custom-file-label" for="customFile" id="chooseFileEdit">
                                </label>
                                <p id="tes"></p>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@push('script')
    <script src="{{ asset('/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('/admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(function() {

            // otomatic slug generate
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug").val(Text);
            });

            //Upload File
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            // Generate Slug
            $("#name_edit").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug_edit").val(Text);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.category.add') }}";
                var fd = new FormData($(this)[0]);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#table').DataTable().ajax.reload(null, false);
                        swalToast(response.message, response.data);
                        document.getElementById("form_add").reset();
                        $('#image').val('');
                    }
                });
            });

            $('#modal_edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var slug = button.data('slug');
                var description = button.data('description');
                var image = button.data('image');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#name_edit').val(name);
                modal.find('#slug_edit').val(slug);
                modal.find('#description_edit').val(description);
                modal.find('#image-old').val(image);

                if (image) {
                    $('#chooseFileEdit').html(image);
                } else {
                    $('#chooseFileEdit').html('Pilih File');
                }
            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.category.edit') }}";
                var fd = new FormData($(this)[0]);
                $.ajax({
                    type: "post",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modal_edit').modal('toggle');
                        $('#table').DataTable().ajax.reload(null, false);
                        swalToast(response.message, response.data);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        submit();
                    }
                });
                $('#form_add').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        slug: {
                            required: true,
                        },
                        image: {
                            extension: "png|jpe?g"
                        }
                    },
                    messages: {
                        name: {
                            required: "Perlu diisi",
                        },
                        slug: {
                            required: "Perlu Diisi",
                        },
                        image: {
                            extension: "Hanya bisa format jpg/png"
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

            $(function DataTable() {
                var table = $('#table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    "order": [
                        [0, "desc"]
                    ],
                    ajax: "{{ route('admin.category.list') }}",
                    columns: [{
                            "data": "id",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'align-middle'
                        },
                        {
                            data: 'image',
                            name: 'image',
                            className: 'align-middle'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'align-middle'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true,
                            className: 'align-middle'
                        },
                    ]
                });
            });

        });
    </script>
    <script>
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="name"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data kategori dengan nama ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.category.delete') }}";
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#table').DataTable().ajax.reload(null, false);
                            swalToast(response.message, response.data);
                        }
                    });
                }
            })
        }

        function swalToast(message, data) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (message == 200) {
                Toast.fire({
                    icon: 'success',
                    title: data
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data
                });
            }
        }

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
