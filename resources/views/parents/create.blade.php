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
                <form class="needs-validation" action="{{ route('siswa.store') }}" enctype="multipart/form-data"
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
                                    href="{{ route('parents.create') }}">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                    <p class="fw-bold mb-4">Orang Tua</p>
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
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="">Nama Siswa</label>
                                                    <select name="siswa_id" class="form-control">
                                                        <option value="">-- Pilih Siswa --</option>
                                                        @foreach ($students as $student)
                                                            <option value="{{ $student->id }}">
                                                                {{ $student->nisn . ' - ' . $student->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                    @error('nama_ayah_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK Ayah</label>
                                                    <input type="text" class="form-control" name="nik_ayah" required
                                                        placeholder="NIK Ayah" value="{{ old('nik_ayah') }}">
                                                    @error('nik_ayah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir</label>
                                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    @error('tahun_lahir')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan" class="select2 form-control" required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan') == 'D1' ? 'selected' : '' }}>D1</option>
                                                        <option value="D2"
                                                            {{ old('pendidikan') == 'D2' ? 'selected' : '' }}>D2</option>
                                                        <option value="D3"
                                                            {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan') == 'D4/S1' ? 'selected' : '' }}>D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                                        <option value="S3"
                                                            {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                                    </select>
                                                    @error('pendidikan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan</label>
                                                    <select name="pekerjaan" class="select2 form-control" required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    @error('pekerjaan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan</label>
                                                    <select name="penghasilan" class="select2 form-control" required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    @error('nisn')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Kebutuhan
                                                            Khusus<code>*</code></label>
                                                        <select name="" class="form-control select2">
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}">
                                                                    {{ $special_need->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kebutuhan_khusus')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="type_ayah" value="ayah">
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
                                                    @error('nama_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK Ibu Kandung</label>
                                                    <input type="text" class="form-control" name="nik_ibu_kandung"
                                                        required placeholder="NIK Ibu Kandung"
                                                        value="{{ old('nik_ibu_kandung') }}">
                                                    @error('nik_ibu_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir</label>
                                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    @error('tahun_lahir')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan" class="select2 form-control" required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan') == 'D1' ? 'selected' : '' }}>D1</option>
                                                        <option value="D2"
                                                            {{ old('pendidikan') == 'D2' ? 'selected' : '' }}>D2</option>
                                                        <option value="D3"
                                                            {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan') == 'D4/S1' ? 'selected' : '' }}>D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                                        <option value="S3"
                                                            {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                                    </select>
                                                    @error('pendidikan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan</label>
                                                    <select name="pekerjaan" class="select2 form-control" required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Ibu Rumah Tangga"
                                                            {{ old('pekerjaan') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>
                                                            Ibu Rumah Tangga</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    @error('pekerjaan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan</label>
                                                    <select name="penghasilan" class="select2 form-control" required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    @error('nisn')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Kebutuhan
                                                            Khusus<code>*</code></label>
                                                        <select name="" class="form-control select2">
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}">
                                                                    {{ $special_need->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kebutuhan_khusus')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="type_ayah" value="ibu">
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <a href="{{ route('employee') }}"
                                                            class="btn btn-secondary waves-effect">Batal</a>
                                                        <button class="btn btn-primary" type="submit" style="float: right"
                                                            id="submit">Simpan</button>
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
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            // user data - admin
            $.ajax({
                type: "POST",
                url: '{{ route('employee.dropdown_email_create') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    console.log(response)
                    $.each(response, function(i, item) {
                        $('.Email_admin').append(
                            `<option value="${item.id}">${item.email}</option>`
                        )
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });
            $(".Email_admin").change(function() {
                let user_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('employee.get_email') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        user_id
                    },
                    success: response => {
                        if (response.code === 404) {
                            Swal.fire(
                                'Gagal',
                                `${response.message}`,
                                'error'
                            ).then(function() {})
                            $(".Roles_admin").val('');
                            document.getElementById("submit").disabled = true;
                        } else {
                            $(".Roles_admin").val(response.user);
                            document.getElementById("submit").disabled = false;
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });

            // valdasi extension
            $('#foto').bind('change', function() {
                var file = document.querySelector("#foto");
                if (/\.(jpe?g|png|jpg)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg',
                        'error'
                    ).then(function() {})
                    document.getElementById('foto').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('foto').value = null;
                    }
                }
            });
            $('#dok_nik').bind('change', function() {
                var file = document.querySelector("#dok_nik");
                if (/\.(jpe?g|png|jpg|pdf)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg, pdf',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_nik').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('dok_nik').value = null;
                    }
                }
            });
            $('#dok_npwp').bind('change', function() {
                var file = document.querySelector("#dok_npwp");
                if (/\.(jpe?g|png|jpg|pdf)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg, pdf',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_npwp').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('dok_npwp').value = null;
                    }
                }
            });
            $('#dok_kk').bind('change', function() {
                var file = document.querySelector("#dok_kk");
                if (/\.(jpe?g|png|jpg|pdf)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg, pdf',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_kk').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('dok_kk').value = null;
                    }
                }
            });

            // agama
            $.ajax({
                type: "POST",
                url: '{{ route('agama.dropdown') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        $('.Agama').append(
                            `<option value="${item.id}">${item.agama}</option>`
                        )
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            // provinsi
            $.ajax({
                type: "POST",
                url: '{{ route('kodepos.dropdown') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        $('.ProvinsiA').append(
                            `<option value="${item.provinsi}">${item.provinsi}</option>`)
                    })
                    $.each(response, function(i, item) {
                        $('.ProvinsiT').append(
                            `<option value="${item.provinsi}">${item.provinsi}</option>`)
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });
            // kabupaten Asal
            $(".ProvinsiA").change(function() {
                let Provinsi = $(this).val();
                $(".KotaA option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.provinsi') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi
                    },
                    success: response => {
                        $('.KotaA').append(`<option value="">-- Pilih Kota --</option>`)
                        $.each(response, function(i, item) {
                            $('.KotaA').append(
                                `<option value="${item.kabupaten}">${item.kabupaten}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kecamatan Asal
            $(".KotaA").change(function() {
                let Provinsi = document.getElementById("ProvinsiA").value;
                let Kota = $(this).val();
                $(".KecamatanA option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kota') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota
                    },
                    success: response => {
                        $('.KecamatanA').append(
                            `<option value="">-- Pilih Kecamatan --</option>`)
                        $.each(response, function(i, item) {
                            $('.KecamatanA').append(
                                `<option value="${item.kecamatan}">${item.kecamatan}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kelurahan Asal
            $(".KecamatanA").change(function() {
                let Provinsi = document.getElementById("ProvinsiA").value;
                let Kota = document.getElementById("KotaA").value;
                let Kecamatan = $(this).val();
                $(".KelurahanA option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kecamatan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota,
                        Kecamatan
                    },
                    success: response => {
                        $('.KelurahanA').append(
                            `<option value="">-- Pilih Kelurahan --</option>`)
                        $.each(response, function(i, item) {
                            $('.KelurahanA').append(
                                `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kodepos Asal
            $(".KelurahanA").change(function() {
                let Provinsi = document.getElementById("ProvinsiA").value;
                let Kota = document.getElementById("KotaA").value;
                let Kecamatan = document.getElementById("KecamatanA").value;
                let Kelurahan = $(this).val();
                $(".KodeposA option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kelurahan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota,
                        Kecamatan,
                        Kelurahan
                    },
                    success: response => {
                        $('.KodeposA').append(`<option value="">-- Pilih Kodepos --</option>`)
                        $.each(response, function(i, item) {
                            $('.KodeposA').append(
                                `<option value="${item.kodepos}">${item.kodepos}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // Provinsi TNG
            $(".ProvinsiT").change(function() {
                let Provinsi = $(this).val();
                $(".KotaT option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.provinsi') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi
                    },
                    success: response => {
                        $('.KotaT').append(`<option value="">-- Pilih Kota --</option>`)
                        $.each(response, function(i, item) {
                            $('.KotaT').append(
                                `<option value="${item.kabupaten}">${item.kabupaten}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kecamatan TNG
            $(".KotaT").change(function() {
                let Provinsi = document.getElementById("ProvinsiT").value;
                let Kota = $(this).val();
                $(".KecamatanT option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kota') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota
                    },
                    success: response => {
                        $('.KecamatanT').append(
                            `<option value="">-- Pilih Kecamatan --</option>`)
                        $.each(response, function(i, item) {
                            $('.KecamatanT').append(
                                `<option value="${item.kecamatan}">${item.kecamatan}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kelurahan TNG
            $(".KecamatanT").change(function() {
                let Provinsi = document.getElementById("ProvinsiT").value;
                let Kota = document.getElementById("KotaT").value;
                let Kecamatan = $(this).val();
                $(".KelurahanT option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kecamatan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota,
                        Kecamatan
                    },
                    success: response => {
                        $('.KelurahanT').append(
                            `<option value="">-- Pilih Kelurahan --</option>`)
                        $.each(response, function(i, item) {
                            $('.KelurahanT').append(
                                `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
            // kodepos TNG
            $(".KelurahanT").change(function() {
                let Provinsi = document.getElementById("ProvinsiT").value;
                let Kota = document.getElementById("KotaT").value;
                let Kecamatan = document.getElementById("KecamatanT").value;
                let Kelurahan = $(this).val();
                $(".KodeposT option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('kodepos.dropdown.kelurahan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        Provinsi,
                        Kota,
                        Kecamatan,
                        Kelurahan
                    },
                    success: response => {
                        $('.KodeposT').append(`<option value="">-- Pilih Kodepos --</option>`)
                        $.each(response, function(i, item) {
                            $('.KodeposT').append(
                                `<option value="${item.kodepos}">${item.kodepos}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        });

        function Myalamat() {
            var x = document.getElementsByClassName("alamat-sama");
            var i;
            if (document.getElementById('AlamatSama').checked) {
                for (i = 0; i < x.length; i++) {
                    x[i].disabled = true;
                }
            } else {
                for (i = 0; i < x.length; i++) {
                    x[i].disabled = false;
                }
            }
        }
        $('.delete_confirm').on('click', function(event) {
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
