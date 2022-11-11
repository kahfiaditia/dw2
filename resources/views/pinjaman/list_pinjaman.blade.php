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
                                @if (in_array('75', $session_menu))
                                    <a href="{{ route('pinjaman.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Pinjaman
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
                                    if (empty($_GET['like']) and (isset($_GET['kode']) or isset($_GET['peminjam']) or isset($_GET['kelas']) or isset($_GET['tgl_start']) or isset($_GET['tgl_end']) or isset($_GET['jml_start']) or isset($_GET['jml_end']) or isset($_GET['type']))) {
                                        if ($_GET['kode'] != null or $_GET['peminjam'] != null or $_GET['kelas'] != null or $_GET['tgl_start'] != null or $_GET['tgl_end'] != null or $_GET['jml_start'] != null or $_GET['jml_end'] != null or $_GET['type'] != null) {
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
                                                                    <input type="text" name="peminjam" id="peminjam"
                                                                        value="{{ isset($_GET['peminjam']) ? $_GET['peminjam'] : null }}"
                                                                        class="form-control" placeholder="Peminjam">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kelas" id="kelas"
                                                                        value="{{ isset($_GET['kelas']) ? $_GET['kelas'] : null }}"
                                                                        class="form-control" placeholder="Kelas">
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
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="jml_start"
                                                                            id="jml_start"
                                                                            value="{{ isset($_GET['jml_start']) ? $_GET['jml_start'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                        <input type="text" name="jml_end" id="jml_end"
                                                                            onkeyup="rangeJml()"
                                                                            value="{{ isset($_GET['jml_end']) ? $_GET['jml_end'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <select class="form-control select select2 type"
                                                                        style="width: 100%" name="type" id="type">
                                                                        <option value="">--Pilih Type--</option>
                                                                        <option value="Detail"
                                                                            {{ (isset($_GET['type']) and $_GET['type'] == 'Detail') ? 'selected' : null }}>
                                                                            Detail</option>
                                                                        <option value="Summary"
                                                                            {{ (isset($_GET['type']) and $_GET['type'] == 'Summary') ? 'selected' : null }}>
                                                                            Summary</option>
                                                                    </select>
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
                                                            <a href="{{ route('pinjaman.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $peminjam = $_GET['peminjam'];
                                                                $kelas = $_GET['kelas'];
                                                                $tgl_start = $_GET['tgl_start'];
                                                                $tgl_end = $_GET['tgl_end'];
                                                                $jml_start = $_GET['jml_start'];
                                                                $jml_end = $_GET['jml_end'];
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
                                                                    'pinjaman.export_pinjaman_buku',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&peminjam=' .
                                                                        $peminjam .
                                                                        '&kelas=' .
                                                                        $kelas .
                                                                        '&tgl_start=' .
                                                                        $tgl_start .
                                                                        '&tgl_end=' .
                                                                        $tgl_end .
                                                                        '&jml_start=' .
                                                                        $jml_start .
                                                                        '&jml_end=' .
                                                                        $jml_end .
                                                                        '&type=' .
                                                                        $type .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Export</a>
                                                            @else
                                                                <a href="{{ route('pinjaman.export_pinjaman_buku') }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Export</a>
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
                                        @if (empty($_GET['like']) and isset($_GET['type']))
                                            @if ($_GET['type'] == 'Summary')
                                                <th>Kelas</th>
                                            @else
                                                <th>Buku</th>
                                            @endif
                                        @else
                                            <th>Kelas</th>
                                        @endif
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Perkiraan Kembali</th>
                                        <th>Tgl Kembali</th>
                                        <th>Jumlah</th>
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
        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("peminjam").value = null;
                document.getElementById("kelas").value = null;
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("jml_start").value = null;
                document.getElementById("jml_end").value = null;
                $('#type').val("").trigger('change')
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search_manual").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        }

        function rangeJml() {
            let jml_start = document.getElementById("jml_start").value;
            let jml_end = document.getElementById("jml_end").value;
            if (jml_end < jml_start && jml_end != '') {
                Swal.fire(
                    'Gagal',
                    'Jumlah awal tidak boleh lebih besar dari jumlah akhir',
                    'error'
                ).then(function() {
                    document.getElementById("jml_end").value = '';
                })
            }
        }

        $(document).ready(function() {
            $(".type").change(function() {
                let type = $(this).val();
                if (type == 'Detail') {
                    document.getElementById("kelas").placeholder = "Buku";
                } else {
                    document.getElementById("kelas").placeholder = "Kelas";
                }
            });

            var select_type = document.getElementById('type');
            var hasil_type = select_type.options[select_type.selectedIndex].value;
            if (hasil_type == 'Detail') {
                document.getElementById("kelas").placeholder = "Buku";
            } else {
                document.getElementById("kelas").placeholder = "Kelas";
            }

            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("peminjam").value = null;
                document.getElementById("kelas").value = null;
                document.getElementById("tgl_start").value = null;
                document.getElementById("tgl_end").value = null;
                document.getElementById("jml_start").value = null;
                document.getElementById("jml_end").value = null;
                $('#type').val("").trigger('change')
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
                    url: "{{ route('pinjaman.pinjaman_ajax') }}",
                    data: function(d) {
                        d.kode = (document.getElementById("kode").value.length != 0) ? document
                            .getElementById(
                                "kode").value : null;
                        d.peminjam = (document.getElementById("peminjam").value.length != 0) ? document
                            .getElementById(
                                "peminjam").value : null;
                        d.kelas = (document.getElementById("kelas").value.length != 0) ? document
                            .getElementById(
                                "kelas").value : null;
                        d.tgl_start = (document.getElementById("tgl_start").value.length != 0) ?
                            document
                            .getElementById(
                                "tgl_start").value : null;
                        d.tgl_end = (document.getElementById("tgl_end").value.length != 0) ? document
                            .getElementById(
                                "tgl_end").value : null;
                        d.jml_start = (document.getElementById("jml_start").value.length != 0) ?
                            document
                            .getElementById(
                                "jml_start").value : null;
                        d.jml_end = (document.getElementById("jml_end").value.length != 0) ? document
                            .getElementById(
                                "jml_end").value : null;
                        d.type = (document.getElementById("type").value.length != 0) ? document
                            .getElementById(
                                "type").value : null;
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
                        data: 'kelas',
                        name: 'kelas'
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
                        data: 'all_date_return',
                        name: 'all_date_return'
                    },
                    {
                        data: 'jml',
                        name: 'jml'
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
