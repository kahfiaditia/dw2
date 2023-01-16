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
            <form class="needs-validation" action="{{ route('akun.update', $akun->id) }}" method="POST" novalidate>
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
                                                value="{{ $akun->name }}" required placeholder="Username" autofocus>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('username', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Roles <code>*</code></label>
                                            <select class="form-control select select2" name="roles" id="roles"
                                                required>
                                                @if (Auth::user()->roles == 'Administrator')
                                                    <option value="">--Pilih Roles--</option>
                                                    <option value="Administrator"
                                                        {{ $akun->roles === 'Administrator' ? 'selected' : '' }}>
                                                        Administrator</option>
                                                    <option value="Admin" {{ $akun->roles === 'Admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="Karyawan"
                                                        {{ $akun->roles === 'Karyawan' ? 'selected' : '' }}>Karyawan
                                                    </option>
                                                    <option value="Tu" {{ $akun->roles === 'Tu' ? 'selected' : '' }}>
                                                        Tata Usaha
                                                    </option>
                                                    <option value="Siswa"
                                                        {{ $akun->roles === 'Siswa' ? 'selected' : '' }}>
                                                        Siswa</option>
                                                    <option value="Alumni"
                                                        {{ $akun->roles === 'Alumni' ? 'selected' : '' }}>Alumni
                                                    </option>
                                                    <option value="Ortu" {{ $akun->roles === 'Ortu' ? 'selected' : '' }}>
                                                        Orang Tua
                                                    </option>
                                                @else
                                                    <option value="{{ $akun->roles }}" selected>{{ $akun->roles }}
                                                    </option>
                                                @endif

                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('roles', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Email <code>*</code></label>
                                            <input type="hidden" name="email_old" value="{{ $akun->email }}">
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $akun->email }}" required placeholder="Email">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('email', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Password</label>
                                            <input type="hidden" class="form-control" id="password_old" name="password_old"
                                                value="{{ $akun->password }}" required placeholder="Password">
                                            <input type="password" class="form-control" id="password" name="password"
                                                value="{{ $akun->password }}" required placeholder="Password">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('password', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="kelas_class">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Jenjang Pendidikan
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="id_school_level" disabled
                                                id="id_school_level">
                                                <option value="">--Pilih Kelas--</option>
                                                @foreach ($school_level as $itm)
                                                    <option value="{{ $itm->id }}"
                                                        {{ $itm->id == $akun->id_school_level ? 'selected' : '' }}>
                                                        {{ $itm->level }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"
                                        {{ Auth::user()->roles == 'Admin' || Auth::user()->roles == 'Administrator' ? '' : 'hidden' }}>
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Status Aktif
                                                <code>*</code></label>
                                            <div>
                                                <input type="checkbox" id="switch1" switch="none" name="aktif"
                                                    {{ $akun->aktif == '1' ? 'checked' : '' }} />
                                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        @if (Auth::user()->roles == 'Admin' or Auth::user()->roles == 'Administrator')
                                            <a href="{{ route('akun.index') }}"
                                                class="btn btn-secondary waves-effect">Batal</a>
                                        @else
                                            <a href="{{ route('dashboard') }}"
                                                class="btn btn-secondary waves-effect">Batal</a>
                                        @endif
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // onload
            let roles = document.getElementById("roles").value;
            if (roles == 'Siswa') {
                document.getElementById("id_school_level").required = true;
                document.getElementById("kelas_class").style.display = 'block';
            } else {
                document.getElementById("id_school_level").required = false;
                document.getElementById("kelas_class").style.display = 'none';
            }
            // change dropdown siswa
            $('#roles').bind('change', function() {
                let roles = document.getElementById("roles").value;
                if (roles == 'Siswa') {
                    document.getElementById("id_school_level").required = true;
                    document.getElementById("kelas_class").style.display = 'block';
                } else {
                    document.getElementById("id_school_level").required = false;
                    document.getElementById("kelas_class").style.display = 'none';
                }
            });
        });
    </script>
@endsection
