@extends('layouts.main')
@section('container')

    <body class="InvBarang">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">{{ ucwords($menu) }}</a></li>
                                    <li class="breadcrumb-item active">{{ ucwords($submenu) }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16">Order# {{ $penjualan->kode_penjualan }}</h4>

                                    <div class="mb-4">
                                        <img src="{{ asset('assets/images/logo/sid.png') }}" alt="logo"
                                            height="20" />
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <address>
                                        <strong>Tanggal Penjualan : </strong> {{ $penjualan->created_at }}<br>
                                    </address>
                                </div>
                                <table class="table table-nowrap mt-6">
                                    <thead>
                                        <tr>
                                            <th>Pembeli</th>
                                            <th>Total Transaksi</th>
                                            <th>Total Modal</th>
                                            <th>Total Margin</th>
                                            <th>Jenis Produk</th>
                                            <th>Total Jumlah</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $penjualan->siswa->nama_lengkap }}</td>
                                            <td>{{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                            <td>{{ number_format($penjualan->total_modal, 0, ',', '.') }}</td>
                                            <td>{{ number_format($penjualan->total_margin, 0, ',', '.') }}</td>
                                            <td>{{ $penjualan->total_produk }}</td>
                                            <td>{{ $penjualan->keterangan }}</td>
                                            <td>{{ $penjualan->keterangan }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="py-2 mb-6">
                                    <h3 class="font-size-15 fw-bold">Detil Transaksi</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga Jual</th>
                                                <th>Sub Total Transaksi</th>
                                                <th>Harga Modal</th>
                                                <th>Total Modal</th>
                                                <th>Total Margin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detil as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->produk->nama }}</td>
                                                    <td>{{ $item->kuantiti }}</td>
                                                    <td>{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($item->harga_modal, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($item->sub_modal, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($item->sub_margin, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()"
                                            class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fa fa-print"></i></a>
                                        <a href="javascript: void(0);"
                                            class="btn btn-primary w-md waves-effect waves-light">Send</a>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('laporan_penjualan.index') }}"
                                            class="btn btn-secondary waves-effect">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </body>
@endsection
