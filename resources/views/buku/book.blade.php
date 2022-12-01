<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DHARMAWIDYA" name="description" />
    <meta content="DHARMAWIDYA" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo/icon.png') }}">
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/loading.css') }}">
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
</head>

<body>
    <div class="account-pages">
        <div class="container">
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
                                            <b>Cari Data</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse <?php
                                    if (isset($_GET['kode']) or isset($_GET['judul']) or isset($_GET['pengarang']) or isset($_GET['penerbit']) or isset($_GET['kategori']) or isset($_GET['jml_start']) or isset($_GET['jml_end']) or isset($_GET['rak'])) {
                                        if ($_GET['kode'] != null or $_GET['judul'] != null or $_GET['pengarang'] != null or $_GET['penerbit'] != null or $_GET['kategori'] != null or $_GET['jml_start'] != null or $_GET['jml_end'] != null or $_GET['rak'] != null) {
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
                                                                    <input type="text" name="pengarang"
                                                                        id="pengarang"
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
                                                                <div class="col-sm-2 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="jml_start"
                                                                            id="jml_start"
                                                                            value="{{ isset($_GET['jml_start']) ? $_GET['jml_start'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                        <input type="text" name="jml_end"
                                                                            id="jml_end" onkeyup="rangeJml()"
                                                                            value="{{ isset($_GET['jml_end']) ? $_GET['jml_end'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 mb-2">
                                                                    <input type="text" name="rak"
                                                                        id="rak"
                                                                        value="{{ isset($_GET['rak']) ? $_GET['rak'] : null }}"
                                                                        class="form-control" placeholder="Rak">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-10 mb-2">
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Cari</button>
                                                            <a href="{{ route('book') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table id="table" class="table table-striped dt-responsive">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Buku</th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Rak</th>
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
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/numeral.js') }}"></script>
    <script src="{{ asset('assets/libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-mask.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get_book') }}",
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
                        data: 'jml_buku',
                        name: 'jml_buku'
                    },
                    {
                        data: 'rak',
                        name: 'rak'
                    },
                ]
            });
        });
    </script>
</body>

</html>
