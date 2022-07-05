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
                        @if ($student == null)
                            <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link @if ($submenu == 'siswa') active @endif">
                                        <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Data Pribadi</p>
                                    </a>
                                    <a class="nav-link">
                                        <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Orang Tua / Wali</p>
                                    </a>
                                    <a class="nav-link @if ($submenu == 'priodik') active @endif">
                                        <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Data Priodik</p>
                                    </a>
                                    <a
                                        class="
                                    nav-link @if ($submenu == 'prestasi') active @endif">
                                        <i class="bx bx-chart d-block check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Prestasi</p>
                                    </a>
                                    <a class="nav-link @if ($submenu == 'beasiswa') active @endif">
                                        <i class="bx bx-star check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Beasiswa</p>
                                    </a>
                                    <a class="nav-link @if ($submenu == 'kesejahteraan') active @endif">
                                        <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Kesejahteraan Siswa</p>
                                    </a>
                                </div>
                            </div>
                        @else
                            @include('siswa.student_menu')
                        @endif
                        <div class="col-xl-<?php echo $column; ?> col-sm-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                    aria-labelledby="v-pills-shipping-tab">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            @if (Auth::user()->roles == 'Admin')
                                                <label for="">Pilih User Siswa</label>
                                                <select name="user_id" id="" style="margin-bottom: 20px;"
                                                    class="select2 form-control mb-3" required>
                                                    <option value="">-- Pilih User Siswa --</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name . ' - ' . $user->email }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            @endif
                                            <div class="row">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nama Lengkap<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_lengkap') }}">
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
                                                        placeholder="Email"
                                                        value="{{ old('email', Auth::user()->email) }}" readonly>
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
                                                        name="no_handphone" required value="{{ old('no_handphone') }}"
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
                                                    <select name="jenis_kelamin" class="form-control" required>
                                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                                        <option value="Laki - Laki"
                                                            {{ old('jenis_kelamin') == 'Laki - Laki' ? 'selected' : '' }}>
                                                            Laki - Laki</option>
                                                        <option value="Perempuan"
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
                                                    <select name="golongan_darah" class="form-control" required>
                                                        <option value="">-- Pilih Golongan Darah --</option>
                                                        <option value="A" {{ old('A') == 'A' ? 'selected' : '' }}>
                                                            A</option>
                                                        <option value="B"
                                                            {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>
                                                            B</option>
                                                        <option value="AB"
                                                            {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>
                                                            AB</option>
                                                        <option value="O"
                                                            {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>
                                                            O</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('golongan_darah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="validationCustom02" class="form-label">NISN
                                                        <code>*</code></label>
                                                    <input type="text" class="form-control number-only" name="nisn"
                                                        placeholder="NISN" value="{{ old('nisn') }}" maxlength="20"
                                                        required>
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
                                                            name="nik" placeholder="NIK" value="{{ old('nik') }}"
                                                            maxlength="20" required>
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
                                                            value="{{ old('no_kk') }}" maxlength="20">
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
                                                            value="{{ old('tempat_lahir') }}">
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
                                                        <label for="validationCustom02" class="form-label">Tanggal
                                                            Lahir
                                                            <code>*</code></label>
                                                        <div class="input-group" id="datepicker2">
                                                            <input type="text" class="form-control"
                                                                placeholder="yyyy-mm-dd" name="tanggal_lahir"
                                                                value="{{ old('tanggal_lahir') }}"
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
                                                        <label for="validationCustom02" class="form-label">No
                                                            Registrasi
                                                            Akta Lahir <code>*</code></label>
                                                        <input type="text" class="form-control" name="akta_lahir"
                                                            value="{{ old('akta_lahir') }}"
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
                                                        <select name="agama" class="form-control" required>
                                                            <option value="">-- Pilih Agama --</option>
                                                            @foreach ($religions as $religion)
                                                                <option value="{{ $religion->id }}"
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
                                                        <select id="nationality" name="kewarganegaraan"
                                                            class="form-control" required>
                                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                                            <option value="WNI"
                                                                {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>
                                                                Indonesia (WNI)</option>
                                                            <option value="WNA"
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
                                                <div class="col-md-6">
                                                    <label for="">Nama Negara <code>*</code></label>
                                                    <input type="text" class="form-control" id="national_name" name="nama_negara"
                                                        required placeholder="Nama Negara"
                                                        value="{{ old('nama_negara') }}">
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
                                                        <select name="kebutuhan_khusus" class="form-control" required>
                                                            <option value="">-- Pilih Kebutuhan Khusus --
                                                            </option>
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
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Alamat Jalan
                                                            <code>*</code></label>
                                                        <textarea name="alamat_jalan" class="form-control" cols="5" placeholder="Alamat Jalan" required>{{ old('alamat_jalan') }}</textarea>
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
                                                    <select name="tempat_tinggal" required class="form-control">
                                                        <option value="">-- Pilih Tempat Tinggal --</option>
                                                        <option value="Bersama Orang Tua"
                                                            {{ old('tempat_tinggal') == 'Bersama Orang Tua' ? 'selected' : '' }}>
                                                            Bersama Orang Tua</option>
                                                        <option value="Wali"
                                                            {{ old('tempat_tinggal') == 'Wali' ? 'selected' : '' }}>
                                                            Wali
                                                        </option>
                                                        <option value="Kos"
                                                            {{ old('tempat_tinggal') == 'Kos' ? 'selected' : '' }}>
                                                            Kos
                                                        </option>
                                                        <option value="Asrama"
                                                            {{ old('tempat_tinggal') == 'Asrama' ? 'selected' : '' }}>
                                                            Asrama</option>
                                                        <option value="Panti Asuhan"
                                                            {{ old('tempat_tinggal') == 'Panti Asuhan' ? 'selected' : '' }}>
                                                            Panti Asuhan</option>
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
                                                        <div class="col-md-6">
                                                            <label for="validationCustom02" class="form-label">RT
                                                                <code>*</code></label>
                                                            <input type="text" min="0"
                                                                class="number-only form-control" name="rt"
                                                                value="{{ old('rt') }}" required placeholder="RT">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('rt')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">RW <code>*</code></label>
                                                            <input type="text" class="number-only form-control"
                                                                name="rw" required placeholder="RW"
                                                                value="{{ old('rw') }}">
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('rw')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="formFile" class="form-label">Dusun
                                                                <code>*</code></label>
                                                            <input class="form-control" type="text" name="nama_dusun"
                                                                required placeholder="Nama Dusun"
                                                                value="{{ old('nama_dusun') }}">
                                                            @error('nama_dusun')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Kecamatan <code>*</code></label>
                                                            <select name="kecamatan" id="kecamatan"
                                                                class="form-control select2" required>
                                                                <option value="">-- Pilih Kecamatan --</option>
                                                                @foreach ($districts as $district)
                                                                    <option value="{{ $district->kecamatan }}">
                                                                        {{ $district->kecamatan }}</option>
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
                                                <div class="col-md-6 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
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
                                                        <div class="col-md-6">
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
                                                        <div class="col-md-6">
                                                            <label for="">Moda Transportasi
                                                                <code>*</code></label>
                                                            <input type="text" class="form-control"
                                                                name="moda_transportasi" placeholder="Moda Transportaso"
                                                                value="{{ old('moda_transportasi') }}" required>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('moda_transportasi')
                                                                <small>{{ $mesasge }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Anak keberapa <code>*</code></label>
                                                            <input required type="text"
                                                                class="number-only form-control" name="anak_keberapa"
                                                                placeholder="Anak Keberapa"
                                                                value="{{ old('anak_keberapa') }}">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('anak_keberapa')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Apakah Punya KIP
                                                                <code>*</code></label>
                                                            <select name="is_have_kip" class="form-control" required>
                                                                <option value="">-- Pilih Salah Satu --</option>
                                                                <option value="Ya">Ya</option>
                                                                <option value="Tidak">Tidak</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('is_have_kip')
                                                            <small class="text-danger">Data wajib diisi</small>
                                                        @enderror
                                                        <div class="col-md-6">
                                                            <label for="">Tetap Menerima KIP
                                                                <code>*</code></label>
                                                            <select name="is_receive_kip" id="is_receive_kip"
                                                                class="form-control" required>
                                                                <option value="">-- Pilih Salah Satu --</option>
                                                                <option value="Ya">Ya</option>
                                                                <option value="Tidak">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="reason_reject_kip" style="display: none;" class="col-md-6 mt-3">
                                                    <label for="">Alasan Menolak KIP</label>
                                                    <select id="select_reason" name="reason_reject_kip"
                                                        class="form-control">
                                                        <option value="">-- Pilih Salah Satu --</option>
                                                        <option value="Dilarang Pemda Karena Menerima Bantuan Serupa">
                                                            Dilarang
                                                            Pemda Karena Menerima Bantuan Serupa</option>
                                                        <option value="Menolak">Menolak</option>
                                                        <option value="Sudah Mampu">Sudah Mampu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('siswa.index') }}"
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
    <script>
        $(document).ready(function() {
            $("#nationality").bind('change', function(){
                if($(this).val() == 'WNI') {
                    $("#national_name").val('Indonesia')
                } else {
                    $("#national_name").val('')
                }
            })
            $("#is_receive_kip").bind('change', function() {
                let result = $(this).val()

                if (result == 'Ya') {
                    $("#reason_reject_kip").show()
                } else {
                    $("#select_reason").val("");
                    $("#reason_reject_kip").hide()
                }
            })

            $("#kecamatan").bind('change', function() {
                let district = $(this).val()
                let url = '{{ route('kodepos.get_villages_by_district', ':district') }}'
                url = url.replace(':district', district)

                $.ajax({
                    type: "GET",
                    url: url,
                    success: response => {
                        $("#kelurahan option").remove()
                        $('#kelurahan').append(
                            `<option value="">-- Pilih Kelurahan --</option>`)
                        $.each(response.data, function(i, item) {
                            $('#kelurahan').append(
                                `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                            )
                        })
                    },
                    error: err => Swal.fire('Error', 'Gagal mendapatkan data kelurahan', 'error')
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
                        $("#kode_pos option").remove()
                        $('#kode_pos').append(
                            `<option value="">-- Pilih Kode Pos --</option>`)
                        $.each(response.data, function(i, item) {
                            $('#kode_pos').append(
                                `<option value="${item.kodepos}">${item.kodepos}</option>`
                            )
                        })
                    },
                    error: (err) => Swal.fire('Error', 'Gagal mendapatkan data kode pos', 'error')
                });
            });
        })
    </script>
@endsection
