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
            <form class="needs-validation" action="{{ route('buku.store') }}" enctype="multipart/form-data" method="POST"
                novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Judul <code>*</code></label>
                                            <input type="text" class="form-control" id="judul" name="judul"
                                                autofocus value="{{ old('judul') }}" required placeholder="Judul">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('judul', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Pengarang
                                                <code>*</code></label>
                                            <input type="text" class="form-control" id="pengarang" name="pengarang"
                                                value="{{ old('pengarang') }}" required placeholder="Pengarang">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('pengarang', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Penerbit
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="penerbit_id" id="penerbit_id"
                                                required>
                                                <option value="">--Pilih Penerbit--
                                                </option>
                                                @foreach ($penerbit as $pen)
                                                    <option value="{{ $pen->id }}">
                                                        {{ $pen->nama_penerbit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('penerbit_id', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Kategori
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="kategori_id" id="kategori_id"
                                                required>
                                                <option value="">--Pilih Kategori--
                                                </option>
                                                @foreach ($kategori as $kat)
                                                    <option value="{{ $kat->id }}" data-id="{{ $kat->kode_kategori }}">
                                                        {{ $kat->kode_kategori . '-' . $kat->kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kategori_id', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                        <input type="hidden" name="kode_kategori" id="kode_kategori">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Tahun Terbitan</label>
                                            <input type="text" class="form-control datepicker" name="thn_terbitan"
                                                style="padding: 7px;" maxlength="4" placeholder="Tahun Terbitan"
                                                id="thn_terbitan">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('thn_terbitan', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label>Tanggal Masuk <code>*</code></label>
                                            <div class="input-group" id="datepicker2">
                                                <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                    name="tgl_masuk" value="{{ date('Y-m-d') }}"
                                                    data-date-end-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                                                    data-date-container='#datepicker2' data-provide="datepicker" required
                                                    data-date-autoclose="true">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                            {!! $errors->first('tgl_masuk', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Foto Buku (Max 2
                                                Mb)</label>
                                            <input class="form-control foto" type="file" name="foto"
                                                id="foto">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('foto', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Jumlah Buku
                                                <code>*</code></label>
                                            <input data-parsley-type="number" type="text"
                                                class="form-control number-only" id="jml_buku" name="jml_buku"
                                                value="{{ old('jml_buku') }}" required placeholder="Jumlah Buku">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('jml_buku', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('buku.index') }}"
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
            <br>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            // valdasi extension
            $('#foto').bind('change', function() {
                var file = document.querySelector("#foto");
                if (/\.(jpe?g|png|jpg)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg',
                        'error'
                    ).then(function() {})
                    document.getElementById('foto').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('foto').value = null;
                    }
                }
            });

            $("#kategori_id").change(function() {
                var kode_kategori = $(this).find(':selected').data('id');
                document.getElementById("kode_kategori").value = kode_kategori;
            });
        });
    </script>
@endsection
