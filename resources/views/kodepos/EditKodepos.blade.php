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
        <form class="needs-validation" action="{{ route("kodepos.update") }}" method="POST" novalidate>
            @csrf
            <input type="hidden" class="Id" id="Id" name="id" value="{{ $kodepos->id }}">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $kodepos->provinsi }}" required placeholder="Provinsi" autofocus>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ $kodepos->kabupaten }}" required placeholder="Kota">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Kelurahan</label>
                                        <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ $kodepos->kelurahan }}" required placeholder="Kelurahan">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $kodepos->kecamatan }}" required placeholder="Kecamatan">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Kodepos</label>
                                        <input type="text" class="form-control" id="kodepos" name="kodepos" value="{{ $kodepos->kodepos }}" required placeholder="Kodepos">
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Status Aktif</label>
                                        <div>
                                            <input type="checkbox" id="switch1" switch="none" name="Status" {{ $kodepos->status === 'A' ? 'checked' : '' }} />
                                            <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </form>
    </div> <!-- container-fluid -->
</div>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection