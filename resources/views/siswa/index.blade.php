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
                                        class="float-end btn btn-warning btn-rounded waves-effect waves-light mb-2 me-2"
                                        class="btn btn-primary btn-sm"><i class="bx bx-cloud-download me-1"></i>Download
                                        File
                                        Import</a>
                                    <a href="#"
                                        class="float-end btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"
                                        id="button_trigger" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#csvModal"><i class="bx bx-import me-1"></i>Import CSV</a>
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
                            <table id="mydata" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
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
                        <input type="file" required class="form-control" name="student_csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            id="cancel">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $("#button_trigger").on('click', function() {
            $("#csvModal").modal('show')
        })

        $("#cancel").on('click', function() {
            $("#csvModal").modal('toggle')
        })

        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{ route('siswa.index') }}',
                },
                // columnDefs: [{
                //     "className": "text-center",
                //     "targets": "_all"
                // }],
                columns: [{
                        data: 'DT_RowIndex'
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
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endsection
