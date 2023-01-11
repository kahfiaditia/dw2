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
                                @if (in_array('71', $session_menu))
                                    <a href="{{ route('buku.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Buku
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
                                    if (isset($_GET['kode']) or isset($_GET['judul']) or isset($_GET['pengarang']) or isset($_GET['penerbit']) or isset($_GET['kategori']) or isset($_GET['jml_start']) or isset($_GET['jml_end']) or isset($_GET['stock_start']) or isset($_GET['stock_end']) or isset($_GET['rak'])) {
                                        if ($_GET['kode'] != null or $_GET['judul'] != null or $_GET['pengarang'] != null or $_GET['penerbit'] != null or $_GET['kategori'] != null or $_GET['jml_start'] != null or $_GET['jml_end'] != null or $_GET['stock_start'] != null or $_GET['stock_end'] != null or $_GET['rak'] != null) {
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
                                                                    <input type="text" name="judul" id="judul"
                                                                        value="{{ isset($_GET['judul']) ? $_GET['judul'] : null }}"
                                                                        class="form-control" placeholder="Judul">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="pengarang" id="pengarang"
                                                                        value="{{ isset($_GET['pengarang']) ? $_GET['pengarang'] : null }}"
                                                                        class="form-control" placeholder="Pengarang">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="penerbit" id="penerbit"
                                                                        value="{{ isset($_GET['penerbit']) ? $_GET['penerbit'] : null }}"
                                                                        class="form-control" placeholder="Penerbit">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kategori" id="kategori"
                                                                        value="{{ isset($_GET['kategori']) ? $_GET['kategori'] : null }}"
                                                                        class="form-control" placeholder="Kategori">
                                                                </div>
                                                                <div class="col-md-2 mb-2">
                                                                    <input type="text" name="rak" id="rak"
                                                                        value="{{ isset($_GET['rak']) ? $_GET['rak'] : null }}"
                                                                        class="form-control" placeholder="Rak">
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
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
                                                                            placeholder="Tersedia">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="stock_start"
                                                                            id="stock_start"
                                                                            value="{{ isset($_GET['stock_start']) ? $_GET['stock_start'] : null }}"
                                                                            class="form-control number-only rangeStock"
                                                                            placeholder="Jumlah">
                                                                        <input type="text" name="stock_end"
                                                                            id="stock_end" onkeyup="rangeStock()"
                                                                            value="{{ isset($_GET['stock_end']) ? $_GET['stock_end'] : null }}"
                                                                            class="form-control number-only rangeStock"
                                                                            placeholder="Stock">
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
                                                            <a href="{{ route('buku.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $judul = $_GET['judul'];
                                                                $pengarang = $_GET['pengarang'];
                                                                $penerbit = $_GET['penerbit'];
                                                                $kategori = $_GET['kategori'];
                                                                $jml_start = $_GET['jml_start'];
                                                                $jml_end = $_GET['jml_end'];
                                                                $stock_start = $_GET['stock_start'];
                                                                $stock_end = $_GET['stock_end'];
                                                                $search_manual = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route(
                                                                    'buku.export_buku',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&judul=' .
                                                                        $judul .
                                                                        '&pengarang=' .
                                                                        $pengarang .
                                                                        '&penerbit=' .
                                                                        $penerbit .
                                                                        '&kategori=' .
                                                                        $kategori .
                                                                        '&jml_start=' .
                                                                        $jml_start .
                                                                        '&jml_end=' .
                                                                        $jml_end .
                                                                        '&stock_start=' .
                                                                        $stock_start .
                                                                        '&stock_end=' .
                                                                        $stock_end .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @else
                                                                <a href="{{ route('pinjaman.export_pinjaman_buku') }}"
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
                                        <th>Kode Buku</th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Kategori</th>
                                        <th>Rak</th>
                                        <th>Jumlah Tersedia</th>
                                        <th>Jumlah Stok</th>
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
        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("judul").value = null;
                document.getElementById("pengarang").value = null;
                document.getElementById("penerbit").value = null;
                document.getElementById("kategori").value = null;
                document.getElementById("rak").value = null;
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
            if (parseInt(jml_end) < parseInt(jml_start) && parseInt(jml_end) != '') {
                Swal.fire(
                    'Gagal',
                    'Jumlah awal tidak boleh lebih besar dari jumlah akhir',
                    'error'
                ).then(function() {
                    document.getElementById("jml_end").value = '';
                })
            }
        }

        function rangeStock() {
            let stock_start = document.getElementById("stock_start").value;
            let stock_end = document.getElementById("stock_end").value;
            if (parseInt(stock_end) < parseInt(stock_start) && parseInt(stock_end) != '') {
                Swal.fire(
                    'Gagal',
                    'Jumlah awal tidak boleh lebih besar dari jumlah akhir',
                    'error'
                ).then(function() {
                    document.getElementById("stock_end").value = '';
                })
            }
        }

        $(document).ready(function() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("kode").value = null;
                document.getElementById("judul").value = null;
                document.getElementById("pengarang").value = null;
                document.getElementById("penerbit").value = null;
                document.getElementById("kategori").value = null;
                document.getElementById("rak").value = null;
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
                ajax: {
                    url: "{{ route('buku.data_ajax') }}",
                    data: function(d) {
                        d.kode = (document.getElementById("kode").value.length != 0) ? document
                            .getElementById(
                                "kode").value : null;
                        d.judul = (document.getElementById("judul").value.length != 0) ? document
                            .getElementById(
                                "judul").value : null;
                        d.pengarang = (document.getElementById("pengarang").value.length != 0) ?
                            document
                            .getElementById(
                                "pengarang").value : null;
                        d.penerbit = (document.getElementById("penerbit").value.length != 0) ?
                            document
                            .getElementById(
                                "penerbit").value : null;
                        d.kategori = (document.getElementById("kategori").value.length != 0) ? document
                            .getElementById(
                                "kategori").value : null;
                        d.jml_start = (document.getElementById("jml_start").value.length != 0) ?
                            document
                            .getElementById(
                                "jml_start").value : null;
                        d.jml_end = (document.getElementById("jml_end").value.length != 0) ? document
                            .getElementById(
                                "jml_end").value : null;
                        d.rak = (document.getElementById("rak").value.length != 0) ? document
                            .getElementById(
                                "rak").value : null;
                        d.stock_start = (document.getElementById("stock_start").value.length != 0) ?
                            document
                            .getElementById(
                                "stock_start").value : null;
                        d.stock_end = (document.getElementById("stock_end").value.length != 0) ?
                            document
                            .getElementById(
                                "stock_end").value : null;
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
                        data: 'kode_buku',
                        name: 'kode_buku'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'pengarang',
                        name: 'pengarang'
                    },
                    {
                        data: 'penerbit',
                        name: 'penerbit'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'rak',
                        name: 'rak'
                    },
                    {
                        data: 'jml_buku',
                        name: 'jml_buku'
                    },
                    {
                        data: 'stock_master',
                        name: 'stock_master'
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
