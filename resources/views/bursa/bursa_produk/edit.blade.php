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
            <form class="needs-validation" action="{{ route('bursa_produk.update', Crypt::encryptString($produk->id)) }}"
                method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nama Produk
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                style="text-transform:uppercase" value="{{ $produk->nama }}" autofocus
                                                required placeholder="Nama">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Deskripsi Produk
                                                <code>*</code></label>
                                            <textarea name="desc" class="form-control">{{ old('desc', $produk->deskripsi) }}</textarea>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Barcode
                                            </label>
                                            <input type="text" class="form-control" id="barcode" name="barcode"
                                                style="text-transform:uppercase" value="{{ $produk->barcode }}" required
                                                placeholder="barcode">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('barcode', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Stok Minimal
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="stok_minimal" name="stok_minimal"
                                                style="text-transform:uppercase" value="{{ $produk->stok_minimal }}"
                                                autofocus required placeholder="stok_minimal">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('stok_minimal', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Satuan
                                            </label>
                                            <select name="id_satuan" id="id_satuan"
                                                class="form-control select select2 id_satuan">
                                                <option value=""> -Pilih Satuan</option>
                                                @foreach ($satuan as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ $data->id == $produk->id_satuan ? 'selected' : '' }}>
                                                        {{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('id_satuan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Kategori
                                                <code>*</code></label>
                                            <select name="id_kategori" id="id_kategori"
                                                class="form-control select select2 id_kategori">
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategori as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $produk->id_kategori ? 'selected' : '' }}>
                                                        {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('id_kategori', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Status
                                                <code>*</code></label>
                                            <div>
                                                <input type="checkbox" id="switch1" switch="none" name="status1"
                                                    {{ $produk->status == 1 ? 'checked' : '' }} />
                                                <label for="switch1" data-on-label="Aktif" data-off-label="Tidak"></label>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('bursa_produk.index') }}"
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
