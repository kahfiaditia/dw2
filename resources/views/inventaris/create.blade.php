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
                                {{-- <li class="breadcrumb-item">{{ ucwords($submenu) }}</li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route('inventaris.index') }}" enctype="multipart/form-data"
                method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nama Inventaris
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                autofocus value="{{ old('nama') }}" required
                                                placeholder="Nama Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nomor
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="nomor_inventaris"
                                                name="nomor_inventaris" autofocus value="{{ old('nomor_inventaris') }}"
                                                required placeholder="Nomor Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nomor_inventaris', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nomor ID Barang
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="idbarang" name="idbarang"
                                                autofocus value="{{ old('idbarang') }}" required
                                                placeholder="Nomor ID Barang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('idbarang', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Pemilik
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="owner" name="owner"
                                                value="{{ old('owner') }}" required
                                                placeholder="Unit / Bagian Pemilik Barang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('owner', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Qty
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="qty" name="qty"
                                                autofocus value="{{ old('qty') }}" required placeholder="Jumlah Barang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('qty', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ruangan <code>*</code></label>
                                            <select class="form-control select select2 status" name="status" required>
                                                <option value="">-- Pilih Ruangan --</option>
                                                <option value="Baik"> LAB METTA </option>
                                                <option value="Rusak"> LAB KARUNA </option>
                                                <option value="Rusak"> LAB MUDITA </option>
                                                <option value="Rusak"> LAB UPEKHA </option>
                                                <option value="Rusak"> GUDANG IT </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kondisi Barang <code>*</code></label>
                                            <select class="form-control select select2 status" name="status" required>
                                                <option value="">--Pilih Status--</option>
                                                <option value="Baik"> Baik </option>
                                                <option value="Rusak"> Rusak </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Indikasi
                                            </label>
                                            <input type="number" class="form-control" id="qty" name="qty"
                                                autofocus value="{{ old('qty') }}" placeholder="Jumlah Barang">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Deskripsi Barang
                                                <code>*</code></label>
                                            <textarea class="form-control" id="desc" name="desc" {{ old('desc') }}
                                                placeholder="Status Barang ex: Baik / Rusak"></textarea>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('inventaris.index') }}"
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
            <br>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
@endsection
