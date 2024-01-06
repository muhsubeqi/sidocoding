@extends('admin.layouts.template')
@section('title', 'Admin | Data Produk')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex flex-row">
                    <h1>Data Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ route('admin.product') }}"> / Data Produk</a>
                        </li>
                    </ol>
                </div>
            </div>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary w-100">
                <i class="fas fa-plus-circle mx-2"></i>Tambah Produk</a>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Pemilik</th>
                                        <th>Harga</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
                                <label for="file">Upload File Buku</label><br>
                                <input type="input" name="file" class="form-control" id="file"
                                    placeholder="Masukkan Alamat Url File" value="{{ old('file') }}">
                                <small>*Gunakan url seperti https://linkfilekamu</small>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{!! Session::get('success') !!}",
                timer: 3000
            })
        @endif
        @if (Session::has('failed'))
            Swal.fire({
                icon: 'error',
                title: 'Success',
                text: "{!! Session::get('failed') !!}",
                timer: 3000
            })
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $(function DataTable() {
                var table = $('#table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    "order": [
                        [0, "desc"]
                    ],
                    "language": {
                        "search": '<i class="fa fa-search"></i>',
                        "searchPlaceholder": "Cari judul produk",
                    },
                    ajax: "{{ route('admin.product.list') }}",
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
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'align-middle'
                        },
                        {
                            data: 'kategori',
                            name: 'kategori',
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'pemilik',
                            name: 'pemilik',
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'price',
                            name: 'price',
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'file',
                            name: 'file',
                            className: 'align-middle',
                            searchable: false
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
        $(document).ready(function() {
            $('#modal_edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var file = button.data('file');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#file').val(file);

            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.product.editFile') }}";
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
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var productName = event.target.querySelector('input[name="name"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data postingan\n ' + '"' + productName + '"' + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.product.delete') }}";
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
    </script>
@endpush
