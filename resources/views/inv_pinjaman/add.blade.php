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
                <form id="form" class="needs-validation" action="{{ route('inventaris.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 peminjam">
                                            <div class="mb-3">
                                                <label>Peminjam <code>*</code></label>
                                                <input type="disable" class="form-control" name="peminjam1" id="peminjam1"
                                                    value="{{ Auth::user()->name }}" readonly>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <input type="hidden" id="nama_peminjam" name="nama_peminjam"
                                            value="{{ Auth::user()->id }}">
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_permintaan"
                                                        placeholder="yyyy-mm-dd" name="tgl_permintaan" id="tgl_permintaan"
                                                        value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true" disabled>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Tanggal Pemakaian <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pemakaian"
                                                        placeholder="yyyy-mm-dd" name="tgl_pemakaian" id="tgl_pemakaian"
                                                        value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_pemakaian', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Rencana Pengembalian <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="text" class="form-control tgl_renc_pengembalian"
                                                        placeholder="yyyy-mm-dd" name="tgl_renc_pengembalian"
                                                        id="tgl_renc_pengembalian" value="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker3'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_renc_pengembalian', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row wajib">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Inventaris <code>*</code></label>
                                                <select class="form-control select select2 nama_barang" name="nama_barang"
                                                    id="nama_barang" required>
                                                    <option value="" required>--Pilih Barang--</option>
                                                    @foreach ($inventaris as $inv)
                                                        <option value="{{ $inv->id }}">
                                                            {{ $inv->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('nama_barang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea type="text" class="form-control" style="text-transform:uppercase" id="desc" name="desc"
                                                    placeholder="Alasan Peminjaman" style="text-transform:uppercase" required></textarea>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-mb-2">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="tablePinjam()">Tambah
                                                Peminjaman</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tablePinjam">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">Peminjam</th>
                                                        <th class="text-center" style="width: 10%">Tanggal Pemakaian</th>
                                                        <th class="text-center" style="width: 10%">Tanggal Permintaan</th>
                                                        <th class="text-center" style="width: 10%">Rencana Pengembalian
                                                        </th>
                                                        <th class="text-center" style="width: 10%">Nama Barang</th>
                                                        <th class="text-center" style="width: 10%">Keterangan</th>
                                                        <th class="text-center" style="width: 10%">Aksi</th>
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

                                </div>
                            </div>
                        </div>
                </form>
                <br>
            </div>
        </div>
    </body>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        function tablePinjam() {
            var nama_peminjam = document.getElementById('nama_peminjam').value;
            var tgl_pemakaian = document.getElementById('tgl_pemakaian').value;
            var tgl_permintaan = document.getElementById('tgl_permintaan').value;
            var tgl_renc_pengembalian = document.getElementById('tgl_renc_pengembalian').value;
            var nama_barang = document.getElementById('nama_barang').value;
            var desc = document.getElementById('desc').value;

            document.getElementById("nama_barang").onclick = '';
            document.getElementById('desc').value = '';
            document.getElementById('nama_barang').value = '';

            console.log(nama_peminjam)
            console.log(tgl_pemakaian)
            console.log(tgl_permintaan)
            console.log(tgl_renc_pengembalian)
            console.log(nama_barang)
            console.log(desc)


            if (nama_barang == '' || desc == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1900,
                })
            } else if (tgl_pemakaian > tgl_renc_pengembalian) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Pengembalian harus sama atau lebih besar atau \n sama dengan pemaikaian',
                    showConfirmButton: false,
                    timer: 1500,
                })

            } else {
                $("#tablePinjam tr:last").after(`
                        <tr>
                            <td class="text-left">${nama_peminjam}</td>
                            <td class="text-left">${tgl_pemakaian}</td>
                            <td class="text-left">${tgl_permintaan}</td>
                            <td class="text-left">${tgl_renc_pengembalian}</td>
                            <td class="text-left">${nama_barang}</td>
                            <td class="text-left">${desc}</td>                  
                            <td>
                                <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                            </td>
                        </tr>
                    `)
            }
        }

        $("#save").on('click', function() {
            let datapinjam = []
            $("#tablePinjam").find("tr").each(function(index, element) {
                let tableData = $(this).find('td'),
                    nama_peminjam = tableData.eq(0).text(),
                    tgl_pemakaian = tableData.eq(1).text(),
                    tgl_permintaan = tableData.eq(2).text(),
                    tgl_renc_pengembalian = tableData.eq(3).text(),
                    nama_barang = tableData.eq(4).text(),
                    desc = tableData.eq(5).text()

                //ini filter data null
                if (nama_barang != '') {
                    datapinjam.push({
                        nama_peminjam,
                        tgl_pemakaian,
                        tgl_permintaan,
                        tgl_renc_pengembalian,
                        nama_barang,
                        desc
                    });
                    console.log(datapinjam)
                }
            })
            jQuery.ajax({
                type: "POST",
                url: '{{ route('inv_pinjaman.store') }}',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    datapinjam
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

        //fungsi hapus
        $("#tablePinjam").on('click', '.delete-record', function() {
            $(this).parent().parent().remove()
        })


        $("#batal").on('click', function() {
            // hapus localStorage
            var APP_URL = {!! json_encode(url('/')) !!}
            window.location = APP_URL + '/inv_pinjaman'
        })
    </script>
@endsection
