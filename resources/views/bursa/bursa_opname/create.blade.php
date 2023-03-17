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
                                <div class="row gy-2 gx-3 align-items-center">
                                    <h5 class="card-title">Tambah Opname Produk</h5>
                                    <div class="col-sm-auto col-md-3">
                                        <select class="form-control select select2 produk_id" id="produk_id">
                                            <option value="">-- Pilih Produk--</option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id }}" data-id="{{ $item->nama }}">
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-auto col-md-3">
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" placeholder="Tanggal Opname"
                                                id="tanggal23" name="tanggal" value="{{ date('Y-m-d') }}"
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
                                        <input type="text" class="form-control number-only" id="jumlah23"
                                            placeholder="Jumlah">
                                    </div>
                                    <div class="col-sm-auto col-md-3">
                                        <a type="submit" class="btn btn-info w-md" id="add">Tambah Stok Opname</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-responsive table-bordered table-striped" id="table_opname">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%">#</th>
                                                <th class="text-center" style="width: 20%">Produk</th>
                                                <th class="text-center" style="width: 20%">Tanggal</th>
                                                <th class="text-center" style="width: 20%">Jumlah Fisik</th>
                                                <th class="text-center" style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <a href="{{ route('bursa_opname.index') }}"
                                        class="btn btn-secondary waves-effect">Batal</a>
                                    <button class="btn btn-primary" type="submit" style="float: right"
                                        id="save">Simpan</button>
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
            let increment = 0;

            $("#add").on('click', function() {
                increment++;

                var produk_id = document.getElementById('produk_id').value;
                produk_nama = $('#produk_id option:selected').data('id');
                var tanggal = document.getElementById('tanggal23').value;
                var jumlah = document.getElementById('jumlah23').value;

                document.getElementById('produk_id').value = '';
                document.getElementById('jumlah23').value = '';

                $('#produk_id').val("").trigger('change')
                $('#jumlah23').val("")

                if (produk_id == '' || tanggal == '' || jumlah == '') {
                    Swal.fire(
                        'Gagal',
                        'Produk dan Jumlah Wajib Diisi',
                        'Error'
                    )
                } else {
                    $("#table_opname tr:last").after(`
                                <tr>
                                    <td class="text-center">${increment}</td>   
                                    <td class="text-center">${produk_nama}</td>    
                                    <td class="text-center">${tanggal}</td>    
                                    <td class="text-center">${jumlah}</td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-sm deleteItems" id="deleteItems">Delete</a>    
                                    </td>
                                    <td class="text-center" hidden>${produk_id}</td>
                                </tr>
                    `)

                    //delete
                    $(".deleteItems").on('click', function() {
                        $(this).parent().parent().remove()

                        // looping no
                        $("#table_opname").find("tr").each(function(index, element) {
                            let tableData = $(this).find('td')
                            tableData.eq(0).text(index)
                        })
                    })
                }

                $("#save").on('click', function() {
                    let produk_opname = []

                    $("#table_opname").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td'),
                            tanggal = tableData.eq(1).text(),
                            jumlah = tableData.eq(2).text(),
                            produk_id = tableData.eq(3).text()

                        produk_opname.push({
                            tanggal,
                            jumlah,
                            produk_id,
                        })
                    })
                    let data_opname = produk_opname.filter(data => data.produk_id !== "")

                    $.ajax({
                        tipe: 'POST',
                        url: '{{ route('bursa_opname.store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            data_opname,
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    `${response.message}`,
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    window.location = APP_URL +
                                        '/bursa/bursa_opname'
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
                })
            })
        });
    </script>
@endsection
