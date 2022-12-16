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
                                    <h5 class="card-title">Tambah Obat</h5>
                                    <div class="col-sm-auto col-md-2">
                                        <select class="form-control select select2 obat" id="obat_id">
                                            <option value="">--Pilih Obat--</option>
                                            @foreach ($obat as $item)
                                                <option value="{{ $item->id }}" data-id="{{ $item->obat }}">
                                                    {{ $item->obat . ' - [' . $item->jenis->jenis_obat . ']' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-auto col-md-2">
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" placeholder="Expired Date"
                                                id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                data-provide="datepicker" required data-date-autoclose="true">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto col-md-2">
                                        <input type="text" class="form-control number-only" id="jml_obat"
                                            placeholder="Jumlah PCS">
                                    </div>
                                    <div class="col-sm-auto col-md-2">
                                        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                    </div>
                                    <div class="col-sm-auto col-md-2">
                                        <a type="submit" class="btn btn-info w-md" id="add">Tambah Obat</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-responsive table-bordered table-striped" id="table_pinjaman">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%">#</th>
                                                <th class="text-center" style="width: 20%">Obat</th>
                                                <th class="text-center" style="width: 20%">Tanggal Kadaluarsa</th>
                                                <th class="text-center" style="width: 20%">Jumlah Obat</th>
                                                <th class="text-center" style="width: 25%">Keterangan</th>
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
                                    <a href="{{ route('obat.index') }}" class="btn btn-secondary waves-effect">Batal</a>
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

                // initialize header
                obat_id = document.getElementById("obat_id").value;
                tanggal = document.getElementById("tanggal").value;
                jml_obat = document.getElementById("jml_obat").value;
                keterangan = document.getElementById("keterangan").value;
                obat = $('#obat_id option:selected').data('id');

                if (obat_id == '' || tanggal == '' || jml_obat == '') {
                    Swal.fire(
                        'Gagal',
                        'Obat, Expired Date dan Jumlah wajib diisi',
                        'error'
                    )
                } else {
                    $("#table_pinjaman tr:last").after(`
                        <tr>
                            <td class="text-center">${increment}</td>   
                            <td class="">${obat}</td>    
                            <td class="">${tanggal}</td>    
                            <td class="text-center">${jml_obat}</td>
                            <td class="">${keterangan}</td>
                            <td class="text-center">
                                <a class="btn btn-danger btn-sm deleteItems" id="deleteItems">Delete</a>    
                                </td>
                            <td class="text-center" hidden>${obat_id}</td>
                        </tr>
                    `)

                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td')
                        tableData.eq(0).text(index)
                    })

                    // null items
                    $('#obat_id').val("").trigger('change')
                    $('#tanggal').val("")
                    $('#jml_obat').val("")
                    $('#keterangan').val("")
                }

                $(".deleteItems").on('click', function() {
                    $(this).parent().parent().remove()

                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td')
                        tableData.eq(0).text(index)
                    })

                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td'),
                            obat = tableData.eq(1).text(),
                            tanggal = tableData.eq(2).text(),
                            keterangan = tableData.eq(3).text(),
                            obat_id = tableData.eq(4).text()

                        tableData.eq(0).text(index)
                    })
                })
            })

            $("#save").on('click', function() {
                let datas = []
                $("#table_pinjaman").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        tanggal = tableData.eq(2).text(),
                        jumlah = tableData.eq(3).text(),
                        keterangan = tableData.eq(4).text(),
                        id_obat = tableData.eq(6).text()

                    datas.push({
                        id_obat,
                        tanggal,
                        jumlah,
                        keterangan
                    })
                })
                let data_post = datas.filter(data => data.id_obat !== "")

                $.ajax({
                    type: 'POST',
                    url: '{{ route('stok_obat.store') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        data_post,
                    },
                    success: (response) => {
                        if (response.code === 200) {
                            Swal.fire(
                                'Success',
                                `${response.message}`,
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/uks/stok_obat'
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
        });
    </script>
@endsection
