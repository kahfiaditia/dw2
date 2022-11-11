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
            <form class="needs-validation" action="{{ route('setting.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Provinsi Sekolah <code>*</code></label>
                                            <select name="provinsi_sekolah" required
                                                class="form-control mb-3 select select2">
                                                <option value="">-- Provinsi Sekolah --</option>
                                                @foreach ($provinsi as $item)
                                                    <option value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('provinsi_sekolah')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Maintenance Website
                                                <code>*</code></label>
                                            <div>
                                                <input type="checkbox" id="switch1" switch="none" name="maintenance" />
                                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Hari Peminjaman Buku</label>
                                            <input type="number" class="form-control number-only" id="library_loan_day"
                                                name="library_loan_day" value="{{ old('library_loan_day') }}"
                                                placeholder="Hari Peminjaman Buku">
                                            {!! $errors->first(
                                                'library_loan_day',
                                                '<div class="invalid-validasi">Hari Peminjaman Buku maskimal berisi 1 karakter.</div>',
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Limit Jumlah Peminjaman
                                                Buku</label>
                                            <input type="text" class="form-control number-only"
                                                id="library_loan_validation" name="library_loan_validation"
                                                value="{{ old('library_loan_validation') }}"
                                                placeholder="Jumlah Peminjaman Buku">
                                            {!! $errors->first(
                                                'library_loan_validation',
                                                '<div class="invalid-validasi">Jumlah Peminjaman Buku maskimal berisi 1 karakter.</div>',
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('setting.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
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
@endsection
