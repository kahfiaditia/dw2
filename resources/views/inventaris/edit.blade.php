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
            <form class="needs-validation" action="{{ route('inventaris.update', Crypt::encryptString($inventaris->id)) }}"
                enctype="multipart/form-data" method="POST" novalidate>
                @method('PUT')
                @csrf
                {{--     --}}
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Inventaris
                                                <code>*</code></label>
                                            <input type="text" name="nama"
                                                class="form-control  @error('name') is-invalid @enderror"
                                                value="{{ old('nama', $inventaris->nama) }}"
                                                oninput="this.value = this.value.toUpperCase()" required
                                                placeholder="Nama Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('name', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nomor Inventaris
                                                <code>*</code></label>
                                            <input type="text" name="nomor_inventaris" class="form-control "
                                                value="{{ old('nomor_inventaris', $inventaris->nomor_inventaris) }}"
                                                required placeholder="Nama Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('nomor_inventaris', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">ID Inventaris
                                                <code>*</code></label>
                                            <input type="text" name="idbarang" class="form-control"
                                                value="{{ old('idbarang', $inventaris->idbarang) }}" required
                                                placeholder="Nama Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('owner', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Qty
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="qty" name="qty"
                                                value="{{ $inventaris->qty }}" min="1"
                                                {{ old('qty', $inventaris->qty) }}" required placeholder="Jumlah Barang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('qty', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Ruang Penempatan <code>*</code></label>
                                            <select class="form-control select select2 id_ruangan" name="id_ruangan"
                                                id="id_ruangan" required>
                                                @foreach ($ruangs as $ruang)
                                                    <option value="{{ $ruang->id }}"
                                                        {{ old('id_ruangan', $inventaris->id_ruangan) == $ruang->id ? 'selected' : null }}>
                                                        {{ $ruang->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('id_ruangan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kondisi Barang <code>*</code></label>
                                            <select class="form-control select status @error('status') is-invalid @enderror"
                                                name="status" required>
                                                <option
                                                    {{ old('status', $inventaris->status) == 'Baik' ? 'selected' : '' }}
                                                    value="Baik">Baik</option>
                                                <option
                                                    {{ old('status', $inventaris->status) == 'Rusak' ? 'selected' : '' }}
                                                    value="Rusak">Rusak</option>
                                                <option
                                                    {{ old('status', $inventaris->status) == 'SPEK TDK LAYAK' ? 'selected' : null }}
                                                    value="SPEK TDK LAYAK">SPEK TDK LAYAK
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Ketersediaan
                                                <code>*</code></label>
                                            <select
                                                class="form-control select select2 ketersediaan
                                                id="ketersediaan"
                                                name="ketersediaan">
                                                <option
                                                    {{ old('ketersediaan', $inventaris->ketersediaan) == 'TERPAKAI' ? 'selected' : null }}
                                                    value="TERPAKAI">
                                                    TERPAKAI
                                                </option>
                                                <option
                                                    {{ old('ketersediaan', $inventaris->ketersediaan) == 'TIDAK TERPAKAI' ? 'selected' : null }}
                                                    value="TIDAK TERPAKAI">
                                                    TIDAK TERPAKAI
                                                </option>
                                                <option
                                                    {{ old('ketersediaan', $inventaris->ketersediaan) == 'DAPAT DIPINJAM' ? 'selected' : null }}
                                                    value="DAPAT DIPINJAM">
                                                    DAPAT DIPINJAM
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('qty', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Indikasi Kerusakan <code>*</code></label>
                                            <input type="text"
                                                class="form-control select indikasi
                                                id="indikasi"
                                                name="indikasi" value="{{ $inventaris->indikasi }}"
                                                {{ old('indikasi', $inventaris->indikasi) }} placeholder="Indikasi">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Pemilik <code>*</code></label>
                                            <select
                                                class="form-control select select2 pemilik
                                                name="pemilik"
                                                required>
                                                <option
                                                    {{ old('pemilik', $inventaris->indikasi) == 'Yayasan' ? 'selected' : '' }}
                                                    value="Yayasan">Yayasan</option>
                                                <option
                                                    {{ old('pemilik', $inventaris->indikasi) == 'TK' ? 'selected' : '' }}
                                                    value="TK">TK</option>
                                                <option
                                                    {{ old('pemilik', $inventaris->indikasi) == 'SD' ? 'selected' : '' }}
                                                    value="SD">SD</option>
                                                <option
                                                    {{ old('pemilik', $inventaris->indikasi) == 'SMP' ? 'selected' : '' }}
                                                    value="SMP">SMP</option>
                                                <option
                                                    {{ old('pemilik', $inventaris->indikasi) == 'SMK' ? 'selected' : '' }}
                                                    value="SMK">SMK</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="deskripsi" class="form-control  @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $inventaris->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
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
