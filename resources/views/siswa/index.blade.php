@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-left">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @if (Auth::user()->roles == 'Siswa' || Auth::user()->student == null)
                                    <a href="{{ route('siswa.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Siswa
                                    </a>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="mydata" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{ route('siswa.index') }}',
                },
                columnDefs: [{
                    "className": "text-center",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'nisn'
                    },
                    {
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'Opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endsection
