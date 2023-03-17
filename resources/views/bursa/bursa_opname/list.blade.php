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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @if (in_array('160', $session_menu))
                                    <a href="{{ route('bursa_opname.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Opname
                                    </a>
                                @endif
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
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Produk</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($laporan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_penjualan }}</td>
                                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->total_modal, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->total_margin, 0, ',', '.') }}</td>

                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <form class="delete-form"
                                                    action="{{ route('laporan_penjualan.destroy', $item->id) }}"
                                                    method="POST">
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('155', $session_menu))
                                                            <a href="{{ route('laporan_penjualan.show', $item->id) }}"
                                                                class="text-info" title="Detil">
                                                                <i class="mdi mdi-eye font-size-18"></i></a>
                                                        @endif

                                                    </div>
                                                </form>
                                            </td>
                                            </?php>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
