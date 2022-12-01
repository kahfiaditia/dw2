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
                <form id="form" class="needs-validation" action="" method="POST" novalidate>
                    @csrf
                    @method('PATCH')
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
                                                <input type="disable" class="form-control" name="nama_peminjam"
                                                    id="nama_peminjam" value="{{ $data_pinjaman[0]->users->name }}"
                                                    readonly>
                                                {!! $errors->first('nama_peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan <code>*</code></label>
                                                <div class="input-group">
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
                                                <div class="input-group">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_pemakaian }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Rencana Pengembalian <code>*</code></label>
                                                <div class="input-group">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->estimasi_kembali }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-responsive table-bordered table-striped"
                                                    id="tableList">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 5%">No</th>
                                                            <th class="text-center" style="width: 20%">Nama Barang
                                                            </th>
                                                            <th class="text-center" style="width: 15%">No Inv</th>
                                                            <th class="text-center" style="width: 15%">ID Barang</th>
                                                            <th class="text-center" style="width: 15%">Tangal diberikan</th>
                                                            <th class="text-center" style="width: 15%">Diberikan Oleh</th>
                                                            <th class="text-center" style="width: 15%">Aksi</th>
                                                            <th class="text-center" hidden>{{ Auth::user()->id }}</th>
                                                        </tr>
                                                    </thead>
                                                    @foreach ($data_pinjaman as $item)
                                                        <tbody>
                                                            <td class="text-center" style="width: 5%">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center" style="width: 20%">
                                                                {{ $item->barang->nama }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->barang->nomor_inventaris }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->barang->idbarang }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->tgl_diberikan }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->diberikan_oleh }}</td>
                                                            <td class="text-center">

                                                                <?php $id = Crypt::encryptString($item->id); ?>
                                                                <form class="delete-form"
                                                                    action="{{ route('inv_pinjaman.destroy', $id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="d-flex gap-3">
                                                                        <a href="javascript:void(0)"
                                                                            data-id="{{ $id }}"
                                                                            class="text-success" id="get_data_edit"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target=".bs-example-modal-lg-edit">
                                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                                        </a>
                                                                        <?php
                                                                        if($item->tgl_diberikan == null){ ?>
                                                                        <a href class="text-danger delete_confirm"><i
                                                                                class="mdi mdi-delete font-size-18"></i></a>
                                                                        <?php
                                                                        }?>


                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tbody>
                                                    @endforeach

                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('inv_pinjaman.index') }}"
                                                    class="btn btn-secondary waves-effect">Kembali</a>
                                                <a class="btn btn-primary" type="submit" style="float: right"
                                                    id="submit">Simpan</a>
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

        <!-- modal -->
        <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Penyerahan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="dynamic-content-edit"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).on('click', '#get_data_edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // it will get id of clicked row
            $('#dynamic-content-edit').html(''); // leave it blank before ajax call
            $('#modal-loader').show(); // load ajax loader
            var url = "{{ route('inv_pinjaman.edit_barang') }}"
            $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id
                    }

                })
                .done(function(url1) {
                    $('#dynamic-content-edit').html(url1); // load response
                    $('#modal-loader').hide(); // hide ajax loader
                })
                .fail(function(err) {
                    $('#dynamic-content').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });
        });
    </script>
@endsection
