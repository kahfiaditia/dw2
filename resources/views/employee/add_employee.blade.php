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
                <form class="needs-validation" action="{{ route('employee.store') }}" enctype="multipart/form-data"
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
                                <a class="nav-link active">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Karyawan</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Ijazah</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">SK Pengangkatan</p>
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
                                            @if (Auth::user()->roles == 'Admin' or Auth::user()->roles == 'Administrator')
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Email.
                                                                <code>*</code></label>
                                                            <select class="form-control select select2 Email_admin"
                                                                name="user_id" required>
                                                                <option value="">--Pilih Email--</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('email', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Roles</label>
                                                            <input type="text" class="form-control Roles_admin"
                                                                value="" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Email</label>
                                                            <input type="hidden" class="form-control" name="user_id"
                                                                value="{{ Auth::user()->id }}" readonly>
                                                            <input type="text" class="form-control"
                                                                value="{{ Auth::user()->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Roles</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ Auth::user()->roles }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Nama Lengkap
                                                            <code>*</code></label>
                                                        <input type="text" class="form-control" id="nama_lengkap"
                                                            name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                                            autofocus placeholder="Nama Lengkap">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('nama_lengkap', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No Kontak dan
                                                            Whatsapp</label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                                            placeholder="No Kontak dan Whatsapp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Tempat Lahir
                                                            <code>*</code></label>
                                                        <input type="text" class="form-control" id="tempat_lahir"
                                                            name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                                            placeholder="Tempat Lahir">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('tempat_lahir', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4">
                                                        <label>Tanggal Lahir <code>*</code></label>
                                                        <div class="input-group" id="datepicker2">
                                                            <input type="text" class="form-control"
                                                                placeholder="yyyy-mm-dd" name="tgl_lahir"
                                                                value="{{ old('tgl_lahir') }}"
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
                                                        {!! $errors->first('tgl_lahir', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No KTP
                                                            <code>*</code></label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="nik" name="nik" value="{{ old('nik') }}"
                                                            required placeholder="No KTP">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('nik', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Doc KTP (Max 2 Mb)
                                                            <code>*</code></label>
                                                        <input class="form-control dok_nik" type="file" name="dok_nik"
                                                            id="dok_nik" required>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('dok_nik', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">KK
                                                            <code>*</code></label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="kk" name="kk" value="{{ old('kk') }}"
                                                            required placeholder="KK">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('kk', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Doc KK (Max 2 Mb)
                                                            <code>*</code></label>
                                                        <input class="form-control" type="file" name="dok_kk"
                                                            id="dok_kk" required>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('dok_kk', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">NPWP</label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="npwp" name="npwp" value="{{ old('npwp') }}"
                                                            placeholder="NPWP">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Doc NPWP (Max 2
                                                            Mb)</label>
                                                        <input class="form-control" type="file" name="dok_npwp"
                                                            id="dok_npwp">
                                                        {!! $errors->first('dok_npwp', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No BPJS
                                                            Kesehatan</label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="bpjs_kesehatan" name="bpjs_kesehatan"
                                                            value="{{ old('bpjs_kesehatan') }}"
                                                            placeholder="No BPJS Kesehatan">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No BPJS
                                                            Ketenagakerjaan</label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan"
                                                            value="{{ old('bpjs_ketenagakerjaan') }}"
                                                            placeholder="No BPJS Ketenagakerjaan">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Agama
                                                            <code>*</code></label>
                                                        <select class="form-control select select2 Agama" name="agama"
                                                            required>
                                                            <option value="">--Pilih Agama--</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('agama', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Golongan
                                                            Darah</label>
                                                        <select class="form-control select select2" name="golongan_darah">
                                                            <option value="">--Pilih Golongan Darah--</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="AB">AB</option>
                                                            <option value="O">O</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Nama
                                                            Pasangan</label>
                                                        <input type="text" class="form-control" id="nama_pasangan"
                                                            name="nama_pasangan" value="{{ old('nama_pasangan') }}"
                                                            placeholder="Nama Pasangan">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">No Kontak
                                                            Pasangan</label>
                                                        <input type="number" min="0" class="form-control"
                                                            id="no_pasangan" name="no_pasangan"
                                                            value="{{ old('no_pasangan') }}"
                                                            placeholder="No Kontak Pasangan">
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat KTP <code>*</code></label>
                                                        <div>
                                                            <textarea required class="form-control" name="alamat_asal" placeholder="Alamat KTP" rows="3">{{ old('alamat_asal') }}</textarea>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">RT
                                                                    <code>*</code></label>
                                                                <input type="number" class="form-control"
                                                                    id="validationCustom02" name="rt_asal"
                                                                    value="{{ old('rt_asal') }}" placeholder="RT"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">RW
                                                                    <code>*</code></label>
                                                                <input type="number" class="form-control"
                                                                    id="validationCustom02" name="rw_asal"
                                                                    value="{{ old('rw_asal') }}" placeholder="RW"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Dusun
                                                                    <code>*</code></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom02" name="dusun_asal"
                                                                    value="{{ old('dusun_asal') }}" placeholder="Dusun"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Provinsi <code>*</code></label>
                                                                <select class="form-control select select2 ProvinsiA"
                                                                    name="provinsi_asal" id="ProvinsiA" required>
                                                                    <option value="">--Pilih Kota--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Kota
                                                                    <code>*</code></label>
                                                                <select class="form-control select select2 KotaA"
                                                                    name="kota_asal" id="KotaA" required>
                                                                    <option value="">--Pilih Kota--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Kecamatan <code>*</code></label>
                                                                <select class="form-control select select2 KecamatanA"
                                                                    name="kecamatan_asal" id="KecamatanA" required>
                                                                    <option value="">--Pilih Kecamatan--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Kelurahan <code>*</code></label>
                                                                <select class="form-control select select2 KelurahanA"
                                                                    name="kelurahan_asal" id="KelurahanA" required>
                                                                    <option value="">--Pilih Kelurahan--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Kode
                                                                    Pos <code>*</code></label>
                                                                <select class="form-control select select2 KodeposA"
                                                                    name="kodepos_asal" required>
                                                                    <option value="">--Pilih Kode Pos--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                                {!! $errors->first('kodepos_asal', '<div class="invalid-validasi">:message</div>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat di Tangerang
                                                            <code>*</code></label>
                                                        <label class="form-check-label" style="float:right"
                                                            for="container">Alamat sama dengan KTP</label>
                                                        <label class="form-check-label" style="float:right"
                                                            for="container">&nbsp;</label>
                                                        <input class="form-check-input" style="float:right"
                                                            id="AlamatSama" type="checkbox" name="AlamatSama"
                                                            onclick="Myalamat()">
                                                        <div>
                                                            <textarea required class="form-control alamat-sama" name="alamat" placeholder="Alamat di Tangerang" rows="3">{{ old('alamat') }}</textarea>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">RT
                                                                    <code>*</code></label>
                                                                <input type="number" class="form-control alamat-sama"
                                                                    id="validationCustom02" name="rt"
                                                                    value="{{ old('rt') }}" placeholder="RT"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">RW
                                                                    <code>*</code></label>
                                                                <input type="number" class="form-control alamat-sama"
                                                                    id="validationCustom02" name="rw"
                                                                    value="{{ old('rw') }}" placeholder="RW"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Dusun
                                                                    <code>*</code></label>
                                                                <input type="text" class="form-control alamat-sama"
                                                                    id="validationCustom02" name="dusun"
                                                                    value="{{ old('dusun') }}" placeholder="Dusun"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Provinsi <code>*</code></label>
                                                                <select
                                                                    class="form-control select select2 alamat-sama ProvinsiT"
                                                                    name="provinsi" id="ProvinsiT" required>
                                                                    <option value="">--Pilih Kota--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Kota
                                                                    <code>*</code></label>
                                                                <select
                                                                    class="form-control select select2 alamat-sama KotaT"
                                                                    name="kota" id="KotaT" required>
                                                                    <option value="">--Pilih Kota--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Kecamatan <code>*</code></label>
                                                                <select
                                                                    class="form-control select select2 alamat-sama KecamatanT"
                                                                    name="kecamatan" id="KecamatanT" required>
                                                                    <option value="">--Pilih Kecamatan--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Kelurahan <code>*</code></label>
                                                                <select
                                                                    class="form-control select select2 alamat-sama KelurahanT"
                                                                    name="kelurahan" id="KelurahanT" required>
                                                                    <option value="">--Pilih Kelurahan--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02" class="form-label">Kode
                                                                    Pos <code>*</code></label>
                                                                <select
                                                                    class="form-control select select2 alamat-sama KodeposT"
                                                                    name="kodepos" id="KodeposT" required>
                                                                    <option value="">--Pilih Kode Pos--</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                                {!! $errors->first('kodepos', '<div class="invalid-validasi">:message</div>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Jabatan
                                                            <code>*</code></label>
                                                        <select class="form-control select select2" name="jabatan"
                                                            required>
                                                            <option value="">--Pilih Jabatan--</option>
                                                            <option value="Guru">Guru</option>
                                                            <option value="Karyawan">Karyawan</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4">
                                                        <label>Tanggal Masuk Kerja <code>*</code></label>
                                                        <div class="input-group" id="datepicker2">
                                                            <input type="text" class="form-control"
                                                                placeholder="yyyy-mm-dd" name="masuk_kerja"
                                                                value="{{ old('masuk_kerja') }}"
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
                                                        {!! $errors->first('masuk_kerja', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Foto Karyawan (Max 2
                                                            Mb)
                                                            <code>*</code></label>
                                                        <input class="form-control foto" type="file" name="foto"
                                                            id="foto" required>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('foto', '<div class="invalid-validasi">:message</div>') !!}
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
                if (user_id) {
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
                } else {
                    $(".Roles_admin").val('');
                }
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
