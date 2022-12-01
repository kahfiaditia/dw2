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
                                @if (in_array('97', $session_menu))
                                    <a href="{{ route('stok_obat.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Stok
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
                                        <th>Kode Transaksi</th>
                                        <th>Jumlah Jenis Obat</th>
                                        <th>Jumlah PCS</th>
                                        <th>User Input</th>
                                        <th>Tanggal Input</th>
                                        <th>Aksi</th>
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
        // function toggleCheckbox() {
        //     like = document.getElementById("like").checked;
        //     if (like == true) {
        //         document.getElementById("kode").value = null;
        //         document.getElementById("peminjam").value = null;
        //         document.getElementById("kelas").value = null;
        //         document.getElementById("tgl_start").value = null;
        //         document.getElementById("tgl_end").value = null;
        //         document.getElementById("jml_start").value = null;
        //         document.getElementById("jml_end").value = null;
        //         $('#type').val("").trigger('change')
        //         document.getElementById("id_where").style.display = 'none';
        //         document.getElementById("id_like").style.display = 'block';
        //     } else {
        //         document.getElementById("search_manual").value = null;
        //         document.getElementById("like").checked = false;
        //         document.getElementById("id_like").style.display = 'none';
        //         document.getElementById("id_where").style.display = 'block';
        //     }
        // }

        // function rangeJml() {
        //     let jml_start = document.getElementById("jml_start").value;
        //     let jml_end = document.getElementById("jml_end").value;
        //     if (jml_end < jml_start && jml_end != '') {
        //         Swal.fire(
        //             'Gagal',
        //             'Jumlah awal tidak boleh lebih besar dari jumlah akhir',
        //             'error'
        //         ).then(function() {
        //             document.getElementById("jml_end").value = '';
        //         })
        //     }
        // }

        $(document).ready(function() {
            // like = document.getElementById("like").checked;
            // if (like == true) {
            //     document.getElementById("kode").value = null;
            //     document.getElementById("peminjam").value = null;
            //     document.getElementById("kelas").value = null;
            //     document.getElementById("tgl_start").value = null;
            //     document.getElementById("tgl_end").value = null;
            //     document.getElementById("jml_start").value = null;
            //     document.getElementById("jml_end").value = null;
            //     $('#type').val("").trigger('change')
            //     document.getElementById("id_where").style.display = 'none';
            //     document.getElementById("id_like").style.display = 'block';
            // } else {
            //     document.getElementById("search_manual").value = null;
            //     document.getElementById("like").checked = false;
            //     document.getElementById("id_like").style.display = 'none';
            //     document.getElementById("id_where").style.display = 'block';
            // }

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                // searchDelay: 1000,
                ajax: {
                    url: "{{ route('stok_obat.stok_list') }}",
                    // data: function(d) {
                    //     d.search = $('input[type="search"]').val()
                    // }
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
                        data: 'kode_transaksi',
                        name: 'kode_transaksi'
                    },
                    {
                        data: 'jml_jenis_obat',
                        name: 'jml_jenis_obat'
                    },
                    {
                        data: 'jml',
                        name: 'jml'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    // {
                    //     data: 'ed',
                    //     name: 'ed'
                    // },
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
