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
                <form class="needs-validation" action="{{ route('parents.store') }}" enctype="multipart/form-data"
                    method="POST" novalidate>
                    @csrf
                    <div class="row">
                        @if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')
                            <?php $device = 'style="display:none;"';
                            $column = '12'; ?>
                        @else
                            <?php $device = '';
                            $column = '10'; ?>
                        @endif
                        <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a href="{{ route('siswa.create') }}"
                                    class="nav-link @if ($submenu == 'siswa') active @endif">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Pribadi</p>
                                </a>
                                <a class="nav-link @if ($submenu == 'parent') active @endif"
                                    href="{{ route('parents.index') }}">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                    <p class="fw-bold mb-4">Orang Tua / Wali</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Wali</p>
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
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="">Nama Siswa</label>
                                                    <select name="siswa_id" class="form-control select2" required>
                                                        <option value="">-- Pilih Siswa --</option>
                                                        @foreach ($students as $student)
                                                            <option value="{{ $student->id }}">
                                                                {{ $student->nisn . ' - ' . $student->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('siswa_id')
                                                        <small class="text-danger">{{ 'Siswa harus dipilih' }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <hr style="width: 100%">
                                                </div>
                                                <div class="col-md-12">
                                                    <h3>Data Ayah Kandung</h3>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama Ayah Kandung<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_ayah_kandung"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_ayah_kandung') }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_ayah_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK Ayah <code>*</code></label>
                                                    <input type="text" class="number-only form-control" name="nik_ayah"
                                                        required placeholder="NIK Ayah" value="{{ old('nik_ayah') }}"
                                                        maxlength="16" minlength="16">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nik_ayah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir <code>*</code></label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            name="tanggal_lahir_ayah"
                                                            value="{{ old('tanggal_lahir_ayah') }}"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                            data-provide="datepicker" required data-date-autoclose="true">
                                                        <span class="input-group-text"><i
                                                                class="mdi mdi-calendar"></i></span>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                    @error('tahun_lahir')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">No Handphone <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        name="no_handphone_ayah" required placeholder="No Handphone"
                                                        value="{{ old('no_handphone_ayah') }}" minlength="11"
                                                        maxlength="13">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('no_handphone_ayah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan_ayah" class="select2 form-control" required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan_ayah') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan_ayah') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan_ayah') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan_ayah') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan_ayah') == 'D1' ? 'selected' : '' }}>D1
                                                        </option>
                                                        <option value="D2"
                                                            {{ old('pendidikan_ayah') == 'D2' ? 'selected' : '' }}>D2
                                                        </option>
                                                        <option value="D3"
                                                            {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3
                                                        </option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan_ayah') == 'D4/S1' ? 'selected' : '' }}>
                                                            D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2
                                                        </option>
                                                        <option value="S3"
                                                            {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pendidikan_ayah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan <code>*</code></label>
                                                    <select name="pekerjaan_ayah" class="select2 form-control" required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan_ayah') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan_ayah') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan_ayah') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan_ayah') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan_ayah') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan_ayah') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan_ayah') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan_ayah') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan_ayah') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan_ayah') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan_ayah') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan_ayah') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan_ayah') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pekerjaan_ayah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan <code>*</code></label>
                                                    <select name="penghasilan_ayah" class="select2 form-control" required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan_ayah') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan_ayah') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan_ayah') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan_ayah') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan_ayah') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan_ayah') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan_ayah') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nisn')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Kebutuhan
                                                            Khusus<code>*</code></label>
                                                        <select name="kebutuhan_khusus" class="form-control select2"
                                                            required>
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}"
                                                                    {{ old('kebutuhan_khusus') == $special_need->id ? 'selected' : '' }}>
                                                                    {{ $special_need->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('kebutuhan_khusus')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr style="width: 100%">
                                                </div>
                                                <div class="col-md-12">
                                                    <h3>Data Ibu Kandung</h3>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama Ibu Kandung<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_ibu_kandung"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_ibu_kandung') }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK Ibu Kandung <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        name="nik_ibu_kandung" required placeholder="NIK Ibu Kandung"
                                                        value="{{ old('nik_ibu_kandung') }}" minlength="16"
                                                        maxlength="16">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nik_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir <code>*</code></label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            name="tanggal_lahir_ibu_kandung"
                                                            value="{{ old('tanggal_lahir_ibu_kandung') }}"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                            data-provide="datepicker" required data-date-autoclose="true">
                                                        <span class="input-group-text"><i
                                                                class="mdi mdi-calendar"></i></span>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                    @error('tahun_lahir_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">No Handphone Ibu Kandung <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        placeholder="No Handphone Ibu Kandung"
                                                        name="no_handphone_ibu_kandung" required
                                                        value="{{ old('no_handphone_ibu_kandung') }}" minlength="11"
                                                        maxlength="13">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('no_handphone_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan_ibu_kandung" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan_ibu_kandung') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan_ibu_kandung') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan_ibu_kandung') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan_ibu_kandung') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan_ibu_kandung') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan_ibu_kandung') == 'D1' ? 'selected' : '' }}>
                                                            D1</option>
                                                        <option value="D2"
                                                            {{ old('pendidikan_ibu_kandung') == 'D2' ? 'selected' : '' }}>
                                                            D2</option>
                                                        <option value="D3"
                                                            {{ old('pendidikan_ibu_kandung') == 'D3' ? 'selected' : '' }}>
                                                            D3</option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan_ibu_kandung') == 'D4/S1' ? 'selected' : '' }}>
                                                            D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan_ibu_kandung') == 'S2' ? 'selected' : '' }}>
                                                            S2</option>
                                                        <option value="S3"
                                                            {{ old('pendidikan_ibu_kandung') == 'S3' ? 'selected' : '' }}>
                                                            S3</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pendidikan_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan <code>*</code></label>
                                                    <select name="pekerjaan_ibu_kandung" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan_ibu_kandung') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Ibu Rumah Tangga"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>
                                                            Ibu Rumah Tangga</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan_ibu_kandung') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pekerjaan_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan <code>*</code></label>
                                                    <select name="penghasilan_ibu_kandung" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan_ibu_kandung') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan_ibu_kandung') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan_ibu_kandung') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan_ibu_kandung') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan_ibu_kandung') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan_ibu_kandung') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan_ibu_kandung') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nisn')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Kebutuhan
                                                            Khusus<code>*</code></label>
                                                        <select name="kebutuhan_khusus_ibu" class="form-control select2"
                                                            required>
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}"
                                                                    {{ old('kebutuhan_khusus_ibu') == $special_need->id ? 'selected' : '' }}>
                                                                    {{ $special_need->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('kebutuhan_khusus_ibu')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <hr style="width: 100%">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <h3>Data Wali</h3>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama Wali<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_wali"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_wali') }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK Wali <code>*</code></label>
                                                    <input type="text" class="number-only form-control" name="nik_wali"
                                                        required placeholder="NIK Wali" value="{{ old('nik_wali') }}"
                                                        minlength="16" maxlength="16">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nik_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir <code>*</code></label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            name="tanggal_lahir_wali"
                                                            value="{{ old('tanggal_lahir_wali') }}"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                            data-provide="datepicker" required data-date-autoclose="true">
                                                        <span class="input-group-text"><i
                                                                class="mdi mdi-calendar"></i></span>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                    @error('tahun_lahir_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">No Handphone Wali <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        name="no_handphone_wali" placeholder="No Handphone Wali" required
                                                        value="{{ old('no_handphone_wali') }}" minlength="11"
                                                        maxlength="13">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('no_handphone_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan_wali" class="select2 form-control" required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan_wali') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan_wali') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan_wali') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan_wali') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan_wali') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan_wali') == 'D1' ? 'selected' : '' }}>D1
                                                        </option>
                                                        <option value="D2"
                                                            {{ old('pendidikan_wali') == 'D2' ? 'selected' : '' }}>D2
                                                        </option>
                                                        <option value="D3"
                                                            {{ old('pendidikan_wali') == 'D3' ? 'selected' : '' }}>D3
                                                        </option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan_wali') == 'D4/S1' ? 'selected' : '' }}>
                                                            D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan_wali') == 'S2' ? 'selected' : '' }}>S2
                                                        </option>
                                                        <option value="S3"
                                                            {{ old('pendidikan_wali') == 'S3' ? 'selected' : '' }}>S3
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pendidikan_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan <code>*</code></label>
                                                    <select name="pekerjaan_wali" class="select2 form-control" required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan_wali') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan_wali') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan_wali') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan_wali') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan_wali') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan_wali') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan_wali') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan_wali') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan_wali') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan_wali') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan_wali') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan_wali') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Ibu Rumah Tangga"
                                                            {{ old('pekerjaan_wali') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>
                                                            Ibu Rumah Tangga</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan_wali') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pekerjaan_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan <code>*</code></label>
                                                    <select name="penghasilan_wali" id="penghasilan_wali"
                                                        class="select2 form-control" required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan_wali') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan_wali') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan_wali') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan_wali') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan_wali') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan_wali') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan_wali') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('penghasilan_wali')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Kebutuhan
                                                            Khusus<code>*</code></label>
                                                        <select name="kebutuhan_khusus_wali" class="form-control select2"
                                                            required>
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}"
                                                                    {{ old('kebutuhan_khusus_wali') == $special_need->id ? 'selected' : '' }}>
                                                                    {{ $special_need->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('kebutuhan_khusus_wali')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="type_ayah" value="ayah">
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <a href="{{ route('employee') }}"
                                                            class="btn btn-secondary waves-effect btn-sm">Batal</a>
                                                        <button class="btn btn-primary btn-sm" type="submit"
                                                            style="float: right" id="submit">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
