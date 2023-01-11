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
                                    if (empty($_GET['like']) and (isset($_GET['kode']) or isset($_GET['tgl_start']) or isset($_GET['tgl_end']) or isset($_GET['nis']) or isset($_GET['siswa']) or isset($_GET['biaya_start']) or isset($_GET['biaya_end']) or isset($_GET['disc_start']) or isset($_GET['disc_end']) or isset($_GET['prestasi_start']) or isset($_GET['prestasi_end']) or isset($_GET['total_start']) or isset($_GET['total_end']))) {
                                        if ($_GET['kode'] != null or $_GET['tgl_start'] != null or $_GET['tgl_end'] != null or $_GET['nis'] != null or $_GET['siswa'] != null or $_GET['biaya_start'] != null or $_GET['biaya_end'] != null or $_GET['disc_start'] != null or $_GET['disc_end'] != null or $_GET['prestasi_start'] != null or $_GET['prestasi_end'] != null or $_GET['total_start'] != null or $_GET['total_end'] != null) {
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
                                                                        class="form-control" placeholder="No Pembayaran">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                        data-date-autoclose="true" data-provide="datepicker"
                                                                        data-date-container='#datepicker6'>
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_start" id="tgl_start"
                                                                            value="{{ isset($_GET['tgl_start']) ? $_GET['tgl_start'] : null }}"
                                                                            placeholder="Tanggal " />
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_end" id="tgl_end"
                                                                            value="{{ isset($_GET['tgl_end']) ? $_GET['tgl_end'] : null }}"
                                                                            placeholder="Pinjam" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="nis" id="nis"
                                                                        value="{{ isset($_GET['nis']) ? $_GET['nis'] : null }}"
                                                                        class="form-control" placeholder="NIS">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="siswa" id="siswa"
                                                                        value="{{ isset($_GET['siswa']) ? $_GET['siswa'] : null }}"
                                                                        class="form-control" placeholder="Siswa">
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="biaya_start"
                                                                            value="{{ isset($_GET['biaya_start']) ? $_GET['biaya_start'] : null }}"
                                                                            id="biaya_start"
                                                                            class="form-control number-only"
                                                                            placeholder="Biaya Awal">
                                                                        <input type="text" name="biaya_end"
                                                                            value="{{ isset($_GET['biaya_end']) ? $_GET['biaya_end'] : null }}"
                                                                            id="biaya_end" class="form-control number-only"
                                                                            placeholder="Biaya Akhir">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="disc_start"
                                                                            value="{{ isset($_GET['disc_start']) ? $_GET['disc_start'] : null }}"
                                                                            id="disc_start"
                                                                            class="form-control number-only"
                                                                            placeholder="Diskon Pembayaran Awal">
                                                                        <input type="text" name="disc_end"
                                                                            id="disc_end"
                                                                            value="{{ isset($_GET['disc_end']) ? $_GET['disc_end'] : null }}"
                                                                            class="form-control number-only "
                                                                            placeholder="Diskon Pembayaran Akhir">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="prestasi_start"
                                                                            value="{{ isset($_GET['prestasi_start']) ? $_GET['prestasi_start'] : null }}"
                                                                            id="prestasi_start"
                                                                            class="form-control number-only"
                                                                            placeholder="Diskon Prestasi Awal">
                                                                        <input type="text" name="prestasi_end"
                                                                            value="{{ isset($_GET['prestasi_end']) ? $_GET['prestasi_end'] : null }}"
                                                                            id="prestasi_end"
                                                                            class="form-control number-only "
                                                                            placeholder="Diskon Prestasi Akhir">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="total_start"
                                                                            value="{{ isset($_GET['total_start']) ? $_GET['total_start'] : null }}"
                                                                            id="total_start"
                                                                            class="form-control number-only"
                                                                            placeholder="Total Awal">
                                                                        <input type="text" name="total_end"
                                                                            value="{{ isset($_GET['total_end']) ? $_GET['total_end'] : null }}"
                                                                            id="total_end"
                                                                            class="form-control number-only "
                                                                            placeholder="Total Akhir">
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
                                                            <a href="{{ route('invoice.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $tgl_start = $_GET['tgl_start'];
                                                                $tgl_end = $_GET['tgl_end'];
                                                                $nis = $_GET['nis'];
                                                                $siswa = $_GET['siswa'];
                                                                $biaya_start = $_GET['biaya_start'];
                                                                $biaya_end = $_GET['biaya_end'];
                                                                $disc_start = $_GET['disc_start'];
                                                                $disc_end = $_GET['disc_end'];
                                                                $prestasi_start = $_GET['prestasi_start'];
                                                                $prestasi_end = $_GET['prestasi_end'];
                                                                $total_start = $_GET['total_start'];
                                                                $total_end = $_GET['total_end'];
                                                                
                                                                if (isset($_GET['type'])) {
                                                                    $type = $_GET['type'];
                                                                } else {
                                                                    $type = null;
                                                                }
                                                                $search_manual = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route(
                                                                    'invoice.export_invoice',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&tgl_start=' .
                                                                        $tgl_start .
                                                                        '&tgl_end=' .
                                                                        $tgl_end .
                                                                        '&nis=' .
                                                                        $nis .
                                                                        '&siswa=' .
                                                                        $siswa .
                                                                        '&biaya_start=' .
                                                                        $biaya_start .
                                                                        '&biaya_end=' .
                                                                        $biaya_end .
                                                                        '&disc_start=' .
                                                                        $disc_start .
                                                                        '&disc_end=' .
                                                                        $disc_end .
                                                                        '&prestasi_start=' .
                                                                        $prestasi_start .
                                                                        '&prestasi_end=' .
                                                                        $prestasi_end .
                                                                        '&total_start=' .
                                                                        $total_start .
                                                                        '&total_end=' .
                                                                        $total_end .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @else
                                                                <a href="{{ route('invoice.export_invoice') }}"
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
                                        <th>No Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Siswa</th>
                                        <th class="text-center">Biaya</th>
                                        <th class="text-center">Diskon Pembayaran</th>
                                        <th class="text-center">Diskon Prestasi</th>
                                        <th>Total</th>
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
    <style>
        .right {
            text-align: right;
        }
    </style>
    <script>
        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("nis").value = null;
                document.getElementById("siswa").value = null;
                document.getElementById("biaya_start").value = null;
                document.getElementById("biaya_end").value = null;
                document.getElementById("disc_start").value = null;
                document.getElementById("disc_end").value = null;
                document.getElementById("prestasi_start").value = null;
                document.getElementById("prestasi_end").value = null;
                document.getElementById("total_start").value = null;
                document.getElementById("total_end").value = null;
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
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("nis").value = null;
                document.getElementById("siswa").value = null;
                document.getElementById("biaya_start").value = null;
                document.getElementById("biaya_end").value = null;
                document.getElementById("disc_start").value = null;
                document.getElementById("disc_end").value = null;
                document.getElementById("prestasi_start").value = null;
                document.getElementById("prestasi_end").value = null;
                document.getElementById("total_start").value = null;
                document.getElementById("total_end").value = null;
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
                searchDelay: 1000,
                ajax: {
                    url: "{{ route('invoice.list_invoice') }}",
                    data: function(d) {
                        d.kode = (document.getElementById("kode").value.length != 0) ? document
                            .getElementById(
                                "kode").value : null;
                        d.tgl_start = (document.getElementById("tgl_start").value.length != 0) ?
                            document
                            .getElementById(
                                "tgl_start").value : null;
                        d.tgl_end = (document.getElementById("tgl_end").value.length != 0) ? document
                            .getElementById(
                                "tgl_end").value : null;
                        d.nis = (document.getElementById("nis").value.length != 0) ? document
                            .getElementById(
                                "nis").value : null;
                        d.siswa = (document.getElementById("siswa").value.length != 0) ? document
                            .getElementById(
                                "siswa").value : null;
                        d.biaya_start = (document.getElementById("biaya_start").value.length != 0) ?
                            document
                            .getElementById(
                                "biaya_start").value : null;
                        d.biaya_end = (document.getElementById("biaya_end").value.length != 0) ?
                            document
                            .getElementById(
                                "biaya_end").value : null;
                        d.disc_start = (document.getElementById("disc_start").value.length != 0) ?
                            document
                            .getElementById(
                                "disc_start").value : null;
                        d.disc_end = (document.getElementById("disc_end").value.length != 0) ? document
                            .getElementById(
                                "disc_end").value : null;
                        d.prestasi_start = (document.getElementById("prestasi_start").value.length !=
                                0) ?
                            document
                            .getElementById(
                                "prestasi_start").value : null;
                        d.prestasi_end = (document.getElementById("prestasi_end").value.length != 0) ?
                            document
                            .getElementById(
                                "prestasi_end").value : null;
                        d.total_start = (document.getElementById("total_start").value.length !=
                                0) ?
                            document
                            .getElementById(
                                "total_start").value : null;
                        d.total_end = (document.getElementById("total_end").value.length != 0) ?
                            document
                            .getElementById(
                                "total_end").value : null;
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
                        data: 'nis',
                        name: 'nis',
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
