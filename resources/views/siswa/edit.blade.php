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
                <form class="needs-validation" action="{{ route('siswa.update', \Crypt::encryptString($student->id)) }}"
                    enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    @method('PATCH')
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
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama Lengkap<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_lengkap', $student->nama_lengkap) }}">
                                                    <input type="hidden" name="nama_lengkap_old"
                                                        value="{{ $student->nama_lengkap }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_lengkap')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Email <code>*</code></label>
                                                    <input type="email" class="form-control" name="email" required
                                                        readonly placeholder="Email"
                                                        value="{{ old('email', $student->email) }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nomor Handphone<code>*</code></label>
                                                    <input type="text" class="form-control number-only"
                                                        name="no_handphone" required
                                                        value="{{ old('no_handphone', $student->no_handphone) }}"
                                                        minlength="12" maxlength="13" placeholder="Nomor Handphone">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('no_handphone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Jenis Kelamin<code>*</code></label>
                                                    <select name="jenis_kelamin" class="form-control select select2"
                                                        required>
                                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                                        <option value="Laki - Laki"
                                                            @if ($student->jenis_kelamin == 'Laki - Laki') selected @endif
                                                            {{ old('jenis_kelamin') == 'Laki - Laki' ? 'selected' : '' }}>
                                                            Laki - Laki</option>
                                                        <option value="Perempuan"
                                                            @if ($student->jenis_kelamin == 'Perempuan') selected @endif
                                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('jenis_kelamin')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Golongan Darah <code>*</code></label>
                                                    <select name="golongan_darah" class="form-control select select2"
                                                        required>
                                                        <option value="">-- Pilih Golongan Darah --</option>
                                                        @foreach ($blood_types as $blood_type)
                                                            <option value="{{ $blood_type['value'] }}"
                                                                {{ old('A') == 'A' ? 'selected' : '' }}
                                                                @if ($blood_type['value'] == $student->golongan_darah) selected @endif>
                                                                {{ $blood_type['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('golongan_darah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom02" class="form-label">NIS (No Induk
                                                        Sekolah)
                                                        <code>*</code></label>
                                                    <input type="text" class="form-control input-mask" name="nis"
                                                        id="nis" maxlength="20" required
                                                        value="{{ old('nis', $student->nis) }}" placeholder="NIS">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nis')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom02" class="form-label">NISN
                                                        <code>*</code></label>
                                                    <input type="text" class="form-control number-only nisn"
                                                        name="nisn" placeholder="NISN"
                                                        value="{{ old('nisn', $student->nisn) }}" maxlength="20" required>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nisn')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02"
                                                            class="form-label">NIK<code>*</code></label>
                                                        <input type="text" class="form-control number-only"
                                                            name="nik" placeholder="NIK"
                                                            value="{{ old('nik', $student->nik) }}" maxlength="20"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('nik')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No
                                                            KK<code>*</code></label>
                                                        <input type="text" required name="no_kk"
                                                            class="number-only form-control" placeholder="Nomor KK"
                                                            value="{{ old('no_kk', $student->no_kk) }}" maxlength="20">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('no_kk')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Tempat
                                                            Lahir<code>*</code></label>
                                                        <input type="text" class="form-control" required
                                                            name="tempat_lahir" placeholder="Tempat Lahir"
                                                            value="{{ old('tempat_lahir', $student->tempat_lahir) }}">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('tempat_lahir')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Tanggal Lahir
                                                            <code>*</code></label>
                                                        <div class="input-group" id="datepicker2">
                                                            <input type="text" class="form-control"
                                                                placeholder="yyyy-mm-dd" name="tanggal_lahir"
                                                                value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}"
                                                                data-date-end-date="{{ date('Y-m-d') }}"
                                                                data-date-format="yyyy-mm-dd"
                                                                data-date-container='#datepicker2'
                                                                data-provide="datepicker" required
                                                                data-date-autoclose="true">
                                                            <span class="input-group-text"><i
                                                                    class="mdi mdi-calendar"></i></span>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                        @error('tanggal_lahir')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No Registrasi
                                                            Akta Lahir <code>*</code></label>
                                                        <input type="text" class="form-control" name="akta_lahir"
                                                            value="{{ old('akta_lahir', $student->no_registrasi_akta_lahir) }}"
                                                            placeholder="Nomor Akta Lahir" required>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('akta_lahir')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Agama
                                                            <code>*</code></label>
                                                        <select name="agama" class="form-control select2" required>
                                                            <option value="">-- Pilih Agama --</option>
                                                            @foreach ($religions as $religion)
                                                                <option value="{{ $religion->id }}"
                                                                    @if ($religion->id == $student->agama_id) selected @endif
                                                                    {{ old('agama') == $religion->id ? 'selected' : '' }}>
                                                                    {{ $religion->agama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('agama')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4">
                                                        <label>Kewarganegaraan <code>*</code></label>
                                                        <select name="kewarganegaraan" class="select2 form-control"
                                                            required>
                                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                                            <option value="WNI"
                                                                @if ($student->kewarganegaraan == 'WNI') selected @endif
                                                                {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>
                                                                Indonesia (WNI)</option>
                                                            <option value="WNA"
                                                                @if ($student->kewarganegaraan == 'WNA') selected @endif
                                                                {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>
                                                                Asing (WNA)</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('kewarganegaraan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="">Nama Negara <code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_negara"
                                                        required placeholder="Nama Negara"
                                                        value="{{ old('nama_negara', $student->nama_negara) }}">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('nama_negara')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Berkebutuhan
                                                            Khusus
                                                            <code>*</code></label>
                                                        <select name="kebutuhan_khusus"
                                                            class="form-control select select2" required>
                                                            <option value="">-- Pilih Kebutuhan Khusus --</option>
                                                            @foreach ($special_needs as $special_need)
                                                                <option value="{{ $special_need->id }}"
                                                                    @if ($student->kebutuhan_khusus_id == $special_need->id) selected @endif
                                                                    {{ old('kebutuhan_khusus') == $special_need->id ? 'selected' : '' }}>
                                                                    {{ $special_need->kode . ') ' . $special_need->nama }}
                                                                </option>
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
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Alamat Jalan
                                                            <code>*</code></label>
                                                        <textarea name="alamat_jalan" class="form-control" cols="5" placeholder="Alamat Jalan" required>{{ old('alamat_jalan', $student->alamat) }}</textarea>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('alamat_jalan')
                                                            <small class="text-center">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="">Tempat Tinggal <code>*</code></label>
                                                    <select name="tempat_tinggal" required
                                                        class="form-control select select2">
                                                        <option value="">-- Pilih Tempat Tinggal --</option>
                                                        @foreach ($residences as $residence)
                                                            @if ($residence['value'] == $student->tempat_tinggal)
                                                                <option value="{{ $residence['value'] }}" selected>
                                                                    {{ $residence['name'] }}</option>
                                                            @else
                                                                <option value="{{ $residence['value'] }}">
                                                                    {{ $residence['name'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('tempat_tinggal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationCustom02" class="form-label">RT
                                                                <code>*</code></label>
                                                            <input type="text" min="0"
                                                                class="number-only form-control" name="rt"
                                                                value="{{ old('rt', $student->rt) }}" required
                                                                placeholder="RT" maxlength="2" minlength="2">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('rt')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">RW <code>*</code></label>
                                                            <input type="text" class="number-only form-control"
                                                                name="rw" required placeholder="RW"
                                                                value="{{ old('rw', $student->rw) }}" maxlength="2"
                                                                minlength="2">
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('rw')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="formFile" class="form-label">Dusun
                                                                <code>*</code></label>
                                                            <input class="form-control" type="text" name="nama_dusun"
                                                                required placeholder="Nama Dusun"
                                                                value="{{ old('nama_dusun', $student->dusun) }}">
                                                            @error('nama_dusun')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Kecamatan <code>*</code></label>
                                                            <select name="kecamatan" id="kecamatan"
                                                                class="form-control select2" required>
                                                                <option value="">-- Pilih Kecamatan --</option>
                                                                @foreach ($districts as $district)
                                                                    @if ($district->kecamatan == $student->district)
                                                                        <option value="{{ $district->kecamatan }}"
                                                                            selected>
                                                                            {{ $district->kecamatan }}</option>
                                                                    @else
                                                                        <option value="{{ $district->kecamatan }}">
                                                                            {{ $district->kecamatan }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('kecamatan')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Kelurahan <code>*</code></label>
                                                            <select name="kelurahan" id="kelurahan"
                                                                class="form-control select2" required>
                                                                <option value="">-- Pilih Kelurahan --</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('kelurahan')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Kode Pos <code>*</code></label>
                                                            <select name="kode_pos" id="kode_pos"
                                                                class="form-control select2" required>
                                                                <option value="">-- Pilih Kode Pos --</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('kode_pos')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Moda Transportasi <code>*</code></label>
                                                            <input type="text" class="form-control"
                                                                name="moda_transportasi" placeholder="Moda Transportasi"
                                                                value="{{ old('moda_transportasi', $student->transportation) }}"
                                                                required>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('moda_transportasi')
                                                                <small>{{ $mesasge }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Anak keberapa <code>*</code></label>
                                                            <input required type="text"
                                                                class="number-only form-control" name="anak_keberapa"
                                                                placeholder="Anak Keberapa"
                                                                value="{{ old('anak_keberapa', $student->child_order) }}">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('anak_keberapa')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Apakah Punya KIP <code>*</code></label>
                                                            <select name="is_have_kip" class="form-control select select2"
                                                                required>
                                                                <option value="">-- Pilih Salah Satu --</option>
                                                                <option value="Ya"
                                                                    @if ($student->is_have_kip == 'Ya') selected @endif>Ya
                                                                </option>
                                                                <option value="Tidak"
                                                                    @if ($student->is_have_kip == 'Tidak') selected @endif>Tidak
                                                                </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('is_have_kip')
                                                                <small class="text-danger">Data wajib diisi</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="">Tetap Menerima KIP <code>*</code></label>
                                                            <select name="is_receive_kip"
                                                                class="form-control select select2" required>
                                                                <option value="">-- Pilih Salah Satu --</option>
                                                                <option value="Ya"
                                                                    @if ($student->is_receive_kip == 'Ya') selected @endif>Ya
                                                                </option>
                                                                <option value="Tidak"
                                                                    @if ($student->is_receive_kip == 'Tidak') selected @endif>
                                                                    Tidak
                                                                </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Alasan Menolak KIP</label>
                                                    <select name="reason_reject_kip" class="form-control select select2">
                                                        <option value="">-- Pilih Salah Satu --</option>
                                                        @foreach ($reject_kip as $item)
                                                            @if ($item['value'] == $student->reason_reject_kip)
                                                                <option value="{{ $item['value'] }}" selected>
                                                                    {{ $item['value'] }}</option>
                                                            @else
                                                                <option value="{{ $item['value'] }}">
                                                                    {{ $item['value'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <?php
                                                $session_menu = explode(',', Auth::user()->akses_submenu);
                                                ?>
                                                <div class="col-md-6"
                                                    {{ in_array('117', $session_menu) ? '' : 'hidden' }}>
                                                    <div class="mb-3">
                                                        <label for="">Barcode</label>
                                                        <input type="text" class="form-control" name="barcode"
                                                            placeholder="Barcode" value="{{ $student->barcode }}">
                                                        @error('barcode')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="old_village" value="{{ $student->village }}">
                                            <input type="hidden" id="old_district" value="{{ $student->district }}">
                                            <input type="hidden" id="old_postal_code"
                                                value="{{ $student->postal_code }}">
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('siswa.index') }}"
                                                        class="btn btn-secondary waves-effect">Kembali</a>
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
    <script>
        let url = '{{ route('kodepos.get_villages_by_district', ':district') }}'
        let urlPostalCode = '{{ route('kodepos.get_postal_code_by_village', ':oldVillage') }}'

        let old_district = $("#old_district").val()
        let oldVillage = ''
        let oldPostalCode = $("#old_postal_code").val()
        let old_village = document.getElementById("old_village").value;

        $(document).ready(function() {
            let district = $("#kecamatan :selected").val()
            url = url.replace(':district', district)
            if (district) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: response => {
                        $("#kelurahan option").remove()
                        $("#kelurahan").append(`<option value="">-- Pilih Kelurahan --</option>`)
                        $.each(response.data, function(index, item) {
                            if (item.kelurahan == old_village) {
                                oldVillage = item.kelurahan
                                urlPostalCode = urlPostalCode.replace(':oldVillage', oldVillage)
                                next()
                                $("#kelurahan").append(
                                    `<option value="${item.kelurahan}" selected>${item.kelurahan}</option>`
                                )
                            } else {
                                $("#kelurahan").append(
                                    `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                                )
                            }
                        })
                    },
                    error: err => console.log(err)
                })

                function next() {
                    $.ajax({
                        type: 'GET',
                        url: urlPostalCode,
                        success: response => {
                            $("#kode_pos option").remove()
                            $("#kode_pos").append(`<option value="">-- Pilih Kode Pos --</option>`)
                            $.each(response.data, function(index, item) {
                                if (item.kodepos == oldPostalCode) {
                                    $("#kode_pos").append(
                                        `<option value="${item.kodepos}" selected>${item.kodepos}</option>`
                                    )
                                } else {
                                    $("#kode_pos").append(
                                        `<option value="${item.kodepos}">${item.kodepos}</option>`
                                    )
                                }
                            })
                        },
                        error: err => console.log(err)
                    })
                }
            }

            let old_district = document.getElementById("old_district").value;
            $("#kecamatan").bind('change', function() {
                let district = $(this).val()
                let url = '{{ route('kodepos.get_villages_by_district', ':district') }}'
                url = url.replace(':district', district)
                $.ajax({
                    type: "GET",
                    url: url,
                    success: response => {
                        if (response.status == 200) {
                            $("#kelurahan option").remove()
                            $('#kelurahan').append(
                                `<option value="">-- Pilih Kelurahan --</option>`)
                            $.each(response.data, function(i, item) {
                                $('#kelurahan').append(
                                    `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                                )
                            })
                        } else {
                            Swal.fire(
                                'Gagal',
                                'Gagal mendapatkan data kelurahan',
                                'error'
                            )
                        }
                    },
                    error: err => Swal.fire('Error', 'Internal Server Error', 'error')
                })
            })

            $("#kelurahan").bind('change', function() {
                let village = $(this).val()
                let url = '{{ route('kodepos.get_postal_code_by_village', ':village') }}'
                url = url.replace(':village', village)
                $.ajax({
                    type: "GET",
                    url: url,
                    success: response => {
                        if (response.status == 200) {
                            $("#kode_pos option").remove()
                            $('#kode_pos').append(
                                `<option value="">-- Pilih Kode Pos --</option>`)
                            $.each(response.data, function(i, item) {
                                $('#kode_pos').append(
                                    `<option value="${item.kodepos}">${item.kodepos}</option>`
                                )
                            })
                        } else {
                            Swal.fire('Gagal', 'Gagal mendapatkan data kode pos', 'error')
                        }
                    },
                    error: (err) => Swal.fire('Error', 'Internal Server Error', 'error'),
                });
            });
        })
    </script>
@endsection
