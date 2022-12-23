@extends('layouts.main')
@section('container')
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
                                        <label for="">Kode Transaksi <code>*</code></label>
                                        <input type="text" class="form-control" value="{{ $data[0]->kode_transaksi }}"
                                            disabled>
                                        <input type="hidden" class="form-control" id="kode_transaksi"
                                            value="{{ $data[0]->kode_transaksi }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="">User Input <code>*</code></label>
                                        <input type="text" class="form-control" value="{{ $data[0]->user->name }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Tanggal Input <code>*</code></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" disabled
                                                value="{{ $data[0]->created_at }}">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row gy-2 gx-3 align-items-center">
                                    <h5 class="card-title">Tambah Obat</h5>
                                    <div class="col-sm-auto col-md-3">
                                        <select class="form-control select select2 obat" id="obat_id">
                                            <option value="">--Pilih Obat--</option>
                                            @foreach ($obat as $item)
                                                <option value="{{ $item->id }}" data-id="{{ $item->obat }}">
                                                    {{ $item->obat . ' - [' . $item->jenis->jenis_obat . ']' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-auto col-md-3">
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" placeholder="Expired Date"
                                                id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"
                                                data-date-end-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                                                data-date-container='#datepicker2' data-provide="datepicker" required
                                                data-date-autoclose="true">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto col-md-3">
                                        <input type="text" class="form-control number-only" id="jml_obat"
                                            placeholder="Jumlah PCS">
                                    </div>
                                    <div class="col-sm-auto col-md-3">
                                        <a type="submit" class="btn btn-info w-md" id="add">Tambah Obat</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-responsive table-bordered table-striped" id="datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%">#</th>
                                                <th class="text-center" style="width: 20%">Obat</th>
                                                <th class="text-center" style="width: 10%">Jumlah Obat</th>
                                                <th class="text-center" style="width: 15%">Tanggal Opname</th>
                                                <th class="text-center" style="width: 5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $list)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $list->obat->obat . ' - ' . $list->obat->jenis->jenis_obat }}
                                                    </td>
                                                    <td class="text-center">{{ $list->jml }}</td>
                                                    <td class="text-center">{{ $list->tgl_opname }}</td>
                                                    <td class="text-center">
                                                        <?php $id = Crypt::encryptString($list->id . '|' . $list->kode_transaksi); ?>
                                                        <form class="delete-form"
                                                            action="{{ route('opname_obat.opname_destroy_id', $id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="d-flex gap-3">
                                                                <a href class="text-danger delete_confirm"><i
                                                                        class="mdi mdi-delete font-size-18"></i></a>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <a href="{{ route('opname_obat.index') }}"
                                        class="btn btn-secondary waves-effect">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#add").on('click', function() {
                // initialize header
                kode_transaksi = document.getElementById("kode_transaksi").value;
                obat_id = document.getElementById("obat_id").value;
                tanggal = document.getElementById("tanggal").value;
                jml_obat = document.getElementById("jml_obat").value;

                if (obat_id == '' || tanggal == '' || jml_obat == '') {
                    Swal.fire(
                        'Gagal',
                        'Obat dan Jumlah wajib diisi',
                        'error'
                    )
                } else {
                    let data_post = []
                    data_post.push({
                        obat_id,
                        tanggal,
                        jml_obat,
                    })

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('opname_obat.opname_store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            data_post,
                            kode_transaksi,
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    `${response.message}`,
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    window.location = APP_URL + '/uks/opname_obat/' +
                                        response.kode_transaksi +
                                        '/edit'
                                })
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    `${response.message}`,
                                    'error',
                                )
                            }
                        },
                        error: err => console.log("Interal Server Error")
                    })
                }
            })
        });
    </script>
@endsection
