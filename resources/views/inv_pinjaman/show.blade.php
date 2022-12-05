@extends('layouts.main')
@section('container')

    <body class="InvBarang">
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
                                        <div class="col-md-3 peminjam">
                                            <div class="mb-3">
                                                <label>Kode Transaksi <code>*</code></label>
                                                <input type="disable" class="form-control"
                                                    value="{{ $data_pinjaman[0]->kode_transaksi }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam">
                                            <div class="mb-3">
                                                <label>Peminjam <code>*</code></label>
                                                <input type="disable" class="form-control" name="peminjam1" id="peminjam1"
                                                    value="{{ $data_pinjaman[0]->users->name }}" readonly>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_peminjam" name="nama_peminjam" value="">
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_permintaan }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pemakaian <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_pemakaian }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Rencana Pengembalian <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->estimasi_kembali }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Diberikan <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_diberikan }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pengembalian Barang<code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_kembali }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-responsive table-bordered table-striped"
                                                        id="tablePinjam">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 10%">No</th>
                                                                <th class="text-center" style="width: 15%">Nama Barang</th>
                                                                <th class="text-center" style="width: 15%">No Inv</th>
                                                                <th class="text-center" style="width: 15%">ID Barang</th>
                                                                <th class="text-center" style="width: 15%">Kembali</th>
                                                                <th class="text-center" hidden>{{ Auth::user()->id }}</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($data_pinjaman as $item)
                                                            <tbody>
                                                                <td class="text-center" style="width: 10%">
                                                                    {{ $loop->iteration }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $item->barang->nama }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $item->barang->nomor_inventaris }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $item->barang->idbarang }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $item->tgl_kembali }}</td>
                                                            </tbody>
                                                        @endforeach

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('inv_pinjaman.index') }}"
                                                        class="btn btn-secondary waves-effect">Kembali</a>
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
    </body>
@endsection
