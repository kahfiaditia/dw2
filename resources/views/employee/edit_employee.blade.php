@extends('layouts.main')
@section('container')

    <body onload="myLoad()">
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
                    <form class="needs-validation" action="{{ route('employee.update') }}" enctype="multipart/form-data"
                        method="POST" novalidate>
                        @csrf
                        <?php $id = Crypt::encryptString($item->id); ?>
                        <input type="hidden" name="id" value="{{ $id }}">
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
                                        <p class="fw-bold mb-4">Ijazah + Sertifikat</p>
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
                                        <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                        <i class="bx bx-phone check-nav-icon mt-2"></i>
                                        <p class="fw-bold mb-4">Riwayat Penyakit & Kontak</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-<?php echo $column; ?> col-sm-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                        aria-labelledby="v-pills-shipping-tab">
                                        <div class="card shadow-none border mb-0">
                                            <div class="card-body">
                                                @if (Auth::user()->roles === 'Admin')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <input type="hidden" id="user_id_old"
                                                                    value="{{ $item->user ? $item->user->id : '' }}">
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
                                                                <label for="validationCustom02"
                                                                    class="form-label">Roles</label>
                                                                <input type="text" class="form-control Roles_admin"
                                                                    value="{{ $item->user ? $item->user->roles : '' }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <input type="hidden" id="user_id_old" name="user_id"
                                                                    value="{{ $item->user ? $item->user->id : '' }}">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Email</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $item->user->email }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="validationCustom02"
                                                                    class="form-label">Roles</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $item->user->roles }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Nama Lengkap
                                                                <code>*</code></label>
                                                            <input type="hidden" name="nama_lengkap_old"
                                                                value="{{ $item->nama_lengkap }}">
                                                            <input type="text" class="form-control" id="nama_lengkap"
                                                                name="nama_lengkap" value="{{ $item->nama_lengkap }}"
                                                                required autofocus placeholder="Nama Lengkap">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('nama_lengkap', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">No Kontak
                                                                dan
                                                                Whatsapp</label>
                                                            <input type="number" min="0" class="form-control"
                                                                id="no_hp" name="no_hp"
                                                                value="{{ $item->no_hp }}"
                                                                placeholder="No Kontak dan Whatsapp">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('no_hp', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Tempat
                                                                Lahir
                                                                <code>*</code></label>
                                                            <input type="text" class="form-control" id="tempat_lahir"
                                                                name="tempat_lahir" value="{{ $item->tempat_lahir }}"
                                                                required placeholder="Tempat Lahir">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('tempat_lahir', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-4">
                                                            <label>Tanggal Lahir <code>*</code></label>
                                                            <div class="input-group" id="datepicker2">
                                                                <input type="text" class="form-control"
                                                                    placeholder="yyyy-mm-dd" name="tgl_lahir"
                                                                    value="{{ $item->tgl_lahir }}"
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
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">NIKS (No
                                                                Induk Karyawan Sekolah)
                                                                <code>*</code></label>
                                                            <input type="number" min="0" class="form-control"
                                                                id="niks" name="niks"
                                                                value="{{ $item->niks }}" required
                                                                placeholder="No NIKS">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('niks', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">No KTP
                                                                <code>*</code></label>
                                                            <input type="number" min="0" class="form-control"
                                                                id="nik" name="nik"
                                                                value="{{ $item->nik }}" required
                                                                placeholder="No KTP">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('nik', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="dok_nik_old"
                                                                value="{{ $item->dok_nik }}">
                                                            <label for="formFile" class="form-label">Doc KTP (Max 2 Mb)
                                                                <code>*</code></label>
                                                            <input class="form-control dok_nik" type="file"
                                                                name="dok_nik" id="dok_nik">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('dok_nik', '<div class="invalid-validasi">:message</div>') !!}
                                                            @if ($item->dok_nik)
                                                                <a href="javascript:void(0)"
                                                                    data-id="{{ $item->dok_nik . '|nik|karyawan' }}"
                                                                    id="get_data" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-lg">
                                                                    <i
                                                                        class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                    Dokumen
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">KK
                                                                <code>*</code></label>
                                                            <input type="number" min="0" class="form-control"
                                                                id="kk" name="kk"
                                                                value="{{ $item->kk }}" required placeholder="KK">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('kk', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="dok_kk_old"
                                                                value="{{ $item->dok_kk }}">
                                                            <label for="formFile" class="form-label">Doc KK (Max 2 Mb)
                                                                <code>*</code></label>
                                                            <input class="form-control" type="file" name="dok_kk"
                                                                id="dok_kk">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('dok_kk', '<div class="invalid-validasi">:message</div>') !!}
                                                            @if ($item->dok_kk)
                                                                <a href="javascript:void(0)"
                                                                    data-id="{{ $item->dok_kk . '|kk|karyawan' }}"
                                                                    id="get_data" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-lg">
                                                                    <i
                                                                        class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                    Dokumen
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02"
                                                                class="form-label">NPWP</label>
                                                            <input type="number" min="0" class="form-control"
                                                                id="npwp" name="npwp"
                                                                value="{{ $item->npwp }}" placeholder="NPWP">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="dok_npwp_old"
                                                                value="{{ $item->dok_npwp }}">
                                                            <label for="formFile" class="form-label">Doc NPWP (Max 2
                                                                Mb)</label>
                                                            <input class="form-control" type="file" name="dok_npwp"
                                                                id="dok_npwp">
                                                            {!! $errors->first('dok_npwp', '<div class="invalid-validasi">:message</div>') !!}
                                                            @if ($item->dok_npwp)
                                                                <a href="javascript:void(0)"
                                                                    data-id="{{ $item->dok_npwp . '|npwp|karyawan' }}"
                                                                    id="get_data" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-lg">
                                                                    <i
                                                                        class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                    Dokumen
                                                                </a>
                                                            @endif
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
                                                                value="{{ $item->bpjs_kesehatan }}"
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
                                                                value="{{ $item->bpjs_ketenagakerjaan }}"
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
                                                            <input type="hidden" id="agama_old"
                                                                value="{{ $item->agama_id }}">
                                                            <label for="validationCustom02" class="form-label">Agama
                                                                <code>*</code></label>
                                                            <select class="form-control select select2 Agama"
                                                                name="agama" required>
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
                                                            <select class="form-control select select2"
                                                                name="golongan_darah">
                                                                <option value="">--Pilih Golongan Darah--</option>
                                                                <option value="A"
                                                                    {{ $item->golongan_darah === 'A' ? 'selected' : '' }}>A
                                                                </option>
                                                                <option value="B"
                                                                    {{ $item->golongan_darah === 'B' ? 'selected' : '' }}>B
                                                                </option>
                                                                <option value="AB"
                                                                    {{ $item->golongan_darah === 'AB' ? 'selected' : '' }}>
                                                                    AB
                                                                </option>
                                                                <option value="O"
                                                                    {{ $item->golongan_darah === 'O' ? 'selected' : '' }}>O
                                                                </option>
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
                                                                name="nama_pasangan" value="{{ $item->nama_pasangan }}"
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
                                                                value="{{ $item->no_pasangan }}"
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
                                                                <textarea required class="form-control" name="alamat_asal" placeholder="Alamat KTP" rows="3">{{ $item->alamat_asal }}</textarea>
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
                                                                        min="1" value="{{ $item->rt_asal }}"
                                                                        placeholder="RT" required>
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
                                                                        min="1" value="{{ $item->rw_asal }}"
                                                                        placeholder="RW" required>
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
                                                                        class="form-label">Dusun
                                                                        <code>*</code></label>
                                                                    <input type="text" class="form-control"
                                                                        id="validationCustom02" name="dusun_asal"
                                                                        value="{{ $item->dusun_asal }}"
                                                                        placeholder="Dusun" required>
                                                                    <div class="invalid-feedback">
                                                                        Data wajib diisi.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <input type="hidden" id="provinsi_asal_old"
                                                                        value="{{ $item->provinsi_asal }}">
                                                                    <label for="validationCustom02"
                                                                        class="form-label">Provinsi <code>*</code></label>
                                                                    <select class="form-control select select2 ProvinsiA"
                                                                        name="provinsi_asal" id="ProvinsiA" required>
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
                                                                        class="form-label">Kota
                                                                        <code>*</code></label>
                                                                    <select class="form-control select select2 KotaA"
                                                                        name="kota_asal" id="KotaA" required>
                                                                        <option value="{{ $item->kota_asal }}">
                                                                            {{ $item->kota_asal }}</option>
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
                                                                        <option value="{{ $item->kecamatan_asal }}">
                                                                            {{ $item->kecamatan_asal }}</option>
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
                                                                        <option value="{{ $item->kelurahan_asal }}">
                                                                            {{ $item->kelurahan_asal }}</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Data wajib diisi.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="validationCustom02"
                                                                        class="form-label">Kode
                                                                        Pos <code>*</code></label>
                                                                    <select class="form-control select select2 KodeposA"
                                                                        name="kodepos_asal" required>
                                                                        <option value="{{ $item->kodepos_asal }}">
                                                                            {{ $item->kodepos_asal }}</option>
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
                                                                <textarea required class="form-control alamat-sama" name="alamat" placeholder="Alamat di Tangerang" rows="3">{{ $item->alamat }}</textarea>
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
                                                                        min="1" value="{{ $item->rt }}"
                                                                        placeholder="RT" required>
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
                                                                        min="1" value="{{ $item->rw }}"
                                                                        placeholder="RW" required>
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
                                                                        class="form-label">Dusun
                                                                        <code>*</code></label>
                                                                    <input type="text" class="form-control alamat-sama"
                                                                        id="validationCustom02" name="dusun"
                                                                        value="{{ $item->dusun }}" placeholder="Dusun"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        Data wajib diisi.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <input type="hidden" id="provinsi_old"
                                                                        value="{{ $item->provinsi }}">
                                                                    <label for="validationCustom02"
                                                                        class="form-label">Provinsi <code>*</code></label>
                                                                    <select
                                                                        class="form-control select select2 alamat-sama ProvinsiT"
                                                                        name="provinsi" id="ProvinsiT" required>
                                                                        <option value="{{ $item->provinsi }}">
                                                                            {{ $item->provinsi }}</option>
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
                                                                        class="form-label">Kota
                                                                        <code>*</code></label>
                                                                    <select
                                                                        class="form-control select select2 alamat-sama KotaT"
                                                                        name="kota" id="KotaT" required>
                                                                        <option value="{{ $item->kota }}">
                                                                            {{ $item->kota }}</option>
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
                                                                        <option value="{{ $item->kecamatan }}">
                                                                            {{ $item->kecamatan }}</option>
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
                                                                        <option value="{{ $item->kelurahan }}">
                                                                            {{ $item->kelurahan }}</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Data wajib diisi.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="validationCustom02"
                                                                        class="form-label">Kode
                                                                        Pos <code>*</code></label>
                                                                    <select
                                                                        class="form-control select select2 alamat-sama KodeposT"
                                                                        name="kodepos" id="KodeposT" required>
                                                                        <option value="{{ $item->kodepos }}">
                                                                            {{ $item->kodepos }}</option>
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
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Jabatan
                                                                <code>*</code></label>
                                                            <select class="form-control select select2" name="jabatan"
                                                                required>
                                                                <option value="">--Pilih Jabatan--</option>
                                                                <option value="Guru"
                                                                    {{ $item->jabatan === 'Guru' ? 'selected' : '' }}>Guru
                                                                </option>
                                                                <option value="Karyawan"
                                                                    {{ $item->jabatan === 'Karyawan' ? 'selected' : '' }}>
                                                                    Karyawan</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Divisi
                                                                <code>*</code></label>
                                                            <select class="form-control select select2" name="divisi"
                                                                required>
                                                                <option value="">--Pilih Divisi--</option>
                                                                <option value="IT"
                                                                    {{ $item->divisi == 'IT' ? 'selected' : '' }}>IT
                                                                </option>
                                                                <option value="LM"
                                                                    {{ $item->divisi == 'LM' ? 'selected' : '' }}>LM
                                                                </option>
                                                                <option value="TU"
                                                                    {{ $item->divisi == 'TU' ? 'selected' : '' }}>TU
                                                                </option>
                                                                <option value="PERPUS"
                                                                    {{ $item->divisi == 'PERPUS' ? 'selected' : '' }}>
                                                                    PERPUS
                                                                </option>
                                                                <option value="Petugas Kebersihan dan Keamanan"
                                                                    {{ $item->divisi == 'Petugas Kebersihan dan Keamanan' ? 'selected' : '' }}>
                                                                    Petugas
                                                                    Kebersihan dan Keamanan</option>
                                                                <option value="TK"
                                                                    {{ $item->divisi == 'TK' ? 'selected' : '' }}>TK
                                                                </option>
                                                                <option value="SD"
                                                                    {{ $item->divisi == 'SD' ? 'selected' : '' }}>SD
                                                                </option>
                                                                <option value="SMP"
                                                                    {{ $item->divisi == 'SMP' ? 'selected' : '' }}>SMP
                                                                </option>
                                                                <option value="SMK"
                                                                    {{ $item->divisi == 'SMK' ? 'selected' : '' }}>SMK
                                                                </option>
                                                                <option value="DIREKTUR"
                                                                    {{ $item->divisi == 'DIREKTUR' ? 'selected' : '' }}>
                                                                    DIREKTUR</option>
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
                                                                    value="{{ $item->masuk_kerja }}"
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
                                                            <input type="hidden" name="foto_old"
                                                                value="{{ $item->foto }}">
                                                            <label for="formFile" class="form-label">Foto Karyawan (Max 2
                                                                Mb)
                                                                <code>*</code></label>
                                                            <input class="form-control foto" type="file"
                                                                name="foto" id="foto"
                                                                {{ $item->foto === null ? 'required' : '' }}>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('foto', '<div class="invalid-validasi">:message</div>') !!}
                                                            @if ($item->foto)
                                                                <a href="javascript:void(0)"
                                                                    data-id="{{ $item->foto . '|foto|karyawan' }}"
                                                                    id="get_data" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-lg">
                                                                    <i
                                                                        class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                    Dokumen
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" <?php if (Auth::user()->roles != 'Admin' and Auth::user()->roles != 'Administrator') {
                                                        echo 'hidden';
                                                    } ?>>
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">ID
                                                                Fingerprint <code>*</code></label>
                                                            <input type="number" class="form-control"
                                                                id="id_fingerprint" name="id_fingerprint"
                                                                value="{{ $item->id_fingerprint }}" required
                                                                placeholder="ID Fingerprint">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('id_fingerprint', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="div_tgl_resign">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label>Tanggal Resign <code>*</code></label>
                                                            <div class="input-group" id="datepicker2">
                                                                <input type="text" class="form-control"
                                                                    placeholder="yyyy-mm-dd" name="tgl_resign"
                                                                    id="tgl_resign" value="{{ $item->tgl_resign }}"
                                                                    data-date-end-date="{{ date('Y-m-d') }}"
                                                                    data-date-format="yyyy-mm-dd"
                                                                    data-date-container='#datepicker2'
                                                                    data-provide="datepicker" data-date-autoclose="true">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                            {!! $errors->first('tgl_resign', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label class="form-label">Alasan Resign <code>*</code></label>
                                                            <div>
                                                                <textarea class="form-control" name="alasan_resign" id="alasan_resign" placeholder="Alasan Resign" rows="3">{{ $item->alasan_resign }}</textarea>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2" <?php if (Auth::user()->roles != 'Admin' and Auth::user()->roles != 'Administrator') {
                                                        echo 'hidden';
                                                    } ?>>
                                                        <input type="hidden" id="roles"
                                                            value="{{ Auth::user()->roles }}">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Status
                                                                Aktif</label>
                                                            <div>
                                                                <input type="hidden" name="aktif_old"
                                                                    value="{{ $item->aktif }}">
                                                                <input type="checkbox" id="switch1" switch="none"
                                                                    name="aktif" id="switch1"
                                                                    {{ $item->aktif === '1' ? 'checked' : '' }} />
                                                                <label for="switch1" data-on-label="On"
                                                                    data-off-label="Off"></label>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" id="div_resign">
                                                        <div class="mb-3">
                                                            <label class="form-check-label" for="resign">
                                                                Resign
                                                            </label>
                                                            <div>
                                                                <input class="form-check-input" name="resign"
                                                                    type="checkbox" id="resign" required
                                                                    {{ $item->tgl_resign ? 'checked' : '' }}
                                                                    onclick="toggleCheckbox()">
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <a href="{{ route('employee') }}"
                                                            class="btn btn-secondary waves-effect">Batal</a>
                                                        <button class="btn btn-primary" type="submit"
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
        <!-- modal -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="dynamic-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        function myLoad() {
            switchButton = document.getElementById('switch1');
            roles = document.getElementById('roles').value;
            if (roles == 'Admin' || roles == 'Administrator') {
                document.getElementById("id_fingerprint").required = true;
                document.getElementById("resign").required = true;
                if (switchButton.checked == true) {
                    $('#div_resign').hide();
                    $('#div_tgl_resign').hide();
                    document.getElementById("resign").required = false;
                } else {
                    $('#div_resign').show();
                    resign = document.getElementById("resign").checked;
                    if (resign == true) {
                        $('#div_tgl_resign').show();
                        document.getElementById("tgl_resign").required = true;
                        document.getElementById("alasan_resign").required = true;
                        document.getElementById("resign").required = false;
                    } else {
                        $('#div_tgl_resign').hide();
                        document.getElementById("tgl_resign").required = false;
                        document.getElementById("alasan_resign").required = false;
                    }
                }
            } else {
                $('#div_resign').hide();
                $('#div_tgl_resign').hide();
                document.getElementById("id_fingerprint").required = false;
                document.getElementById("resign").required = false;
            }
        }

        function toggleCheckbox() {
            resign = document.getElementById("resign").checked;
            if (resign == true) {
                $('#div_tgl_resign').show();
                document.getElementById("tgl_resign").required = true;
                document.getElementById("alasan_resign").required = true;
            } else {
                $('#div_tgl_resign').hide();
                document.getElementById("tgl_resign").required = false;
                document.getElementById("alasan_resign").required = false;
                document.getElementById("resign").required = true;
            }
        }

        $(document).ready(function() {
            document.getElementById('switch1').addEventListener('click', function() {
                switchButton = document.getElementById('switch1');
                if (switchButton.checked == true) {
                    $('#div_resign').hide();
                    $('#div_tgl_resign').hide();
                    document.getElementById("resign").required = false;
                    document.getElementById("tgl_resign").required = false;
                    document.getElementById("alasan_resign").required = false;
                    document.getElementById("resign").checked = false;
                } else {
                    $('#div_resign').show();
                    $('#div_tgl_resign').hide();
                    document.getElementById("resign").checked = false;
                }
            });

            $(document).on('click', '#get_data', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.dokumen') }}"
                $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        }
                    })
                    .done(function(url) {
                        $('#dynamic-content').html(url); // load response
                        $('#modal-loader').hide(); // hide ajax loader
                    })
                    .fail(function(err) {
                        $('#dynamic-content').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });
            });

            // user data - admin
            let user_id_old = document.getElementById("user_id_old").value;
            $.ajax({
                type: "POST",
                url: '{{ route('employee.dropdown_email') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        if (user_id_old == item.id) {
                            $('.Email_admin').append(
                                `<option value="${item.id}" selected>${item.email}</option>`
                            )
                        } else {
                            $('.Email_admin').append(
                                `<option value="${item.id}">${item.email}</option>`
                            )
                        }
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
                        user_id,
                        user_id_old
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

            // agama
            let agama_old = document.getElementById("agama_old").value;
            $.ajax({
                type: "POST",
                url: '{{ route('agama.dropdown') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        if (agama_old == item.id) {
                            $('.Agama').append(
                                `<option value="${item.id}" selected>${item.agama}</option>`
                            )
                        } else {
                            $('.Agama').append(
                                `<option value="${item.id}">${item.agama}</option>`
                            )
                        }
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            // provinsi
            let provinsi_asal_old = document.getElementById("provinsi_asal_old").value;
            let provinsi_old = document.getElementById("provinsi_old").value;
            $.ajax({
                type: "POST",
                url: '{{ route('kodepos.dropdown') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        if (provinsi_asal_old === item.provinsi) {
                            $('.ProvinsiA').append(
                                `<option value="${item.provinsi}" selected>${item.provinsi}</option>`
                            )
                        } else {
                            $('.ProvinsiA').append(
                                `<option value="${item.provinsi}">${item.provinsi}</option>`
                            )
                        }
                    })
                    $.each(response, function(i, item) {
                        if (provinsi_old === item.provinsi) {
                            $('.ProvinsiT').append(
                                `<option value="${item.provinsi}" selected>${item.provinsi}</option>`
                            )
                        } else {
                            $('.ProvinsiT').append(
                                `<option value="${item.provinsi}">${item.provinsi}</option>`
                            )
                        }
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
    </script>
@endsection
