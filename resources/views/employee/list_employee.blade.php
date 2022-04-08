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
                                <a href="{{ route('employee.create') }}" type="button"
                                    class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Tambah Karyawan</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="mydata" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>NPWP</th>
                                        <th>Kontak</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>

    <script>
        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{ route('employee') }}',
                },
                columnDefs: [{
                    "className": "dt-center",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'npwp'
                    },
                    {
                        data: 'no_hp'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'status'
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
