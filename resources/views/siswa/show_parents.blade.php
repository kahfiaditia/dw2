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
                    @include('siswa.student_menu')
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="py-3 border-bottm">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-3">
                                                        <h3>Ayah Kandung</h3>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        @if ($father == null)
                                                            <a
                                                                href="{{ route('siswa.add_parent_student', [\Crypt::encryptString($student->id), 'Ayah Kandung']) }}"><i
                                                                    class="btn-sm bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"></i></a>
                                                        @else
                                                            <form class="form_parents"
                                                                action="{{ route('siswa.destroy_parent', \Crypt::encryptString($father->id)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a
                                                                    href="{{ route('siswa.edit_parent', [\Crypt::encryptString($father->id), 'Ayah Kandung']) }}"><i
                                                                        class="btn-sm bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"></i></a>
                                                                <a href="#"><i
                                                                        class="delete-confirm btn-sm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"></i></a>
                                                            </form>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
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
                                                    <h5 class="font-size-14">Nomor Handphone</h5>
                                                    <p class="text-muted">
                                                        {{ $father->no_hp }}
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
                                            <div class="py-3 border-bottm">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-3">
                                                        <h3>Ibu Kandung</h3>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        @if ($mother == null)
                                                            <a
                                                                href="{{ route('siswa.add_parent_student', [\Crypt::encryptString($student->id), 'Ibu Kandung']) }}"><i
                                                                    class="btn-sm bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"></i></a>
                                                        @else
                                                            <form class="form_parents"
                                                                action="{{ route('siswa.destroy_parent', \Crypt::encryptString($mother->id)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a
                                                                    href="{{ route('siswa.edit_parent', [\Crypt::encryptString($mother->id), 'Ibu Kandung']) }}"><i
                                                                        class="btn-sm bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"></i></a>
                                                                <a href="#"><i
                                                                        class="delete-confirm btn-sm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"></i></a>
                                                            </form>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
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
                                                    <h5 class="font-size-14">Nomor Handphone</h5>
                                                    <p class="text-muted">
                                                        {{ $mother->no_hp }}
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
                                            <div class="py-3 border-bottm">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-3">
                                                        <h3>Wali</h3>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        @if ($guardian == null)
                                                            <a
                                                                href="{{ route('siswa.add_parent_student', [\Crypt::encryptString($student->id), 'wali']) }}"><i
                                                                    class="btn-sm bg-primary rounded mdi mdi-plus text-white font-weight-bold font-size-20"></i></a>
                                                        @else
                                                            <form class="form_parents"
                                                                action="{{ route('siswa.destroy_parent', \Crypt::encryptString($guardian->id)) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a
                                                                    href="{{ route('siswa.edit_parent', [\Crypt::encryptString($guardian->id), 'wali']) }}"><i
                                                                        class="btn-sm bg-info rounded mdi mdi-pencil text-white font-weight-bold font-size-20"></i></a>
                                                                <a href="#"><i
                                                                        class="delete-confirm btn-sm bg-danger rounded mdi mdi-delete text-white font-weight-bold font-size-20"></i></a>
                                                            </form>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
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
                                                    <h5 class="font-size-14">Nomor Handphone</h5>
                                                    <p class="text-muted">
                                                        {{ $guardian->no_hp }}
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
                                        <hr>
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('siswa.edit', \Crypt::encryptString($student->id)) }}"
                                                    class="btn btn-secondary waves-effect">Kembali</a>
                                                <a href="{{ route('siswa.show_periodic', Crypt::encryptString($student->id)) }}"
                                                    style="float: right" class="btn btn-primary">Selanjutnya</a>
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
