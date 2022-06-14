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
                <form class="needs-validation" action="{{ route('siswa.store_periodic_student') }}"
                    enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    <input type="hidden" class="form-control" name="student_id" value="{{ $student->id }}">
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
                                <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                    href="{{ route('parents.index') }}">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                    <p class="fw-bold mb-4">Orang Tua / Wali</p>
                                </a>
                                <a class="nav-link @if ($submenu == 'priodik') active @endif">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Priodik</p>
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
                                                    <h3>Data Priodik</h3>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Tinggi Badan<code>*</code></label>
                                                    <div class="row">
                                                        <div class="input-group">
                                                            <input type="text" class="number-only form-control"
                                                                placeholder="Tinggi Badan" name="tinggi_badan"
                                                                value="{{ old('tinggi_badan') }}" required>
                                                            <span class="input-group-text">Cm</span>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('tinggi_badan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Berat Badan <code>*</code></label>
                                                    <div class="row">
                                                        <div class="input-group">
                                                            <input type="text" class="number-only form-control"
                                                                placeholder="Berat Badan" name="berat_badan"
                                                                value="{{ old('berat_badan') }}" required>
                                                            <span class="input-group-text">Kg</span>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('berat_badan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Lingkar Kepala<code>*</code></label>
                                                    <div class="row">
                                                        <div class="input-group">
                                                            <input type="text" class="number-only form-control"
                                                                placeholder="Lingkar Kepala" name="lingkar_kepala"
                                                                value="{{ old('lingkar_kepala') }}" required>
                                                            <span class="input-group-text">Cm</span>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('lingkar_kepala')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Jarak tempat tinggal ke sekolah <code>*</code></label>
                                                    <select name="jarak_tempuh" class="form-control" required>
                                                        <option value="">-- Pilih Jarak Tempuh --</option>
                                                        <option value="Kurang dari 1 Km">Kurang dari 1 Km</option>
                                                        <option value="Lebih dari 1 Km">Lebih dari 1 Km</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('jarak_tempat_tinggal_ke_sekolah')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Sebutkan dalam Kilometer (KM)<code>*</code></label>
                                                    <div class="row">
                                                        <div class="input-group">
                                                            <input type="text" class="number-only form-control"
                                                                placeholder="In Km" name="in_km"
                                                                value="{{ old('in_km') }}" required>
                                                            <span class="input-group-text">Km</span>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('in_km')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="">Waktu Tempuh <code>*</code></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="number-only form-control"
                                                                    placeholder="Jam" name="jam"
                                                                    value="{{ old('jam') }}" required>
                                                                <span class="input-group-text">Jam</span>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('in_hour')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="number-only form-control"
                                                                    placeholder="Menit" name="menit"
                                                                    value="{{ old('menit') }}" required>
                                                                <span class="input-group-text">Menit</span>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        @error('in_minute')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Jumkah saudara kandung <code>*</code></label>
                                                    <input type="text" class="number-only form-control"
                                                        name="saudara_kandung" placeholder="Jumlah saudara kandung">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    @error('saudara_kandung')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
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
