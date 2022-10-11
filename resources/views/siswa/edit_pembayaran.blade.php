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
            <form class="needs-validation"
                action="{{ route('siswa.update_pembayaran', Crypt::encryptString($student->id)) }}" method="POST"
                novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Nama <code>*</code></label>
                                            <input type="text" class="form-control" name="nama" readonly
                                                placeholder="Nama" value="{{ $student->nama_lengkap }}">
                                            <input type="hidden" name="user_id" value="{{ $student->user_id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Uang Formulir <code>*</code></label>
                                            <select class="form-control select select2" name="formulir" id="formulir">
                                                <option value="">--Pilih Uang Formulir --</option>
                                                @foreach ($formulir as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $student->formulir_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->level .
                                                            '.' .
                                                            $item->classes .
                                                            ' - ' .
                                                            $item->year .
                                                            '/' .
                                                            $item->year_end .
                                                            ' - ' .
                                                            number_format($item->amount) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('formulir', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Uang Pangkal <code>*</code></label>
                                            <select class="form-control select select2" name="pangkal" id="pangkal">
                                                <option value="">--Pilih Uang Pangkal --</option>
                                                @foreach ($pangkal as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $student->pangkal_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->level .
                                                            '.' .
                                                            $item->classes .
                                                            ' - ' .
                                                            $item->year .
                                                            '/' .
                                                            $item->year_end .
                                                            ' - ' .
                                                            number_format($item->amount) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('pangkal', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Uang SPP <code>*</code></label>
                                            <select class="form-control select select2" name="spp" id="spp">
                                                <option value="">--Pilih Uang SPP --</option>
                                                @foreach ($spp as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $student->spp_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->level .
                                                            '.' .
                                                            $item->classes .
                                                            ' - ' .
                                                            $item->year .
                                                            '/' .
                                                            $item->year_end .
                                                            ' - ' .
                                                            number_format($item->amount) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('spp', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Uang Kegiatan <code>*</code></label>
                                            <select class="form-control select select2" name="kegiatan" id="kegiatan">
                                                <option value="">--Pilih Uang Kegiatan --</option>
                                                @foreach ($kegiatan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $student->kegiatan_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->level .
                                                            '.' .
                                                            $item->classes .
                                                            ' - ' .
                                                            $item->year .
                                                            '/' .
                                                            $item->year_end .
                                                            ' - ' .
                                                            number_format($item->amount) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kegiatan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Kelas <code>*</code></label>
                                            <select class="form-control select select2" name="kelas" id="kelas"
                                                required>
                                                <option value="">--Pilih Kelas --</option>
                                                @foreach ($kelas as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $student->class_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->level . ' ' }}{{ $item->classes }}{{ $item->jurusan ? ' ' . $item->jurusan . ' ' : ' ' }}{{ $item->type ? $item->type : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kegiatan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email <code>*</code></label>
                                        <input type="email" class="form-control Email_siswa" name="email" required
                                            placeholder="Email" value="{{ $student->email }}">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="validationCustom02" class="form-label">NIS (No Induk
                                            Sekolah)
                                            <code>*</code></label>
                                        <input type="text" class="form-control input-mask" name="" id="nis_mask"
                                            maxlength="20" required value="{{ old('nis', $student->nis) }}"
                                            placeholder="NIS">
                                        <input type="hidden" name="nis" id="nis"
                                            value="{{ str_replace('-', '', $student->nis) }}">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        @error('nis')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom02" class="form-label">NISN
                                            <code>*</code></label>
                                        <input type="text" class="form-control number-only nisn" name="nisn"
                                            placeholder="NISN" value="{{ old('nisn', $student->nisn) }}" maxlength="20"
                                            required>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        @error('nisn')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">NIK<code>*</code></label>
                                            <input type="text" class="form-control number-only" name="nik"
                                                placeholder="NIK" value="{{ old('nik', $student->nik) }}" maxlength="20"
                                                required>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('nik')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('siswa.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
