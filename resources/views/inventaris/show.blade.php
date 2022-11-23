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
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- baris atas --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Inventaris
                                            <code>*</code></label>
                                        <input class="form-control" value="{{ $inventaris->nama }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Inventaris
                                            <code>*</code></label>
                                        <input class="form-control" value="{{ $inventaris->nomor_inventaris }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">ID Inventaris
                                            <code>*</code></label>
                                        <input class="form-control" value="{{ $inventaris->idbarang }}" readonly>
                                    </div>
                                </div>
                            </div>
                            {{-- batas baris atas --}}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Qty
                                            <code>*</code></label>
                                        <input class="form-control" value='{{ $inventaris->qty }}' readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ruang Penempatan <code>*</code></label>
                                        <input class="form-control" value='{{ $inventaris->ruang->nama }}' readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kondisi Barang <code>*</code></label>
                                        <input class="form-control" value="{{ $inventaris->status }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ketersediaan
                                            <code>*</code></label>
                                        <input type="text" class="form-control" value="{{ $inventaris->ketersediaan }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Indikasi Kerusakan <code>*</code></label>
                                        <input type="text" class="form-control @error('indikasi') is-invalid @enderror"
                                            id="indikasi" value="{{ $inventaris->indikasi }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Pemilik <code>*</code></label>
                                        <input type="text" class="form-control " value="{{ $inventaris->pemilik }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <input type="text" class="form-control" value="{{ $inventaris->deskripsi }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <a href="{{ route('inventaris.index') }}"
                                        class="btn btn-secondary waves-effect">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
@endsection
