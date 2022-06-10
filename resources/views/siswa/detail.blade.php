@extends('layouts.main')
@section('container')
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
            <div class="checkout-tabs">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-data-tab" data-bs-toggle="pill" href="#v-pills-data"
                                role="tab" aria-controls="v-pills-data" aria-selected="true">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Pribadi</p>
                            </a>
                            <a class="nav-link" id="v-pills-orang-tua-tab" data-bs-toggle="pill"
                                href="#v-pills-orang-tua" role="tab" aria-controls="v-pills-orang-tua" aria-selected="true">
                                <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Orang Tua / Wali</p>
                            </a>
                            <a class="nav-link" id="v-pills-sk-tab" data-bs-toggle="pill" href="#v-pills-sk"
                                role="tab" aria-controls="v-pills-sk" aria-selected="false">
                                <i class="bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link" id="v-pills-anak-tab" data-bs-toggle="pill" href="#v-pills-anak"
                                role="tab" aria-controls="v-pills-anak" aria-selected="true">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Jumlah Anak</p>
                            </a>
                            <a class="nav-link" id="v-pills-riwayat-tab" data-bs-toggle="pill" href="#v-pills-riwayat"
                                role="tab" aria-controls="v-pills-riwayat" aria-selected="true">
                                <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                <i class="bx bx-phone check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit & Kontak</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-data" role="tabpanel"
                                        aria-labelledby="v-pills-data-tab">
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">NIK</h5>
                                                    <p class="text-muted mb-0">{{ $student->nik }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">NISN</h5>
                                                    <p class="text-muted mb-0">{{ $student->nisn }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nama Lengkap</h5>
                                                    <p class="text-muted mb-0">{{ $student->nama_lengkap }}</p>
                                                    <a href="javascript:void(0)" data-id="" id="get_data"
                                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Jenis Kelamin</h5>
                                                    <p class="text-muted mb-0">{{ $student->jenis_kelamin }}</p>
                                                    <a href="javascript:void(0)" data-id="" id="get_data"
                                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Tempat, Tanggal Lahir</h5>
                                                    <p class="text-muted mb-0">
                                                        {{ $student->tempat_lahir . ', ' . \Carbon\Carbon::parse($student->tanggal_lahir)->format('d F Y') }}
                                                    </p>
                                                    <a href="javascript:void(0)" data-id="" id="get_data"
                                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Agama</h5>
                                                    <p class="text-muted mb-0">{{ $student->religion->agama }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Golongan Darah</h5>
                                                    <p class="text-muted mb-0">{{ $student->golongan_darah }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nomor Akta Lahir</h5>
                                                    <p class="text-muted mb-0">
                                                        {{ $student->no_registrasi_akta_lahir }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nomor Kartu Keluarga</h5>
                                                    <p class="text-muted mb-0">{{ $student->no_kk }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Email</h5>
                                                    <p class="text-muted mb-0">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nomor Handphone</h5>
                                                    <p class="text-muted mb-0">{{ $student->no_handphone }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kewarganegaraan</h5>
                                                    <p class="text-muted mb-0">{{ $student->kewarganegaraan }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nama Negara</h5>
                                                    <p class="text-muted mb-0">{{ $student->nama_negara }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Tempat Tinggal</h5>
                                                    <p class="text-muted mb-0">{{ $student->tempat_tinggal }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                    <p class="text-muted mb-0">{{ $student->special_need->nama }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Dusun</h5>
                                                    <p class="text-muted mb-0">{{ $student->dusun }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kecamatan</h5>
                                                    <p class="text-muted mb-0">{{ $student->village }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kelurahan</h5>
                                                    <p class="text-muted mb-0">{{ $student->district }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">RT</h5>
                                                    <p class="text-muted mb-0">{{ $student->rt }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">RW</h5>
                                                    <p class="text-muted mb-0">{{ $student->rw }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kode Pos</h5>
                                                    <p class="text-muted mb-0">{{ $student->postal_code }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Alamat Jalan</h5>
                                                    <p class="text-muted mb-0">{{ $student->alamat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-3 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Moda Transportasi</h5>
                                                    <p class="text-muted mb-0">{{ $student->transportation }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Anak Keberapa</h5>
                                                    <p class="text-muted mb-0">{{ $student->child_order }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Sudah Punya KIP</h5>
                                                    <p class="text-muted mb-0">{{ $student->is_have_kip }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Tetap Menerima KIP</h5>
                                                    <p class="text-muted mb-0">{{ $student->is_receive_kip }}</p>
                                                </div>
                                            </div>
                                            @if ($student->is_receive_kip == 'Tidak')
                                                <div class="col-sm-3 col-6">
                                                    <div class="mt-4">
                                                        <h5 class="font-size-14">Alasan Menolak KIP</h5>
                                                        <p class="text-muted mb-0">{{ $student->reason_reject_kip }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            <a href="{{ route('siswa.index') }}" style="margin-left: 10px;"
                                                class="col-md-1 mt-3 btn btn-secondary btn-sm">Kembali</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-orang-tua" role="tabpanel"
                                        aria-labelledby="v-pills-orang-tua-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>Data Ayah Kandung</h3>
                                            </div>
                                            @if ($father != null)
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">NIK</h5>
                                                    <p class="text-muted">{{ $father->nik }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Nama Lengkap</h5>
                                                    <p class="text-muted">{{ $father->name }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Tanggal Lahir</h5>
                                                    <p class="text-muted">
                                                        {{ \Carbon\Carbon::parse($father->tanggal_lahir)->format('d F Y') }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pendidikan</h5>
                                                    <p class="text-muted">
                                                        {{ $father->pendidikan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pekerjaan</h5>
                                                    <p class="text-muted">
                                                        {{ $father->pekerjaan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Penghasilan</h5>
                                                    <p class="text-muted">
                                                        {{ $father->penghasilan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                    <p class="text-muted">
                                                        {{ $father->special_need->nama }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    <a class="alert-link">Tidak Ada Ayah Kandung</a>
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Data Ibu Kandung</h3>
                                            </div>
                                            @if ($mother != null)
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">NIK</h5>
                                                    <p class="text-muted">{{ $mother->nik }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Nama Lengkap</h5>
                                                    <p class="text-muted">{{ $mother->name }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Tanggal Lahir</h5>
                                                    <p class="text-muted">
                                                        {{ \Carbon\Carbon::parse($mother->tanggal_lahir)->format('d F Y') }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pendidikan</h5>
                                                    <p class="text-muted">
                                                        {{ $mother->pendidikan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pekerjaan</h5>
                                                    <p class="text-muted">
                                                        {{ $mother->pekerjaan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Penghasilan</h5>
                                                    <p class="text-muted">
                                                        {{ $mother->penghasilan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                    <p class="text-muted">
                                                        {{ $mother->special_need->nama }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    <a class="alert-link">Tidak Ada Ibu Kandung</a>
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Data Wali</h3>
                                            </div>
                                            @if ($guardian != null)
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">NIK</h5>
                                                    <p class="text-muted">{{ $guardian->nik }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Nama Lengkap</h5>
                                                    <p class="text-muted">{{ $guardian->name }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Tanggal Lahir</h5>
                                                    <p class="text-muted">
                                                        {{ \Carbon\Carbon::parse($guardian->tanggal_lahir)->format('d F Y') }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pendidikan</h5>
                                                    <p class="text-muted">
                                                        {{ $guardian->pendidikan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Pekerjaan</h5>
                                                    <p class="text-muted">
                                                        {{ $guardian->pekerjaan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Penghasilan</h5>
                                                    <p class="text-muted">
                                                        {{ $guardian->penghasilan }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                    <p class="text-muted">
                                                        {{ $guardian->special_need->nama }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    <a class="alert-link">Tidak Ada Wali</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-sk" role="tabpanel"
                                        aria-labelledby="v-pills-sk-tab">
                                        <table id="" class="table table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>No SK</th>
                                                    <th>Tanggal SK</th>
                                                    <th>Jabatan</th>
                                                    <th>Dokumen SK</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <div class="alert alert-danger" role="alert">
                                            <a class="alert-link">Belum isi SK Pengangkatan</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-anak" role="tabpanel"
                                        aria-labelledby="v-pills-anak-tab">

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-riwayat" role="tabpanel"
                                        aria-labelledby="v-pills-riwayat-tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#get_data', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.dokumen') }}"
                $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        }
                    })
                    .done(function(url) {
                        $('#dynamic-content').html(url); // load response
                        $('#modal-loader').hide(); // hide ajax loader
                    })
                    .fail(function(err) {
                        $('#dynamic-content').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });
            });
        });
    </script>
@endsection
