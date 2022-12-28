@extends('layouts.main')
@section('container')

    <body>
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
                <form id="form" class="needs-validation">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Kode Perawatan <code>*</code></label>
                                                <input type="disable" class="form-control"
                                                    value="{{ $perawatan[0]->kode_perawatan }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Siswa <code>*</code></label>
                                                <input type="disable" class="form-control" name="peminjam1" id="peminjam1"
                                                    value="{{ $perawatan[0]->siswa->nama_lengkap }}" readonly>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_peminjam" name="nama_peminjam" value="">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tanggal Masuk UKS <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $perawatan[0]->tgl }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Masuk <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $perawatan[0]->masuk }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-watch"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Gejala<code>*</code></label>
                                                <div class="input-group" id="gejala" name="gejala">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $perawatan[0]->gejala }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea type="text" class="form-control" id="desc" disabled placeholder="Keterangan">{{ $perawatan[0]->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Keluar <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $perawatan[0]->keluar }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-watch"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tablePinjam">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">No</th>
                                                        <th class="text-center" style="width: 15%">Obat</th>
                                                        <th class="text-center" style="width: 15%">Kadaluarsa </th>
                                                        <th class="text-center" style="width: 15%">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($perawatan as $item)
                                                        <tr>
                                                            <td class="text-center" style="width: 10%">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->uks_obat->obat }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->stok_obat->tgl_ed }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->qty }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a href="{{ route('perawatan.index') }}"
                                                class="btn btn-secondary waves-effect">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
