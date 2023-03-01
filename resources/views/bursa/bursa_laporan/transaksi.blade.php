@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-left">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            </div>
                            <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Penjualan</th>
                                        <th>Siswa</th>
                                        <th>Total Transaksi</th>
                                        <th>Total Modal</th>
                                        <th>Total Margin</th>
                                        <th>Jenis Produk</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_penjualan }}</td>
                                            <td>{{ $item->id_siswa }}</td>
                                            <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td>{{ number_format($item->total_modal, 0, ',', '.') }}</td>
                                            <td>{{ number_format($item->total_margin, 0, ',', '.') }}</td>
                                            <td>{{ $item->total_produk }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <form class="delete-form"
                                                    action="{{ route('laporan_penjualan.destroy', $item->id) }}"
                                                    method="POST">
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('155', $session_menu))
                                                            <a href="{{ route('laporan_penjualan.show', $item->id) }}"
                                                                class="text-info" title="View">
                                                                <i class="mdi mdi-eye font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('155', $session_menu))
                                                            <a href="{{ route('laporan_penjualan.show', $item->id) }}"
                                                                class="btn btn-success waves-effect waves-light me-1"
                                                                title="Print Struk">
                                                                <i class="fa fa-print"></i></a>
                                                        @endif

                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
