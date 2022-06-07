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
                                <a class="nav-link @if ($submenu == 'siswa') active @endif">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Pribadi</p>
                                </a>
                                <a class="nav-link" href="{{ route('parents.create') }}">
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
                                                <div class="col-md-6 mb-3 form-group">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                    <label for="">Nama Lengkap<code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        placeholder="Nama Lengkap" required
                                                        value="{{ old('nama_lengkap') }}">
                                                    @error('nama_lengkap')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" name="email" required
                                                        placeholder="Email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Nomor Handphone</label>
                                                    <input type="text" class="form-control number-only" name="no_handphone"
                                                        required value="{{ old('no_handhpne') }}"
                                                        placeholder="Nomor Handphone">
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
                                                    @error('jenis_kelamin')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Golongan Darah</label>
                                                    <select name="golongan_darah" class="form-control" required>
                                                        <option value="">-- Pilih Golongan Darah --</option>
                                                        <option value="A" {{ old('A') == 'A' ? 'selected' : '' }}>
                                                            A</option>
                                                        <option value="B"
                                                            {{ old('jenis_kelamin') == 'B' ? 'selected' : '' }}>
                                                            B</option>
                                                        <option value="AB"
                                                            {{ old('jenis_kelamin') == 'AB' ? 'selected' : '' }}>
                                                            AB</option>
                                                        <option value="O"
                                                            {{ old('jenis_kelamin') == 'O' ? 'selected' : '' }}>
                                                            O</option>
                                                    </select>
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
                                                        <input type="text" class="form-control number-only" name="nik"
                                                            placeholder="NIK" value="{{ old('nik') }}" maxlength="20"
                                                            required>
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
                                                                value="{{ old('tanggal_lahir') }}"
                                                                data-date-format="yyyy-mm-dd"
                                                                data-date-container='#datepicker2' data-provide="datepicker"
                                                                required data-date-autoclose="true">
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
                                                            Akta Lahir</label>
                                                        <input type="text" class="number-only form-control"
                                                            name="akta_lahir" value="{{ old('akta_lahir') }}"
                                                            placeholder="Nomor Akta Lahir" required>
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
                                                        <select name="kewarganegaraan" class="form-control" required>
                                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                                            <option value="WNI"
                                                                {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>
                                                                Indonesia (WNI)</option>
                                                            <option value="WNA"
                                                                {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>
                                                                Asing (WNA)</option>
                                                        </select>
                                                        @error('kewarganegaraan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Nama Negara <code>*</code></label>
                                                    <input type="text" class="form-control" name="nama_negara" required
                                                        placeholder="Nama Negara" value="{{ old('nama_negara') }}">
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
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Alamat Jalan
                                                            <code>*</code></label>
                                                        <textarea name="alamat_jalan" class="form-control" cols="5" placeholder="Alamat Jalan"
                                                            required>{{ old('alamat_jalan') }}</textarea>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('alamat_jalan')
                                                            <small class="text-center">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="">Tempat Tinggal</label>
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
                                                    @error('tempat_tinggal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="validationCustom02" class="form-label">RT
                                                                <code>*</code></label>
                                                            <input type="text" min="0" class="number-only form-control"
                                                                name="rt" value="{{ old('rt') }}" required
                                                                placeholder="RT">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            @error('rt')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">RW <code>*</code></label>
                                                            <input type="text" class="number-only form-control" name="rw"
                                                                required placeholder="RW" value="{{ old('rw') }}">
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
                                                            <label for="">Kelurahan</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Kelurahan" name="kelurahan" required
                                                                value="{{ old('kelurahan') }}">
                                                            @error('kelurahan')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Kecamatan</label>
                                                            <input type="text" class="form-control" required
                                                                name="kecamatan" placeholder="kecamatan"
                                                                value="{{ old('kecamatan') }}">
                                                            @error('kecamatan')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Kode Pos</label>
                                                            <input type="text" class="form-control" required
                                                                name="kode_pos" placeholder="Kode Pos"
                                                                value="{{ old('kode_pos') }}">
                                                            @error('kode_pos')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Moda Transportasi</label>
                                                            <input type="text" class="form-control"
                                                                name="moda_transportasi" placeholder="Moda Transportaso"
                                                                value="{{ old('moda_transportasi') }}" required>
                                                            @error('moda_transportasi')
                                                                <small>{{ $mesasge }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Anak keberapa</label>
                                                            <input required type="text" class="form-control"
                                                                name="anak_keberapa" placeholder="Anak Keberapa"
                                                                value="{{ old('anak_keberapa') }}">
                                                            @error('anak_keberapa')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
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
