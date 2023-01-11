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
                                @if (in_array('3', $session_menu))
                                    @if (Auth::user()->roles === 'Admin')
                                        <a href="{{ route('employee.create') }}" type="button"
                                            class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                                class="mdi mdi-plus me-1"></i> Tambah Karyawan</a>
                                    @elseif (Auth::user()->employee == null and Auth::user()->roles != 'Admin')
                                        <a href="{{ route('employee.create') }}" type="button"
                                            class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                                class="mdi mdi-plus me-1"></i> Tambah Karyawan</a>
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
                            <div class="accordion" id="accordionExample"
                                {{ Auth::user()->roles == 'Admin' || Auth::user()->roles == 'Administrator' ? '' : 'hidden' }}>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium <?php if (isset($_GET['nama'])) {
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
                                    if (empty($_GET['like']) and (isset($_GET['nama']) or isset($_GET['email']) or isset($_GET['nik']) or isset($_GET['npwp']) or isset($_GET['kontak']) or isset($_GET['jabatan']) or isset($_GET['stat']))) {
                                        if ($_GET['nama'] != null or $_GET['email'] != null or $_GET['nik'] != null or $_GET['npwp'] != null or $_GET['kontak'] != null or $_GET['jabatan'] != null or $_GET['stat'] != null) {
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
                                                                    <input type="text" name="nik" id="nik"
                                                                        value="{{ isset($_GET['nik']) ? $_GET['nik'] : null }}"
                                                                        class="form-control" placeholder="NIK">
                                                                </div>
                                                                <div class="col-md-2 mb-2">
                                                                    <input type="text" name="npwp" id="npwp"
                                                                        value="{{ isset($_GET['npwp']) ? $_GET['npwp'] : null }}"
                                                                        class="form-control" placeholder="NPWP">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kontak" id="kontak"
                                                                        value="{{ isset($_GET['kontak']) ? $_GET['kontak'] : null }}"
                                                                        class="form-control" placeholder="Kontak">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="jabatan" id="jabatan"
                                                                        value="{{ isset($_GET['jabatan']) ? $_GET['jabatan'] : null }}"
                                                                        class="form-control" placeholder="Jabatan">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="stat" id="stat"
                                                                        value="{{ isset($_GET['stat']) ? $_GET['stat'] : null }}"
                                                                        class="form-control" placeholder="Status">
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
                                                            <a href="{{ route('employee') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['nama']) or isset($_GET['like']))
                                                                <?php
                                                                $nama = $_GET['nama'];
                                                                $email = $_GET['email'];
                                                                $nik = $_GET['nik'];
                                                                $npwp = $_GET['npwp'];
                                                                $kontak = $_GET['kontak'];
                                                                $jabatan = $_GET['jabatan'];
                                                                $stat = $_GET['stat'];
                                                                $search = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route('employee.export_employee', 'nama=' . $nama . '&email=' . $email . '&nik=' . $nik . '&npwp=' . $npwp . '&kontak=' . $kontak . '&jabatan=' . $jabatan . '&stat=' . $stat . '&search=' . $search . '&like=' . $like . '') }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Unduh</a>
                                                            @else
                                                                <a href="{{ route('employee.export_employee') }}"
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
                            <table id="mydata" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>NIK</th>
                                        <th>NPWP</th>
                                        <th>Kontak</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
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
        $(document).ready(function() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("nama").value = null;
                document.getElementById("email").value = null;
                document.getElementById("nik").value = null;
                document.getElementById("npwp").value = null;
                document.getElementById("kontak").value = null;
                document.getElementById("jabatan").value = null;
                document.getElementById("stat").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search_manual").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        })

        function toggleCheckbox() {
            like = document.getElementById("like").checked;
            if (like == true) {
                document.getElementById("nama").value = null;
                document.getElementById("email").value = null;
                document.getElementById("nik").value = null;
                document.getElementById("npwp").value = null;
                document.getElementById("kontak").value = null;
                document.getElementById("jabatan").value = null;
                document.getElementById("stat").value = null;
                document.getElementById("id_where").style.display = 'none';
                document.getElementById("id_like").style.display = 'block';
            } else {
                document.getElementById("search_manual").value = null;
                document.getElementById("like").checked = false;
                document.getElementById("id_like").style.display = 'none';
                document.getElementById("id_where").style.display = 'block';
            }
        }

        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                // searching: false,
                ajax: {
                    url: '{{ route('employee') }}',
                    data: function(d) {
                        d.nama = (document.getElementById("nama").value.length != 0) ? document
                            .getElementById(
                                "nama").value : null;
                        d.email = (document.getElementById("email").value.length != 0) ? document
                            .getElementById(
                                "email").value : null;
                        d.nik = (document.getElementById("nik").value.length != 0) ? document
                            .getElementById(
                                "nik").value : null;
                        d.npwp = (document.getElementById("npwp").value.length != 0) ? document
                            .getElementById(
                                "npwp").value : null;
                        d.kontak = (document.getElementById("kontak").value.length != 0) ? document
                            .getElementById(
                                "kontak").value : null;
                        d.jabatan = (document.getElementById("jabatan").value.length != 0) ? document
                            .getElementById(
                                "jabatan").value : null;
                        d.stat = (document.getElementById("stat").value.length != 0) ? document
                            .getElementById(
                                "stat").value : null;
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
                columnDefs: [{
                    "className": "dt-center",
                    "targets": "_all"
                }],
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_lengkap'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'npwp'
                    },
                    {
                        data: 'no_hp'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'Opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endsection
