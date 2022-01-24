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
        <form class="needs-validation" action="{{ route("agama.update") }}" method="POST" novalidate>
            @csrf
            <input type="hidden" class="Id" id="Id" name="id" value="{{ $agama->id }}">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Agama</label>
                                        <input type="text" class="form-control" id="agama" name="agama" value="{{ $agama->agama }}" required placeholder="Agama" autofocus>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        {!! $errors->first('agama', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Status Aktif</label>
                                        <div>
                                            <input type="checkbox" id="switch1" switch="none" name="aktif" {{ $agama->aktif === 1 ? 'checked' : '' }} />
                                            <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-3">
                                    <a href="{{ route('agama') }}" class="btn btn-secondary waves-effect">Cancel</a>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-sm-end mt-2 mt-sm-0">
                                        <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection