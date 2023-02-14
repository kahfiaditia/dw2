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
            <form class="needs-validation" action="{{ route('supplier.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nama Supplier
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="supplier" name="supplier"
                                                onkeyup="this.value = this.value.toUpperCase();"
                                                value="{{ old('supplier') }}" autofocus required placeholder="Supplier">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('obat', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Alamat
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                onkeyup="this.value = this.value.toUpperCase();"
                                                value="{{ old('supplier') }}" autofocus required
                                                placeholder="Alamat Supplier">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('obat', '<div class="invalid-validasi">:message</div>') !!}
                                            {!! $errors->first('kategori', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nama Kontak
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="supplier" name="nama_kontak"
                                                onkeyup="this.value = this.value.toUpperCase();"
                                                value="{{ old('nama_kontak') }}" autofocus required
                                                placeholder="PIC Supplier">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nama_kontak', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nomor Kontak
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="nomor" name="nomor"
                                                onkeyup="this.value = this.value.toUpperCase();" value="{{ old('nomor') }}"
                                                autofocus required placeholder="Nomor Telepon Supplier">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nomor', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Status
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="status" required>
                                                <option value="">--Pilih Status--</option>
                                                <option value="1"> Aktif </option>
                                                <option value="2"> Non Aktif </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('satuan.index') }}"
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
