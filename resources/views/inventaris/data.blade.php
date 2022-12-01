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
                                @if (in_array('12', $session_menu))
                                    <a href="{{ route('inventaris.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Inventaris
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
                            <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Inv</th>
                                        <th>ID Barang</th>
                                        <th>Keterangan</th>
                                        <th>Ruangan</th>
                                        <th>Ketersediaan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventaris as $inv)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $inv->nama }}</td>
                                            <td>{{ $inv->nomor_inventaris }}</td>
                                            <td>{{ $inv->idbarang }}</td>
                                            <td>{{ $inv->status }}</td>
                                            <td>{{ $inv->ruang->nama }}</td>
                                            <td>{{ $inv->ketersediaan }}</td>
                                            <td>
                                                <?php $id = Crypt::encryptString($inv->id); ?>
                                                <form class="delete-form" action="{{ route('inventaris.destroy', $id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('83', $session_menu))
                                                            <a href="{{ route('inventaris.show', $id) }}"
                                                                class="text-info">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array('85', $session_menu))
                                                            <a href="{{ route('inventaris.edit', $id) }}"
                                                                class="text-success">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array('86', $session_menu))
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
