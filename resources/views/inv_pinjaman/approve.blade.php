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
                <form id="form" class="needs-validation" action="{{ route('inv_pinjaman.approveProses') }}"
                    method="POST">
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
                                                <input type="disable" class="form-control" name="peminjam1" id="peminjam1"
                                                    value="{{ $data_pinjaman[0]->users->name }}" readonly>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_peminjam" name="nama_peminjam" value="">
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
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
                                                <div class="input-group" id="datepicker2">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->tgl_pemakaian }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Rencana Pengembalian <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $data_pinjaman[0]->estimasi_kembali }}" readonly>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-responsive table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 5%">No</th>
                                                            <th class="text-center" style="width: 20%">Nama Barang
                                                            </th>
                                                            <th class="text-center" style="width: 15%">No Inv</th>
                                                            <th class="text-center" style="width: 15%">ID Barang</th>
                                                            <th class="text-center" style="width: 15%">Tangal diberikan</th>
                                                            <th class="text-center" style="width: 15%">Kondisi</th>
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
                                                                {{ $item->barang->idbarang }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->barang->idbarang }}</td>
                                                            <td class="text-center">
                                                                <?php $id = Crypt::encryptString($item->id); ?>
                                                                <form class="delete-form"
                                                                    action="{{ route('pinjaman.destroy_id', $id) }}"
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
                                                                        <a href class="text-danger delete_confirm"><i
                                                                                class="mdi mdi-delete font-size-18"></i></a>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tbody>
                                                    @endforeach

                                                </table>
                                            </div>
                                        </div>

                                        {{-- <div class="card-body">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 wajib">
                                                        <div class="mb-3">
                                                            <label>Tanggal Diberikan <code>*</code></label>
                                                            <div class="input-group" id="datepicker3">
                                                                <input type="text" class="form-control tgl_diberikan"
                                                                    placeholder="yyyy-mm-dd" name="tgl_diberikan"
                                                                    id="tgl_diberikan" value="{{ date('Y-m-d') }}"
                                                                    data-date-format="yyyy-mm-dd"
                                                                    data-date-container='#datepicker3'
                                                                    data-provide="datepicker" required
                                                                    data-date-autoclose="true">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 wajib">
                                                        <div class="mb-3">
                                                            <label>Kondisi1 <code>*</code></label>
                                                            <select class="form-control select select2 kondisi"
                                                                name="kondisi" id="kondisi" required>
                                                                <option value="">-- Kondisi --</option>
                                                                <option value="Baik"> Baik </option>
                                                                <option value="Lecet"> Lecet </option>
                                                                <option value="Rusak"> Rusak </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 wajib">
                                                        <div class="col-mb-2 mt-4">
                                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                                onclick="tableProses()">Tambah
                                                                Peminjaman</a>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-responsive table-bordered table-striped"
                                                        id="tableProses">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 15%">Kondisi</th>
                                                                <th class="text-center" style="width: 15%">Tanggal</th>
                                                                <th class="text-center" style="width: 15%">Aksi</th>
                                                                <th class="text-center" hidden>{{ Auth::user()->id }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a class="btn btn-secondary" type="submit" id="batal">Batal</a>
                                                    <a class="btn btn-primary" type="submit" style="float: right"
                                                        id="save">Simpan</a>
                                                </div>
                                            </div>

                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <br>
            </div>
        </div>
        <!-- modal -->
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Edit</h5>
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
        function tableProses() {
            var tgl_diberikan = document.getElementById('tgl_diberikan').value;
            var kondisi = document.getElementById('kondisi').value;

            document.getElementById("tgl_diberikan").onclick = '';
            document.getElementById('kondisi').value = '';

            console.log(tgl_diberikan)
            console.log(kondisi)

            if (tgl_diberikan == '' || kondisi == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1900,
                })
            } else {
                $("#tableProses tr:last").after(`
                        <tr>
                            <td class="text-left">${tgl_diberikan}</td>
                            <td class="text-left">${kondisi}</td>                  
                            <td>
                                <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                            </td>
                        </tr>
                    `)
            }
        }

        $(document).on('click', '#get_data_edit', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id'); // it will get id of clicked row
                    $('#
                        ').html('
                        '); // leave it blank before ajax call
                        $('#modal-loader').show(); // load ajax loader
                        var url = "{{ route('pinjaman.edit_buku') }}"
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id
                            }
                        })
                        .done(function(url) {
                            $('#dynamic-content-edit').html(url); // load response
                            $('#modal-loader').hide(); // hide ajax loader
                        })
                        .fail(function(err) {
                            $('#dynamic-content').html(
                                '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                            );
                            $('#modal-loader').hide();
                        });
                    });

                $("#save").on('click', function() {
                    let dataproses = []
                    $("#tableProses").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td'),
                            tgl_diberikan = tableData.eq(0).text(),
                            kondisi = tableData.eq(1).text()

                        //ini filter data null
                        if (nama_barang != '') {
                            datapinjam.push({
                                tgl_diberikan,
                                kondisi
                            });
                            console.log(dataproses)
                        }
                    })
                    jQuery.ajax({
                        type: "POST",
                        url: '{{ route('inv_pinjaman.approveProses') }}',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            dataproses
                        },
                        success: (response) => {
                            console.log(response)
                            if (response.code === 200) {

                                Swal.fire(
                                    'Success',
                                    'Pinjaman Berhasil di masukan',
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    window.location = APP_URL + '/inv_pinjaman'
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terdapat dua barang yang sama',
                                    showConfirmButton: false,
                                    timer: 1500,
                                })
                            }
                        },
                        error: err => console.log(err)
                    });

                });
    </script>
@endsection
