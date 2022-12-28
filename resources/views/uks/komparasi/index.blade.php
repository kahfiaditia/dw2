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
                                @if (in_array('109', $session_menu))
                                    @if ($count > 0 or $count_manual > 0)
                                        <button type="button"
                                            class="float-end btn btn-secondary btn-rounded waves-effect waves-light mb-2 me-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                            data-bs-original-title="Wajib Stok Opame Semua dan Tambah Stok Manual">
                                            Menyesuaikan Stok
                                        </button>
                                    @else
                                        <button type="button" onclick="hitungKomparasi()"
                                            class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 hitungKomparasi">
                                            <i class="mdi mdi-refresh me-1"></i> Menyesuaikan Stok
                                        </button>
                                    @endif
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
                                        <th>Obat</th>
                                        <th>Jenis Obat</th>
                                        <th>Jml Opname</th>
                                        <th>Jml Sistem</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                        <th>User Input</th>
                                        <th>Tgl Input</th>
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
    <script type="text/javascript">
        function hitungKomparasi() {
            Swal.fire({
                title: 'Menyesuaikan Stok',
                text: "Ingin Menyesuaikan Stok sesuai Selisih?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#6e7d88',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('komparasi.hitung_komparasi') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: response => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    `${response.message}`,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                })
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    `${response.message}`,
                                    'error',
                                )
                            }
                        },
                        error: (err) => {
                            console.log(err);
                        },
                    });
                }
            })
        }

        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: {
                    url: "{{ route('komparasi.komparasi_list') }}",
                },
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'obat',
                        name: 'obat'
                    },
                    {
                        data: 'jenis_obat',
                        name: 'jenis_obat'
                    },
                    {
                        data: 'jml_opname',
                        name: 'jml_opname'
                    },
                    {
                        data: 'jml_sistem',
                        name: 'jml_sistem'
                    },
                    {
                        data: 'selisih',
                        name: 'selisih'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ]
            });
        });
    </script>
@endsection
