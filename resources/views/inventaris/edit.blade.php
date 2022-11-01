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
            <form class="needs-validation" action="{{ route('inventaris.update', $inventaris->id) }}"
                enctype="multipart/form-data" method="POST" novalidate>
                @method('PUT')
                @csrf
                {{--     --}}
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nama Inventaris
                                                <code>*</code></label>
                                            <input type="text" name="name"
                                                class="form-control  @error('name') is-invalid @enderror"
                                                value="{{ old('name', $inventaris->name) }}" required
                                                placeholder="Nama Inventaris">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('name', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Pemilik
                                                <code>*</code></label>
                                            <input type="text" name="owner"
                                                class="form-control @error('owner') is-invalid @enderror"
                                                value="{{ old('owner', $inventaris->owner) }}" required
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
                                            <input type="number" class="form-control @error('qty') is-invalid @enderror"
                                                id="qty" name="qty" value="{{ $inventaris->qty }}"
                                                {{ old('qty', $inventaris->qty) }}" required placeholder="Jumlah Barang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('qty', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kondisi Barang <code>*</code></label>
                                            <select
                                                class="form-control select select2 status @error('status') is-invalid @enderror"
                                                name="status" required>
                                                <option {{ old('status', $inventaris->status) == 'Baik' ? 'selected' : '' }}
                                                    value="Baik">Baik</option>
                                                <option
                                                    {{ old('status', $inventaris->status) == 'Rusak' ? 'selected' : '' }}
                                                    value="Rusak">Rusak</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('status', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="desc" class="form-control  @error('desc') is-invalid @enderror">{{ old('desc', $inventaris->desc) }}</textarea>
                                            @error('desc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
