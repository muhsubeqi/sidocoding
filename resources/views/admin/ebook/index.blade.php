@extends('admin.layouts.template')
@section('title', 'Admin | Data Ebook')
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
                    <h1>Data Ebook</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ route('admin.ebook') }}"> / Data Ebook</a>
                        </li>
                    </ol>
                </div>
            </div>
            <a href="{{ route('admin.ebook.create') }}" class="btn btn-primary w-100">
                <i class="fas fa-plus-circle mx-2"></i>Tambah Ebook</a>
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
                                        <th>Cover</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Pemilik</th>
                                        <th>Status</th>
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
                        "searchPlaceholder": "Cari judul buku",
                    },
                    ajax: "{{ route('admin.ebook.list') }}",
                    columns: [{
                            "data": "id",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'align-middle'
                        },
                        {
                            data: 'cover',
                            name: 'cover',
                            className: 'align-middle',
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title',
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
                            data: 'status',
                            name: 'status',
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
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="title"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data postingan\n ' + '"' + name + '"' + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.ebook.delete') }}";
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
