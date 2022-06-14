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
                            <a href="{{ route('siswa.edit', $student_id) }}"
                                class="nav-link @if ($submenu == 'siswa') active @endif">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Pribadi</p>
                            </a>
                            <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                href="{{ route('siswa.show_parents', $student_id) }}">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                <p class="fw-bold mb-4">Orang Tua</p>
                            </a>
                            <a href="{{ route('siswa.show_periodic', $student_id) }}" class="nav-link">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Priodik</p>
                            </a>
                            <a class="nav-link">
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
                                                <h3>Data Ayah Kandung</h3>
                                            </div>
                                            @if ($father == null)
                                                <div class="col-md-6" style="margin-top: -2px;">
                                                    <a
                                                        href="{{ route('siswa.add_parent_student', [$student_id, 'Ayah Kandung']) }}"><i
                                                            class="bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                            style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -10%;"></i></a>
                                                </div>
                                            @else
                                                <div class="col-md-6" style="margin-top: -2px; margin-left: -3.5%;">
                                                    <form class="form_parents"
                                                        action="{{ route('siswa.destroy_parent', $father->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('siswa.edit_parent', $father->id) }}"><i
                                                                class="bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                        <a href="#"><i
                                                                class="delete-confirm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
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
                                            <div class="col-md-4">
                                                <h3>Data Ibu Kandung</h3>
                                            </div>
                                            @if ($mother == null)
                                                <div class="col-md-6" style="margin-top: -2px;">
                                                    <a
                                                        href="{{ route('siswa.add_parent_student', [$student_id, 'Ibu Kandung']) }}"><i
                                                            class="bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                            style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -15%;"></i></a>
                                                </div>
                                            @else
                                                <div class="col-md-6" style="margin-top: -2px;">
                                                    <form action="{{ route('siswa.destroy_parent', $mother->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('siswa.edit_parent', $mother->id) }}"><i
                                                                class="bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -15%;"></i></a>
                                                        <a href="#"><i
                                                                class="delete-confirm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
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
                                            <div class="col-md-3">
                                                <h3>Data Wali</h3>
                                            </div>
                                            @if ($guardian == null)
                                                <div class="col-md-6" style="margin-top: -2px;">
                                                    <a
                                                        href="{{ route('siswa.add_parent_student', [$student_id, 'wali']) }}"><i
                                                            class="bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                            style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                </div>
                                            @else
                                                <div class="col-md-6" style="margin-top: -2px; margin-left: -8%;">
                                                    <form action="{{ route('siswa.destroy_parent', $guardian->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('siswa.edit_parent', $guardian->id) }}"><i
                                                                class="bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -5%;"></i></a>
                                                        <a href="#"><i
                                                                class="bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
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
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('siswa.edit', $student_id) }}"
                                                    class="btn btn-secondary waves-effect btn-sm">Kembali</a>
                                                {{-- <button class="btn btn-primary btn-sm" type="submit" style="float: right"
                                                    id="submit">Simpan</button> --}}
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

    <script>
        $('.delete-confirm').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Data',
                text: 'Ingin menghapus data?',
                icon: 'question',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: "Batal",
                focusConfirm: false,
            }).then((value) => {
                if (value.isConfirmed) {
                    $(this).closest("form").submit()
                }
            });
        });
    </script>
@endsection
