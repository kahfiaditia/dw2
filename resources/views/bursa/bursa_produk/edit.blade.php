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
                                            <label for="validationCustom02" class="form-label">Barcode
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="barcode" name="barcode"
                                                style="text-transform:uppercase" value="{{ $produk->barcode }}" autofocus
                                                required placeholder="Barcode">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('Barcode', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Satuan
                                                <code>*</code></label>
                                            <select class="form-control select select2" id="id_satuan" name="id_satuan"
                                                required>
                                                @foreach ($satuan as $satuan)
                                                    <option value="{{ $satuan->id }}"
                                                        {{ old('id_satuan', $produk->id_satuan) == $satuan->id ? 'selected' : null }}>
                                                        {{ $satuan->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('Satuan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Kategori
                                                <code>*</code></label>
                                            <select class="form-control select select2" id="id_kategori" name="id_kategori"
                                                required>
                                                @foreach ($kategori as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ old('id_kategori', $produk->id_kategori) == $kategori->id ? 'selected' : null }}>
                                                        {{ $kategori->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kategori', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label"> Status
                                                <code>*</code></label>
                                            <select class="form-control select select2" id="status1" name="status1"
                                                required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="1" {{ $produk->status == 1 ? 'selected' : '' }}> Aktif
                                                </option>
                                                <option value="2" {{ $produk->status == 2 ? 'selected' : '' }}> Tidak
                                                    Aktif
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Deskripsi
                                            </label>
                                            <input type="text" class="form-control" id="desc" name="desc"
                                                style="text-transform:uppercase" value="{{ $produk->deskripsi }}" required
                                                placeholder="Deskripsi Produk">
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
                                            <label for="validationCustom02" class="form-label">Harga Beli
                                            </label>
                                            <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                                                style="text-transform:uppercase" value="{{ $produk->harga_beli }}"
                                                autofocus required placeholder="Harga Beli">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('Harga Beli', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Harga Jual
                                            </label>
                                            <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                                style="text-transform:uppercase" value="{{ $produk->harga_jual }}"
                                                required placeholder="Harga Jual">
                                            <div class="invalid-feedback">
                                                Data wajib diisi. dan harus SAMA atau Lebih besar dari Harga Beli
                                            </div>
                                            {!! $errors->first('Harga_jual', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Minimal Stok
                                            </label>
                                            <input type="number" class="form-control" id="stok_minimal"
                                                name="stok_minimal" style="text-transform:uppercase"
                                                value="{{ $produk->harga_beli }}" autofocus required
                                                placeholder="Minimal Stok">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
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
