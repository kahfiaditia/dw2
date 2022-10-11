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
                                @if (in_array('20', $session_menu) and Auth::user()->student == null)
                                    <a href="{{ route('siswa.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Siswa
                                    </a>
                                @endif
                                @if (Auth::user()->roles == 'Admin' or Auth::user()->roles == 'Administrator')
                                    <a href="{{ route('siswa.csv_download') }}"
                                        class="float-end btn btn-warning btn-rounded waves-effect waves-light mb-2 me-2"><i
                                            class="bx bx-cloud-download me-1"></i>Download
                                        File
                                        Import</a>
                                    <a href="#"
                                        class="float-end btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"
                                        id="button_trigger"data-toggle="modal" data-target="#csvModal"><i
                                            class="bx bx-import me-1"></i>Import CSV</a>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($errors->all())
                        <div class="alert alert-danger alert-dismissible">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion" id="accordionExample"
                                {{ Auth::user()->roles == 'Siswa' ? 'hidden' : '' }}>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium <?php if (isset($_GET['nis'])) {
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
                                    if (empty($_GET['like']) and (isset($_GET['nis']) or isset($_GET['nisn']) or isset($_GET['nik']) or isset($_GET['nama']) or isset($_GET['email']) or isset($_GET['kelas']))) {
                                        if ($_GET['nis'] != null or $_GET['nisn'] != null or $_GET['nik'] != null or $_GET['nama'] != null or $_GET['email'] != null or $_GET['kelas'] != null) {
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
                                                                    <input type="text" name="nis" id="nis"
                                                                        value="{{ isset($_GET['nis']) ? $_GET['nis'] : null }}"
                                                                        class="form-control" placeholder="NIS">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="nisn" id="nisn"
                                                                        value="{{ isset($_GET['nisn']) ? $_GET['nisn'] : null }}"
                                                                        class="form-control" placeholder="NISN">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="nik" id="nik"
                                                                        value="{{ isset($_GET['nik']) ? $_GET['nik'] : null }}"
                                                                        class="form-control" placeholder="NIK">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="nama" id="nama"
                                                                        value="{{ isset($_GET['nama']) ? $_GET['nama'] : null }}"
                                                                        class="form-control" placeholder="Nama">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="email" id="email"
                                                                        value="{{ isset($_GET['email']) ? $_GET['email'] : null }}"
                                                                        class="form-control" placeholder="Email">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kelas" id="kelas"
                                                                        value="{{ isset($_GET['kelas']) ? $_GET['kelas'] : null }}"
                                                                        class="form-control" placeholder="Kelas">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="id_like" style="display: none">
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="search" id="search"
                                                                value="{{ isset($_GET['search']) ? $_GET['search'] : null }}"
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
                                                            <a href="{{ route('siswa.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['nis']) or isset($_GET['like']))
                                                                <?php
                                                                $nis = $_GET['nis'];
                                                                $nisn = $_GET['nisn'];
                                                                $nik = $_GET['nik'];
                                                                $nama = $_GET['nama'];
                                                                $email = $_GET['email'];
                                                                $kelas = $_GET['kelas'];
                                                                $search = $_GET['search'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route('siswa.export_siswa', 'nis=' . $nis . '&nisn=' . $nisn . '&nik=' . $nik . '&nama=' . $nama . '&email=' . $email . '&kelas=' . $kelas . '&search=' . $search . '&like=' . $like . '') }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Export</a>
                                                            @else
                                                                <a href="{{ route('siswa.export_siswa') }}"
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
                            <table id="mydata" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Kelas</th>
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

    <!-- Modal -->
    <div class="modal fade" id="csvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('student.import_csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        Import Data Siswa
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">Upload File CSV <code>*</code></label>
                        <input type="file" required class="form-control" name="student_csv" id="student_csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            id="cancel">Close</button>
                        <button type="submit" id="submit_excel" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("nis").value = null;
                document.getElementById("nisn").value = null;
                document.getElementById("nik").value = null;
                document.getElementById("nama").value = null;
                document.getElementById("email").value = null;
                document.getElementById("kelas").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        })

        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("nis").value = null;
                document.getElementById("nisn").value = null;
                document.getElementById("nik").value = null;
                document.getElementById("nama").value = null;
                document.getElementById("email").value = null;
                document.getElementById("kelas").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        }

        $("#button_trigger").on('click', function() {
            $("#csvModal").modal('show')
        })

        $("#submit_excel").on('click', function() {
            if (document.getElementById("student_csv").value) {
                $('#loader').show();
            }
        })

        $("#cancel").on('click', function() {
            $("#csvModal").modal('toggle')
            $('#loader').hide();
        })

        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                searching: false,
                ajax: {
                    url: '{{ route('siswa.index') }}',
                    data: function(d) {
                        d.nis = (document.getElementById("nis").value.length != 0) ? document
                            .getElementById(
                                "nis").value : null;
                        d.nisn = (document.getElementById("nisn").value.length != 0) ? document
                            .getElementById(
                                "nisn").value : null;
                        d.nik = (document.getElementById("nik").value.length != 0) ? document
                            .getElementById(
                                "nik").value : null;
                        d.nama = (document.getElementById("nama").value.length != 0) ? document
                            .getElementById(
                                "nama").value : null;
                        d.email = (document.getElementById("email").value.length != 0) ? document
                            .getElementById(
                                "email").value : null;
                        d.kelas = (document.getElementById("kelas").value.length != 0) ? document
                            .getElementById(
                                "kelas").value : null;
                        d.like = (document.getElementById("like").value.length != 0) ? document
                            .getElementById(
                                "like").value : null;
                        d.search = (document.getElementById("search").value.length != 0) ? document
                            .getElementById(
                                "search").value : null;
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
                        data: 'nis'
                    },
                    {
                        data: 'nisn'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'kelas'
                    },
                    {
                        data: 'Opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
