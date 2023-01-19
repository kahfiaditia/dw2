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
                                        <span class="d-none d-sm-block">Rekap Medis</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rekap_medis.rekap_medis_siswa') }}" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Rekap Medis Per-Siswa</span>
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
                                    if (empty($_GET['like']) and (isset($_GET['kode']) or isset($_GET['siswa']) or isset($_GET['gejala']) or isset($_GET['kategori']) or isset($_GET['obat']) or isset($_GET['qty']) or isset($_GET['tgl_start']) or isset($_GET['tgl_end']))) {
                                        if ($_GET['kode'] != null or $_GET['siswa'] != null or $_GET['gejala'] != null or $_GET['kategori'] != null or $_GET['obat'] != null or $_GET['qty'] != null or $_GET['tgl_start'] != null or $_GET['tgl_end'] != null) {
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
                                                                    <input type="text" name="siswa" id="siswa"
                                                                        value="{{ isset($_GET['siswa']) ? $_GET['siswa'] : null }}"
                                                                        class="form-control" placeholder="Siswa">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="gejala" id="gejala"
                                                                        value="{{ isset($_GET['gejala']) ? $_GET['gejala'] : null }}"
                                                                        class="form-control" placeholder="Gejala">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kategori" id="kategori"
                                                                        value="{{ isset($_GET['kategori']) ? $_GET['kategori'] : null }}"
                                                                        class="form-control" placeholder="Kategori">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="obat" id="obat"
                                                                        value="{{ isset($_GET['obat']) ? $_GET['obat'] : null }}"
                                                                        class="form-control" placeholder="Obat">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="qty" id="qty"
                                                                        value="{{ isset($_GET['qty']) ? $_GET['qty'] : null }}"
                                                                        class="form-control" placeholder="Jumlah">
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                        data-date-autoclose="true"
                                                                        data-provide="datepicker"
                                                                        data-date-container='#datepicker6'>
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_start" id="tgl_start"
                                                                            value="{{ isset($_GET['tgl_start']) ? $_GET['tgl_start'] : null }}"
                                                                            placeholder="Tanggal " />
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_end" id="tgl_end"
                                                                            value="{{ isset($_GET['tgl_end']) ? $_GET['tgl_end'] : null }}"
                                                                            placeholder="Tanggal" />
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
                                                            <a href="{{ route('rekam_medis.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $siswa = $_GET['siswa'];
                                                                $gejala = $_GET['gejala'];
                                                                $kategori = $_GET['kategori'];
                                                                $obat = $_GET['obat'];
                                                                $qty = $_GET['qty'];
                                                                $tgl_start = $_GET['tgl_start'];
                                                                $tgl_end = $_GET['tgl_end'];
                                                                $search_manual = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route(
                                                                    'rekam_medis.export_rekam_medis',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&siswa=' .
                                                                        $siswa .
                                                                        '&gejala=' .
                                                                        $gejala .
                                                                        '&kategori=' .
                                                                        $kategori .
                                                                        '&obat=' .
                                                                        $obat .
                                                                        '&qty=' .
                                                                        $qty .
                                                                        '&tgl_start=' .
                                                                        $tgl_start .
                                                                        '&tgl_end=' .
                                                                        $tgl_end .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @else
                                                                <a href="{{ route('rekam_medis.export_rekam_medis') }}"
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
                                        <th>Kode Perawatan</th>
                                        <th>Siswa</th>
                                        <th>Gejala</th>
                                        <th>Kategori</th>
                                        <th>Obat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
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
                    url: "{{ route('rekam_medis.rekam_medis_list') }}",
                    data: function(d) {
                        d.kode = (document.getElementById("kode").value.length != 0) ? document
                            .getElementById(
                                "kode").value : null;
                        d.siswa = (document.getElementById("siswa").value.length != 0) ? document
                            .getElementById(
                                "siswa").value : null;
                        d.gejala = (document.getElementById("gejala").value.length != 0) ? document
                            .getElementById(
                                "gejala").value : null;
                        d.kategori = (document.getElementById("kategori").value.length != 0) ?
                            document
                            .getElementById(
                                "kategori").value : null;
                        d.obat = (document.getElementById("obat").value.length != 0) ? document
                            .getElementById(
                                "obat").value : null;
                        d.qty = (document.getElementById("qty").value.length != 0) ?
                            document
                            .getElementById(
                                "qty").value : null;
                        d.tgl_start = (document.getElementById("tgl_start").value.length != 0) ?
                            document
                            .getElementById(
                                "tgl_start").value : null;
                        d.tgl_end = (document.getElementById("tgl_end").value.length != 0) ? document
                            .getElementById(
                                "tgl_end").value : null;
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
                        data: 'kode_perawatan',
                        name: 'kode_perawatan'
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap'
                    },
                    {
                        data: 'gejala',
                        name: 'gejala'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'obat',
                        name: 'obat'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'tgl',
                        name: 'tgl'
                    },
                    {
                        data: 'masuk',
                        name: 'masuk'
                    },
                    {
                        data: 'keluar',
                        name: 'keluar'
                    },
                ]
            });
        });
    </script>
@endsection
