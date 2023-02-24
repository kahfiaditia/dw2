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
                                                <label>Kode Transaksi</label>
                                                <input type="disable" class="form-control"
                                                    value="{{ $pembelian[0]->kode_transaksi }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam">
                                            <div class="mb-3">
                                                <label>Tanggal Permintaan</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->tgl_permintaan }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                                </div>

                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_peminjam" name="nama_peminjam" value="">
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Kedatangan</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->tgl_kedatangan }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Nomor Surat Jalan</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->nomor_do }}" readonly>
                                                    <span class="input-group-text"><i class="bx bx-receipt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Supplier</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->supplier->nama }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Total Produk</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->total_produk }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Ongkir</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="Rp. {{ number_format($pembelian[0]->ongkir, 0, ',', '.') }}"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="bx bx-dollar-circle"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Potongan Pembelian</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="Rp. {{ number_format($pembelian[0]->potongan, 0, ',', '.') }}"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="bx bx-dollar-circle"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Total Pembelian</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value=" Rp. {{ number_format($pembelian[0]->total_nilai, 0, ',', '.') }}"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="bx bx-dollar-circle"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Status Pembayaran</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Jenis Pembayaran</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->jenis_pembayaran == 1 ? 'Transfer' : 'Cash / Tunai' }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Keterangnan</label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $pembelian[0]->keterangan }}" readonly>
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
                                                                <th class="text-center" style="width: 15%">Nama Produk
                                                                </th>
                                                                <th class="text-center" style="width: 15%">Kadaluarsa</th>
                                                                <th class="text-center" style="width: 15%">Nilai PO Produk
                                                                </th>
                                                                <th class="text-center" style="width: 15%">Jumlah PCS</th>
                                                                <th class="text-center" style="width: 15%">Harga Per PCS
                                                                </th>
                                                                <th class="text-center" style="width: 15%">Harga Jual</th>
                                                                <th class="text-center" hidden>{{ Auth::user()->id }}</th>
                                                            </tr>
                                                        </thead>
                                                        {{-- {{ dd($detilpembelian) }}; --}}
                                                        @foreach ($detilpembelian as $detil)
                                                            <tbody>
                                                                <td class="text-center" style="width: 10%">
                                                                    {{ $loop->iteration }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $detil->produk->nama }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    <?php
                                                                    if (strlen($detil->kadaluarsa) > 10) {
                                                                        $titik = null;
                                                                    }
                                                                    ?>
                                                                    <?php echo substr($detil->kadaluarsa, 0, 10) . $titik; ?>
                                                                </td>
                                                                <td class="text-center" style="width: 15%">
                                                                    Rp
                                                                    {{ number_format($detil->harga_total_produk, 0, ',', '.') }}
                                                                <td class="text-center" style="width: 15%">
                                                                    {{ $detil->total_kuantiti }}</td>
                                                                <td class="text-center" style="width: 15%">
                                                                    Rp
                                                                    {{ number_format($detil->nilai_per_pcs, 0, ',', '.') }}
                                                                </td>
                                                                <td class="text-center" style="width: 15%">
                                                                    Rp
                                                                    {{ number_format($detil->nilai_jual, 0, ',', '.') }}
                                                            </tbody>
                                                        @endforeach

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('bursa_pembelian.index') }}"
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
