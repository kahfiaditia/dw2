@extends('layouts.main')
@section('container')
    <?php
    function hitung_umur($tanggal_lahir)
    {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime('today');
        if ($birthDate > $today) {
            exit('0 Tahun 0 Bulan 0 Hari');
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        return $y . ' Tahun ' . $m . ' Bulan ' . $d . ' Hari';
    }
    ?>
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
                    <?php preg_match('/(chrome|firefox|avantgo|blackberry|android|blazer|elaine|hiptop|iphone|ipod|kindle|midp|mmp|mobile|o2|opera mini|palm|palm os|pda|plucker|pocket|psp|smartphone|symbian|treo|up.browser|up.link|vodafone|wap|windows ce; iemobile|windows ce; ppc;|windows ce; smartphone;|xiino)/i', $_SERVER['HTTP_USER_AGENT'], $version); ?>
                    @if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')
                        <?php $device = 'style="display:none;"';
                        $column = '12'; ?>
                    @else
                        <?php $device = '';
                        $column = '10'; ?>
                    @endif
                    <div class="col-lg-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-data-tab" data-bs-toggle="pill" href="#v-pills-data"
                                role="tab" aria-controls="v-pills-data" aria-selected="true">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Pribadi</p>
                            </a>
                            <a class="nav-link" id="v-pills-orang-tua-tab" data-bs-toggle="pill" href="#v-pills-orang-tua"
                                role="tab" aria-controls="v-pills-orang-tua" aria-selected="true">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Orang Tua / Wali</p>
                            </a>
                            <a class="nav-link" id="v-pills-sk-tab" data-bs-toggle="pill" href="#v-pills-sk" role="tab"
                                aria-controls="v-pills-sk" aria-selected="false">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Priodik</p>
                            </a>
                            <a class="nav-link" id="v-pills-anak-tab" data-bs-toggle="pill" href="#v-pills-anak"
                                role="tab" aria-controls="v-pills-anak" aria-selected="true">
                                <i class="bx bx-chart d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Prestasi</p>
                            </a>
                            <a class="nav-link" id="v-pills-riwayat-tab" data-bs-toggle="pill" href="#v-pills-riwayat"
                                role="tab" aria-controls="v-pills-riwayat" aria-selected="true">
                                <i class="bx bx-star check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Beasiswa</p>
                            </a>
                            <a class="nav-link" id="v-pills-kesejahteraan-tab" data-bs-toggle="pill"
                                href="#v-pills-kesejahteraan" role="tab" aria-controls="v-pills-kesejahteraan"
                                aria-selected="true">
                                <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Kesejahteraan Siswa</p>
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
                                                    <h5 class="font-size-14">NISN</h5>
                                                    <p class="text-muted mb-0">{{ $student->nisn }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">NIK</h5>
                                                    <p class="text-muted mb-0">{{ $student->nik }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kelas</h5>
                                                    <p class="text-muted mb-0">
                                                        @if ($student->classes_student)
                                                            {{ $student->classes_student->school_level->level . ' ' . $student->classes_student->school_class->classes . ' ' . $student->classes_student->jurusan . '.' . $student->classes_student->type }}
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
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
                                                        {{ $student->tempat_lahir . ', ' }}
                                                        @if ($student->tanggal_lahir)
                                                            {{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d F Y') . '(' . hitung_umur($student->tanggal_lahir) . ')' }}
                                                        @endif
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
                                                    <p class="text-muted mb-0">
                                                        {{ $student->religion ? $student->religion->agama : '' }}</p>
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
                                                    <p class="text-muted mb-0">
                                                        {{ $student->special_need ? $student->special_need->nama : '' }}
                                                    </p>
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
                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
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
                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Ayah Kandung</a>
                                                    </div>
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
                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Ibu Kandung</a>
                                                    </div>
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
                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Wali</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <a href="{{ route('siswa.index') }}" style="margin-left: 10px;"
                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-sk" role="tabpanel"
                                        aria-labelledby="v-pills-sk-tab">
                                        <div class="row">
                                            <h3>Data Priodik</h3>
                                            @if ($student->periodic_student != null)
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Tinggi Badan</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->tinggi_badan . ' Cm' }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Berat Badan</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->berat_badan . ' Kg' }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Lingkar Kepala</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->lingkar_kepala . ' Cm' }}</p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Jarak tempat tinggal ke sekolah</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->jarak_tempat_tinggal_ke_sekolah }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Sebutkan (dalam kilometer)</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->in_km . ' Km' }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Waktu tempuh ke sekolah</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->waktu_tempuh_jam . ' Jam ' . $student->periodic_student->waktu_tempuh_menit . ' Menit' }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4 mt-4">
                                                    <h5 class="font-size-14">Jumlah saudara kandung</h5>
                                                    <p class="text-muted">
                                                        {{ $student->periodic_student->jumlah_saudara_kandung }}</p>
                                                </div>
                                            @else
                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Data Periodic</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <a href="{{ route('siswa.index') }}" style="margin-left: 10px;"
                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-anak" role="tabpanel"
                                        aria-labelledby="v-pills-anak-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table id="mydata"
                                                            class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">Jenis Prestasi</th>
                                                                    <th class="text-center">Tingkat
                                                                    </th>
                                                                    <th class="text-center">Nama Prestasi</th>
                                                                    <th class="text-center">Tahun Prestasi</th>
                                                                    <th class="text-center">Penyelenggara</th>
                                                                    <th class="text-center">Peringkat</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($student->performances as $performance)
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            {{ $loop->iteration }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->jenis_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->tingkat_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->nama_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->tahun_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->penyelenggara }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->peringkat }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <a href="{{ route('siswa.index') }}"
                                                                style="margin-left: 10px;"
                                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-riwayat" role="tabpanel"
                                        aria-labelledby="v-pills-riwayat-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table id="mydata"
                                                            class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">Jenis Beasiswa</th>
                                                                    <th class="text-center">Keterangan</th>
                                                                    <th class="text-center">Tahun Mulai</th>
                                                                    <th class="text-center">Tahun Selesai</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($student->beasiswa as $scholarship)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $scholarship->jenis_beasiswa }}</td>
                                                                        <td class="text-center">
                                                                            {{ $scholarship->keterangan }}</td>
                                                                        <td class="text-center">
                                                                            {{ $scholarship->tahun_mulai }}</td>
                                                                        <td class="text-center">
                                                                            {{ $scholarship->tahun_selesai }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <a href="{{ route('siswa.index') }}"
                                                                style="margin-left: 10px;"
                                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-kesejahteraan" role="tabpanel"
                                        aria-labelledby="v-pills-kesejahteraan-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table id="mydata"
                                                            class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">Jenis Kesejahteraan</th>
                                                                    <th class="text-center">Nomor Kartu</th>
                                                                    <th class="text-center">Nama Di Kartu</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($student->kesejahteraan as $item)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $item->jenis_kesejahteraan }}</td>
                                                                        <td class="text-center">
                                                                            {{ $item->nomor_kartu }}</td>
                                                                        <td class="text-center">
                                                                            {{ $item->nama_kartu }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <a href="{{ route('siswa.index') }}"
                                                                style="margin-left: 10px;"
                                                                class="col-md-1 mt-3 btn btn-secondary">Kembali</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
