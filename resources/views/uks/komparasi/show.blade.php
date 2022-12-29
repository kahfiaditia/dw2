@extends('layouts.main')
@section('container')

    <body onload="myLoad()">
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
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Kode Komparasi</label>
                                            <input type="text" class="form-control"
                                                value="{{ $data[0]->kode_komparasi }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">User Input</label>
                                            <input type="text" class="form-control" value="{{ $data[0]->user->name }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Tanggal Input</label>
                                            <div class="input-group" id="datepicker2">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $data[0]->created_at }}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-responsive table-bordered table-striped" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5%">#</th>
                                                    <th class="text-center" style="width: 20%">Kode Opname</th>
                                                    <th class="text-center" style="width: 30%">Obat</th>
                                                    <th class="text-center" style="width: 10%">Jumlah Opname</th>
                                                    <th class="text-center" style="width: 10%">Jumlah Sistem</th>
                                                    <th class="text-center" style="width: 10%">Adjust Stok</th>
                                                    <th class="text-center" style="width: 15%">Type Adjust</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $list)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $list->kode_opname }}</td>
                                                        <td>
                                                            {{ $list->obat->obat . ' - ' . $list->obat->jenis->jenis_obat }}
                                                        </td>
                                                        <td class="text-center">{{ $list->stok_opname }}</td>
                                                        <td class="text-center">{{ $list->stok_sistem }}</td>
                                                        <td class="text-center">{{ $list->adjust_stok }}</td>
                                                        <td class="text-center">
                                                            @if ($list->type_adjust)
                                                                <span
                                                                    class="badge badge-pill badge-soft-warning font-size-12">Selisih</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">Sesuai</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('komparasi.hasil_komparasi') }}"
                                            class="btn btn-secondary waves-effect">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </body>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection
