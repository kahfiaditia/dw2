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
                                            <div class="col-12">
                                                <div
                                                    class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                    <div class="page-title-left">
                                                        <h4 class="mb-sm-0 font-size-18">{{ $label }}
                                                        </h4>
                                                        <ol class="breadcrumb m-0">
                                                            <li class="breadcrumb-item">{{ ucwords($menu) }}
                                                            </li>
                                                            <li class="breadcrumb-item">
                                                                {{ ucwords($submenu) }}</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form method="POST"
                                                            action="{{ route('siswa.update_performance_student', $performance->id) }}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $performance->siswa_id }}">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Jenis
                                                                                Prestasi</label>
                                                                            <select name="jenis_prestasi" id=""
                                                                                required class="form-control">
                                                                                <option value="">-- Pilih Jenis
                                                                                    Prestasi --
                                                                                </option>
                                                                                @foreach ($performance_types as $performance_type)
                                                                                    <option
                                                                                        value="{{ $performance_type }}"
                                                                                        @if ($performance_type == $performance->jenis_prestasi) selected @endif>
                                                                                        {{ $performance_type }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputPassword1">Tingkat
                                                                                Prestasi</label>
                                                                            <select name="tingkat_prestasi" id=""
                                                                                class="form-control" required>
                                                                                <option value="">-- Pilih Tingkat
                                                                                    Prestasi
                                                                                    --</option>
                                                                                @foreach ($performance_levels as $performance_level)
                                                                                    <option
                                                                                        value="{{ $performance_level }}"
                                                                                        @if ($performance_level == $performance->tingkat_prestasi) selected @endif>
                                                                                        {{ $performance_level }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="">Nama Prestasi</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama_prestasi"
                                                                                placeholder="Nama Prestasi"
                                                                                value="{{ old('nama_prestasi', $performance->nama_prestasi) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="">Tahun Prestasi</label>
                                                                            <input type="text"
                                                                                class="number-only form-control"
                                                                                name="tahun_prestasi"
                                                                                placeholder="Tahun Prestasi" maxlength="4"
                                                                                minlength="4"
                                                                                value="{{ old('tahun_prestasi', $performance->tahun_prestasi) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="">Penyelenggara</label>
                                                                            <input type="text" class="form-control"
                                                                                name="penyelenggara"
                                                                                placeholder="Peneyelenggara"
                                                                                value="{{ old('penyelenggara', $performance->penyelenggara) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="">Peringkat</label>
                                                                            <input type="text"
                                                                                class="number-only form-control"
                                                                                name="peringkat" placeholder="peringkat"
                                                                                value="{{ old('peringkat', $performance->peringkat) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{ route('siswa.list_performance_students', $student->id) }}"
                                                                    type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Batal</a>
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm">Simpan</button>
                                                            </div>
                                                        </form>
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
