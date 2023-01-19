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
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Rekap Perpus</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rekap_perpus.rekap_perpus_siswa') }}"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Rekap Perpus Per-Siswa</span>
                                    </a>
                                </li>
                            </ul>
                            <br>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium <?php if (isset($_GET['kode'])) {
                                        } else {
                                            echo 'collapsed';
                                        } ?>" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <i class="bx bx-search-alt font-size-18"></i>
                                            <b>Cari & Unduh Data</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse <?php
                                    if (empty($_GET['like']) and (isset($_GET['kode']) or isset($_GET['nama']) or isset($_GET['jml']) or isset($_GET['tgl_start_pinjam']) or isset($_GET['tgl_end_pinjam']) or isset($_GET['tgl_start_kembali']) or isset($_GET['tgl_end_kembali']))) {
                                        if ($_GET['kode'] != null or $_GET['nama'] != null or $_GET['jml'] != null or $_GET['tgl_start_pinjam'] != null or $_GET['tgl_end_pinjam'] != null or $_GET['tgl_start_kembali'] != null or $_GET['tgl_end_kembali'] != null) {
                                            echo 'show';
                                        }
                                    }
                                    if (isset($_GET['like'])) {
                                        if ($_GET['like'] != null) {
                                            echo 'show';
                                        }
                                    } ?>"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                <form>
                                                    <div class="row" id="id_where">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-2 mb-2">
                                                                    <input type="text" name="kode" id="kode"
                                                                        value="{{ isset($_GET['kode']) ? $_GET['kode'] : null }}"
                                                                        class="form-control" placeholder="Kode">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="nama" id="nama"
                                                                        value="{{ isset($_GET['nama']) ? $_GET['nama'] : null }}"
                                                                        class="form-control" placeholder="Nama">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="buku" id="buku"
                                                                        value="{{ isset($_GET['buku']) ? $_GET['buku'] : null }}"
                                                                        class="form-control" placeholder="Buku">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="jml" id="jml"
                                                                        value="{{ isset($_GET['jml']) ? $_GET['jml'] : null }}"
                                                                        class="form-control" placeholder="Jumlah">
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                        data-date-autoclose="true" data-provide="datepicker"
                                                                        data-date-container='#datepicker6'>
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_start_pinjam" id="tgl_start_pinjam"
                                                                            value="{{ isset($_GET['tgl_start_pinjam']) ? $_GET['tgl_start_pinjam'] : null }}"
                                                                            placeholder="Tanggal Pinjam" />
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_end_pinjam" id="tgl_end_pinjam"
                                                                            value="{{ isset($_GET['tgl_end_pinjam']) ? $_GET['tgl_end_pinjam'] : null }}"
                                                                            placeholder="Tanggal Pinjam" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                        data-date-autoclose="true"
                                                                        data-provide="datepicker"
                                                                        data-date-container='#datepicker6'>
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_start_kembali"
                                                                            id="tgl_start_kembali"
                                                                            value="{{ isset($_GET['tgl_start_kembali']) ? $_GET['tgl_start_kembali'] : null }}"
                                                                            placeholder="Tanggal Kembali" />
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_end_kembali" id="tgl_end_kembali"
                                                                            value="{{ isset($_GET['tgl_end_kembali']) ? $_GET['tgl_end_kembali'] : null }}"
                                                                            placeholder="Tanggal Kembali" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="id_like" style="display: none">
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="search_manual" id="search_manual"
                                                                value="{{ isset($_GET['search_manual']) ? $_GET['search_manual'] : null }}"
                                                                class="form-control" placeholder="Search">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2 mb-2">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" name="like"
                                                                    type="checkbox" id="like"
                                                                    value="{{ isset($_GET['like']) ? 'search' : 'default' }}"
                                                                    {{ isset($_GET['like']) ? 'checked' : null }}
                                                                    onclick="toggleCheckbox()">
                                                                <label class="form-check-label" for="like">
                                                                    Like semua data
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-10 mb-2">
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Cari</button>
                                                            <a href="{{ route('rekap_perpus.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $nama = $_GET['nama'];
                                                                $buku = $_GET['buku'];
                                                                $jml = $_GET['jml'];
                                                                $tgl_start_pinjam = $_GET['tgl_start_pinjam'];
                                                                $tgl_end_pinjam = $_GET['tgl_end_pinjam'];
                                                                $tgl_start_kembali = $_GET['tgl_start_kembali'];
                                                                $tgl_end_kembali = $_GET['tgl_end_kembali'];
                                                                $search_manual = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route(
                                                                    'rekap_perpus.export_rekap_perpus',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&nama=' .
                                                                        $nama .
                                                                        '&buku=' .
                                                                        $buku .
                                                                        '&jml=' .
                                                                        $jml .
                                                                        '&tgl_start_pinjam=' .
                                                                        $tgl_start_pinjam .
                                                                        '&tgl_end_pinjam=' .
                                                                        $tgl_end_pinjam .
                                                                        '&tgl_start_kembali=' .
                                                                        $tgl_start_kembali .
                                                                        '&tgl_end_kembali=' .
                                                                        $tgl_end_kembali .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @else
                                                                <a href="{{ route('rekap_perpus.export_rekap_perpus') }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table id="table" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Peminjam</th>
                                        <th>Nama</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Estimasi Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Buku</th>
                                        <th>Jumlah</th>
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
        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("siswa").value = null;
                document.getElementById("gejala").value = null;
                document.getElementById("kategori").value = null;
                document.getElementById("obat").value = null;
                document.getElementById("qty").value = null;
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search_manual").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        }

        $(document).ready(function() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("siswa").value = null;
                document.getElementById("gejala").value = null;
                document.getElementById("kategori").value = null;
                document.getElementById("obat").value = null;
                document.getElementById("qty").value = null;
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search_manual").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: {
                    url: "{{ route('rekap_perpus.rekap_perpus_list') }}",
                    data: function(d) {
                        d.kode = (document.getElementById("kode").value.length != 0) ? document
                            .getElementById(
                                "kode").value : null;
                        d.nama = (document.getElementById("nama").value.length != 0) ? document
                            .getElementById(
                                "nama").value : null;
                        d.buku = (document.getElementById("buku").value.length != 0) ? document
                            .getElementById(
                                "buku").value : null;
                        d.jml = (document.getElementById("jml").value.length != 0) ?
                            document
                            .getElementById(
                                "jml").value : null;
                        d.tgl_start_pinjam = (document.getElementById("tgl_start_pinjam").value
                                .length != 0) ? document
                            .getElementById(
                                "tgl_start_pinjam").value : null;
                        d.tgl_end_pinjam = (document.getElementById("tgl_end_pinjam").value.length !=
                                0) ?
                            document
                            .getElementById(
                                "tgl_end_pinjam").value : null;
                        d.tgl_start_kembali = (document.getElementById("tgl_start_kembali").value
                                .length != 0) ?
                            document
                            .getElementById(
                                "tgl_start_kembali").value : null;
                        d.tgl_end_kembali = (document.getElementById("tgl_end_kembali").value.length !=
                                0) ? document
                            .getElementById(
                                "tgl_end_kembali").value : null;
                        d.like = (document.getElementById("like").value.length != 0) ? document
                            .getElementById(
                                "like").value : null;
                        d.search_manual = (document.getElementById("search_manual").value.length != 0) ?
                            document
                            .getElementById(
                                "search_manual").value : null;
                        d.search = $('input[type="search"]').val()
                    }
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
                        data: 'peminjam',
                        name: 'peminjam'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tgl_pinjam',
                        name: 'tgl_pinjam'
                    },
                    {
                        data: 'tgl_perkiraan_kembali',
                        name: 'tgl_perkiraan_kembali'
                    },
                    {
                        data: 'tgl_kembali',
                        name: 'tgl_kembali'
                    },
                    {
                        data: 'buku',
                        name: 'buku'
                    },
                    {
                        data: 'jml',
                        name: 'jml'
                    },
                ]
            });
        });
    </script>
@endsection
