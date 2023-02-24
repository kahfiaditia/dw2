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
                                @if (in_array('93', $session_menu))
                                    <a href="{{ route('bursa_pembelian.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Pembelian
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
                                        <th>Kode Transaksi</th>
                                        <th>No DO</th>
                                        <th>Supplier</th>
                                        <th>Jumlah Produk</th>
                                        <th>Ongkir</th>
                                        <th>Nilai Pembelian</th>
                                        <th>Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_transaksi }}</td>
                                            <td>{{ $item->nomor_do }}</td>
                                            <td>{{ $item->supplier->nama }}</td>
                                            <td>{{ $item->total_produk }}</td>
                                            <td>{{ $item->ongkir }}</td>
                                            <td>Rp. {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                                            <td>{{ $item->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}</td>
                                            <td>
                                                <form class="delete-form"
                                                    action="{{ route('bursa_pembelian.destroy', Crypt::encryptString($item->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('94', $session_menu))
                                                            <a href="{{ route('bursa_pembelian.show', Crypt::encryptString($item->id)) }}"
                                                                class="text-info" title="View">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array('94', $session_menu))
                                                            <a href="{{ route('bursa_pembelian.edit', Crypt::encryptString($item->id)) }}"
                                                                class="text-success"><i
                                                                    class="mdi mdi-pencil font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('95', $session_menu))
                                                            <a href class="text-danger delete_confirm"><i
                                                                    class="mdi mdi-delete font-size-18"></i></a>
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
