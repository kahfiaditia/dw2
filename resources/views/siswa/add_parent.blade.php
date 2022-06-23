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
                <form class="needs-validation" action="{{ route('siswa.store_parent_student') }}"
                    enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
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
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="">Nama Siswa</label>
                                                    <h3>{{ $student->nama_lengkap }}</h3>
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
                                                    <h3>Data {{ $type }}</h3>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama {{ $type }}<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_orang_tua"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_orang_tua') }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_orang_tua')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">NIK {{ $type }} <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        name="nik_orang_tua" required placeholder="NIK {{ $type }}"
                                                        value="{{ old('nik_orang_tua') }}" maxlength="16" minlength="16">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nik_orang_tua')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tanggal Lahir <code>*</code></label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            name="tanggal_lahir_orang_tua"
                                                            value="{{ old('tanggal_lahir_orang_tua') }}"
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
                                                        name="no_handphone_orang_tua" required placeholder="No Handphone"
                                                        value="{{ old('no_handphone_orang_tua') }}" minlength="11"
                                                        maxlength="13">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('no_handphone_orang_tua')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pendidikan<code>*</code></label>
                                                    <select name="pendidikan_orang_tua" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pilih Pendidikan --</option>
                                                        <option value="Tidak Sekolah"
                                                            {{ old('pendidikan_orang_tua') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                            Tidak Sekolah</option>
                                                        <option value="Putus SD"
                                                            {{ old('pendidikan_orang_tua') == 'Putus SD' ? 'selected' : '' }}>
                                                            Putus SD</option>
                                                        <option value="SD Sederajat"
                                                            {{ old('pendidikan_orang_tua') == 'SD Sederajat' ? 'selected' : '' }}>
                                                            SD Sederajat</option>
                                                        <option value="SMP Sederajat"
                                                            {{ old('pendidikan_orang_tua') == 'SMP Sederajat' ? 'selected' : '' }}>
                                                            SMP Sederajat</option>
                                                        <option value="SMA Sederajat"
                                                            {{ old('pendidikan_orang_tua') == 'SMA Sederajat' ? 'selected' : '' }}>
                                                            SMA Sederajat</option>
                                                        <option value="D1"
                                                            {{ old('pendidikan_orang_tua') == 'D1' ? 'selected' : '' }}>
                                                            D1
                                                        </option>
                                                        <option value="D2"
                                                            {{ old('pendidikan_orang_tua') == 'D2' ? 'selected' : '' }}>
                                                            D2
                                                        </option>
                                                        <option value="D3"
                                                            {{ old('pendidikan_orang_tua') == 'D3' ? 'selected' : '' }}>
                                                            D3
                                                        </option>
                                                        <option value="D4/S1"
                                                            {{ old('pendidikan_orang_tua') == 'D4/S1' ? 'selected' : '' }}>
                                                            D4/S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ old('pendidikan_orang_tua') == 'S2' ? 'selected' : '' }}>
                                                            S2
                                                        </option>
                                                        <option value="S3"
                                                            {{ old('pendidikan_orang_tua') == 'S3' ? 'selected' : '' }}>
                                                            S3
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pendidikan_orang_tua')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Pekerjaan <code>*</code></label>
                                                    <select name="pekerjaan_orang_tua" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pekerjaan --</option>
                                                        <option value="Tidak Bekerja"
                                                            {{ old('pekerjaan_orang_tua') == 'Tidak Bekerja' ? 'selected' : '' }}>
                                                            Tidak Bekerja</option>
                                                        <option value="Nelayan"
                                                            {{ old('pekerjaan_orang_tua') == 'Nelayan' ? 'selected' : '' }}>
                                                            Nelayan</option>
                                                        <option value="Petani"
                                                            {{ old('pekerjaan_orang_tua') == 'Petani' ? 'selected' : '' }}>
                                                            Petani</option>
                                                        <option value="Peternak"
                                                            {{ old('pekerjaan_orang_tua') == 'Peternak' ? 'selected' : '' }}>
                                                            Peternak</option>
                                                        <option value="PNS/TNI/POLRI"
                                                            {{ old('pekerjaan_orang_tua') == 'PNS/TNI/POLRI' ? 'selected' : '' }}>
                                                            PNS/TNI/POLRI</option>
                                                        <option value="Karyawan Swasta"
                                                            {{ old('pekerjaan_orang_tua') == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                            Karyawan Swasta</option>
                                                        <option value="Pedagang Kecil"
                                                            {{ old('pekerjaan_orang_tua') == 'Pedagang Kecil' ? 'selected' : '' }}>
                                                            Pedagang Kecil</option>
                                                        <option value="Pedagang Besar"
                                                            {{ old('pekerjaan_orang_tua') == 'Pedagang Besar' ? 'selected' : '' }}>
                                                            Pedagang Besar</option>
                                                        <option value="Wiraswasta"
                                                            {{ old('pekerjaan_orang_tua') == 'Wiraswasta' ? 'selected' : '' }}>
                                                            Wiraswasta</option>
                                                        <option value="Wirausaha"
                                                            {{ old('pekerjaan_orang_tua') == 'Wirausaha' ? 'selected' : '' }}>
                                                            Wirausaha</option>
                                                        <option value="Buruh"
                                                            {{ old('pekerjaan_orang_tua') == 'Buruh' ? 'selected' : '' }}>
                                                            Buruh</option>
                                                        <option value="Pensiunan"
                                                            {{ old('pekerjaan_orang_tua') == 'Pensiunan' ? 'selected' : '' }}>
                                                            Pensiunan</option>
                                                        <option value="Dll"
                                                            {{ old('pekerjaan_orang_tua') == 'Dll' ? 'selected' : '' }}>
                                                            Dll</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('pekerjaan_orang_tua')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Penghasilan <code>*</code></label>
                                                    <select name="penghasilan_orang_tua" class="select2 form-control"
                                                        required>
                                                        <option value="">-- Pilih Penghasilan --</option>
                                                        <option value="< Rp. 500.000"
                                                            {{ old('penghasilan_orang_tua') == '< Rp. 500.000' ? 'selected' : '' }}>
                                                            < Rp. 500.000</option>
                                                        <option value="Rp. 500.000 - Rp. 999.9999"
                                                            {{ old('penghasilan_orang_tua') == 'Rp. 500.000 - Rp. 999.999' ? 'selected' : '' }}>
                                                            Rp. 500.000 - Rp. 999.999</option>
                                                        <option value="Rp. 1.000.000 - Rp. 1.999.999"
                                                            {{ old('penghasilan_orang_tua') == 'Rp. 1.000.000 - Rp. 1.999.999' ? 'selected' : '' }}>
                                                            Rp. 1.000.000 - Rp. 1.999.999</option>
                                                        <option value="Rp. 2.000.000 - Rp. 4.999.999"
                                                            {{ old('penghasilan_orang_tua') == 'Rp. 2.000.000 - Rp. 4.999.999' ? 'selected' : '' }}>
                                                            Rp. 2.000.000 - Rp. 4.999.999</option>
                                                        <option value="Rp. 5.000.000 - Rp. 20.000.000"
                                                            {{ old('penghasilan_orang_tua') == 'Rp. 5.000.000 - Rp. 20.000.000' ? 'selected' : '' }}>
                                                            Rp. 5.000.000 - Rp. 20.000.000</option>
                                                        <option value="> Rp. 20.000.000"
                                                            {{ old('penghasilan_orang_tua') == '> Rp. 20.000.000' ? 'selected' : '' }}>
                                                            > Rp. 20.000.000</option>
                                                        <option value="Tidak Berpenghasilan"
                                                            {{ old('penghasilan_orang_tua') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>
                                                            Tidak Berpenghasilan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('penghasilan_orang_tua')
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
                                            </div>
                                            @if ($type == 'Ibu Kandung')
                                                <input type="hidden" name="type" value="Ibu">
                                            @elseif($type == 'Ayah Kandung')
                                                <input type="hidden" name="type" value="Ayah">
                                            @else
                                                <input type="hidden" name="type" value="Wali">
                                            @endif
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('siswa.show_parents', $student->id) }}"
                                                        class="btn btn-secondary waves-effect btn-sm">Kembali</a>
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
