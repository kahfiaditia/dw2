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
            <form class="needs-validation" action="{{ route('diskon.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Type Diskon Pembayaran <code>*</code></label><select
                                                class="form-control select select2" name="type_diskon" id="type_diskon"
                                                required>
                                                <option value="">--Pilih Type Diskon Pembayaran --</option>
                                                <option value="1">Pembayaran</option>
                                                <option value="0">Prestasi</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Nama Diskon <code>*</code></label>
                                            <input type="text" class="form-control" name="diskon"
                                                placeholder="Nama Diskon" required value="{{ old('diskon') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('diskon')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Keterangan Diskon <code>*</code></label>
                                            <input type="text" class="form-control" name="keterangan"
                                                placeholder="Keterangan Diskon" required value="{{ old('keterangan') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('keterangan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Jumlah Bulan Pembayaran Langsung (12 Bulan, 6 Bulan, 3
                                                Bulan)
                                                <code>*</code></label>
                                            <input type="number" class="number-only form-control" name="jml_bln_byr"
                                                id="jml_bln_byr" maxlength="2" min="0" max="12"
                                                placeholder="Jumlah Bulan Pembayaran Langsung" required
                                                value="{{ old('jml_bln_byr') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi dan Maximal 12 Bulan.
                                            </div>
                                            @error('jml_bln_byr')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Jumlah Diskon Bulan (Lipatan Bulan = 0.5, 1,
                                                2) </label>
                                            <input type="number" class="form-control" name="diskon_bln" maxlength="2"
                                                min="0" max="12" step="0.1"
                                                placeholder="Jumlah Diskon Bulan" value="{{ old('diskon_bln') }}">
                                            <div class="invalid-feedback">
                                                Maximal 0.1 - 12 Bulan.
                                            </div>
                                            @error('diskon_bln')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Diskon Persentasi</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="diskon_persentase"
                                                        maxlength="3" min="0" max="100" step="0.1"
                                                        id="diskon_persentase" placeholder="Diskon Persentasi"
                                                        value="{{ old('diskon_persentase') }}">
                                                    <span class="input-group-text"><b>%</b></span>
                                                    <div class="invalid-feedback">
                                                        Maximal 100%.
                                                    </div>
                                                </div>
                                            </div>
                                            @error('diskon_persentase')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('diskon.index') }}"
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
    <script>
        $(document).ready(function() {
            $('#type_diskon').bind('change', function() {
                let type_diskon = document.getElementById("type_diskon").value;
                if (type_diskon == 1) {
                    document.getElementById("jml_bln_byr").required = true;
                    document.getElementById("jml_bln_byr").readOnly = false;
                    document.getElementById("diskon_persentase").required = true;
                    document.getElementById("diskon_persentase").readOnly = false;
                } else {
                    document.getElementById("jml_bln_byr").required = false;
                    document.getElementById("jml_bln_byr").readOnly = true;
                    document.getElementById("diskon_persentase").required = false;
                    document.getElementById("diskon_persentase").readOnly = true;
                }
            });
        });
    </script>
@endsection
