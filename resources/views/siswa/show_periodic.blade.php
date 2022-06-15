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
            {{-- cek device moblie atau bukan --}}
            <?php preg_match('/(chrome|firefox|avantgo|blackberry|android|blazer|elaine|hiptop|iphone|ipod|kindle|midp|mmp|mobile|o2|opera mini|palm|palm os|pda|plucker|pocket|psp|smartphone|symbian|treo|up.browser|up.link|vodafone|wap|windows ce; iemobile|windows ce; ppc;|windows ce; smartphone;|xiino)/i', $_SERVER['HTTP_USER_AGENT'], $version); ?>
            <div class="checkout-tabs">

                <div class="row">
                    @if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')
                        <?php $device = 'style="display:none;"';
                        $column = '12'; ?>
                    @else
                        <?php $device = '';
                        $column = '10'; ?>
                    @endif
                    <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a href="{{ route('siswa.edit', $student->id) }}"
                                class="nav-link @if ($submenu == 'siswa') active @endif">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Pribadi</p>
                            </a>
                            <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                href="{{ route('siswa.show_parents', $student->id) }}">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                <p class="fw-bold mb-4">Orang Tua</p>
                            </a>
                            <a href="{{ route('siswa.show_periodic', $student->id) }}"
                                class="nav-link @if ($submenu == 'priodik') active @endif">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Priodik</p>
                            </a>
                            <a href="{{ route('siswa.list_performance_students', $student->id) }}"
                                class="nav-link @if ($submenu == 'performance') active @endif">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Jumlah Anak</p>
                            </a>
                            <a class="nav-link">
                                <i class="bx bx-phone check-nav-icon mt-2"></i>
                                <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h3>Data Priodik Siswa</h3>
                                            </div>
                                            @if ($student->periodic_student == null)
                                                <div class="col-md-6" style="margin-top: -2px;">
                                                    <a href="{{ route('siswa.add_periodic_student', $student->id) }}"><i
                                                            class="bg-info rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                            style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -14%;"></i></a>
                                                </div>
                                            @else
                                                <div class="col-md-6" style="margin-top: -2px; margin-left: -8%;">
                                                    <form class="form_parents"
                                                        action="{{ route('siswa.destroy_periodic_student', $student->periodic_student->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a
                                                            href="{{ route('siswa.edit_periodic_student', $student->periodic_student->id) }}"><i
                                                                class="bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                        <a href="#"><i
                                                                class="delete_confirm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
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
                                                <div class="alert alert-danger" role="alert">
                                                    <a class="alert-link">Tidak Data Periodic</a>
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('siswa.edit', $student->id) }}"
                                                    class="btn btn-secondary waves-effect btn-sm">Kembali</a>
                                                <button class="btn btn-primary btn-sm" type="submit" style="float: right"
                                                    id="submit">Simpan</button>
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
