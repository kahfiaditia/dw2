@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
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
                                @if (in_array('36', $session_menu))
                                    <a href="{{ route('invoice.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Pembayaran
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
                            <table id="table" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Siswa</th>
                                        <th class="text-center">Biaya</th>
                                        <th class="text-center">Diskon Pembayaran</th>
                                        <th class="text-center">Diskon Prestasi</th>
                                        <th>Total</th>
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
    <style>
        .right {
            text-align: right;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('invoice.list_invoice') }}",
                },
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'no_invoice',
                        name: 'no_invoice',
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'siswa',
                        name: 'siswa',
                    },
                    {
                        data: 'pembayaran',
                        name: 'pembayaran',
                        render: $.fn.dataTable.render.number(',', '.'),
                        className: "right"
                    },
                    {
                        data: 'diskon_pembayaran',
                        name: 'diskon_pembayaran',
                        render: $.fn.dataTable.render.number(',', '.'),
                        className: "right"
                    },
                    {
                        data: 'diskon_prestasi',
                        name: 'diskon_prestasi',
                        render: $.fn.dataTable.render.number(',', '.'),
                        className: "right"
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total',
                        render: $.fn.dataTable.render.number(',', '.'),
                        className: "right"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
