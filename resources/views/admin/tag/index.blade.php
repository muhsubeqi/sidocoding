@extends('admin.layouts.template')
@section('title')
    Admin | Data Tags
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
                    <h1 class="m-0">Data Tags</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tags') }}">/ Data Tags</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah</h3>
                    </div>
                    <form action="#" method="POST" id="form_add" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <div class="row">
                                    <div class="col-lg-10 col-10">
                                        <input type="name" class="form-control" name="name[]" id="name"
                                            placeholder="Masukkan nama" required>
                                    </div>
                                    <div class="col-lg-2 col-2">
                                        <button type="button" class="btn btn-success" id="add"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div id="addTags"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar</h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
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
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" id="name_edit"
                                    placeholder="Input Category Name" value="{{ old('name') }}" required>
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
@endsection
@push('script')
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
        $(document).ready(function() {
            var i = 0
            $('#add').click(function() {
                ++i;
                var content = `
                    <div class="row form mt-2">
                        <div class="col-md-10 col-10">
                            <input type="name" class="form-control" name="name[]" id="name"
                                placeholder="Masukkan nama" required>
                        </div>
                        <div class="col-md-2 col-2">
                            <a class="btn btn-danger" id="deleteTags"><i
                                    class="fa fa-minus"></i></a>
                        </div>
                    </div>
                `;
                $('#addTags').append(content);
            });

            $(document).on('click', '#deleteTags', function() {
                $(this).parents('.form').remove();
            });

            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.tags.add') }}";
                var fd = new FormData($(this)[0]);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addTags').empty();
                        $('#name').val('');
                        $('#table').DataTable().ajax.reload(null, false);
                        swalToast(response.message, response.data);

                    }
                });
            });

            $('#modal_edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#name_edit').val(name);
            })

            $('#form_edit').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.tags.edit') }}";
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

            $(function DataTable() {
                var table = $('#table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    "order": [
                        [0, "desc"]
                    ],
                    ajax: "{{ route('admin.tags.list') }}",
                    columns: [{
                            "data": "id",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
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
                title: 'Yakin menghapus data ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.tags.delete') }}";
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
