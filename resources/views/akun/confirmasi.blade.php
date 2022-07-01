@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route('akun.save_confirmasi', $akun->id) }}" method="POST"
                novalidate>
                @csrf
                @method('PATCH')
                <input type="hidden" class="Id" id="Id" name="id" value="{{ $akun->id }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Username
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $akun->name }}" disabled placeholder="Username" autofocus>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Roles <code>*</code></label>
                                            <select class="form-control select select2" name="roles" disabled>
                                                <option value="">--Pilih Roles--</option>
                                                <option value="Admin" {{ $akun->roles === 'Admin' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="Karyawan"
                                                    {{ $akun->roles === 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                                <option value="Siswa" {{ $akun->roles === 'Siswa' ? 'selected' : '' }}>
                                                    Siswa</option>
                                                <option value="Alumni" {{ $akun->roles === 'Alumni' ? 'selected' : '' }}>
                                                    Alumni</option>
                                                <option value="Ortu" {{ $akun->roles === 'Ortu' ? 'selected' : '' }}>
                                                    Orang Tua</option>
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
                                            <label for="validationCustom02" class="form-label">Email <code>*</code></label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $akun->email }}" disabled placeholder="Email">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Confirmasi Akun
                                                <code>*</code></label>
                                            <div>
                                                <input type="checkbox" id="switch1" switch="none" name="aktif"
                                                    {{ $akun->aktif === 1 ? 'checked' : '' }} />
                                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <a href="{{ route('akun.index') }}"
                                            class="btn btn-secondary waves-effect">Cancel</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-sm-end mt-2 mt-sm-0">
                                            <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> <!-- container-fluid -->
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection
