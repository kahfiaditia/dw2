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
                <form id="form" class="needs-validation" action="{{ route('bursa_produk.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Nama Produk <code>*</code></label>
                                                <input type="text" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="nama"
                                                    name="nama" placeholder="NAMA PRODUK" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Deskripsi</label>
                                                <textarea type="text" class="form-control" style="text-transform:uppercase" id="desc" placeholder="Deskripsi"
                                                    style="text-transform:uppercase" required></textarea>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Barcode <code></code></label>
                                                <input type="number" class="form-control" id="barcode"
                                                    placeholder="BARCODE" oninput="this.value = this.value.toUpperCase()"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Satuan <code>*</code></label>
                                                <select class="form-control select select2 satuan" name="satuan"
                                                    id="satuan" required>
                                                    <option value="">--PILIH SATUAN--</option>
                                                    @foreach ($satuan as $satuan)
                                                        <option value="{{ $satuan->id }}" data-id="{{ $satuan->nama }}">
                                                            {{ $satuan->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('satuan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Kategori <code>*</code></label>
                                                <select class="form-control select select2 kategori" name="kategori"
                                                    id="kategori" required>
                                                    <option value="" required>--PILIH KATEGORI--</option>
                                                    @foreach ($kategori as $kategori)
                                                        <option value="{{ $kategori->id }}" data-id="{{ $kategori->nama }}">
                                                            {{ $kategori->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('kategori', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-mb-2">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="tableBarang()">Tambah
                                                Produk</a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="inputArray">
                                    <input type="hidden" id="inputArrayNoID">
                                    <input type="hidden" id="inputArrayNo">
                                    <input type="hidden" id="inputArrayID">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tableBarang">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">Nama</th>
                                                        <th class="text-center" style="width: 10%">Barcode</th>
                                                        <th class="text-center" style="width: 10%">Deskripsi</th>
                                                        <th class="text-center" style="width: 10%">Satuan</th>
                                                        <th class="text-center" style="width: 10%">Kategori</th>
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
                                            <a class="btn btn-secondary" type="submit" id="batal">Batal</a>
                                            <a class="btn btn-primary" type="submit" style="float: right"
                                                id="save">Simpan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        function tableBarang() {
            var satuan = document.getElementById('satuan').value;
            var kategori = document.getElementById('kategori').value;
            var nama = document.getElementById('nama').value;
            var hasilnama = nama.toUpperCase();
            var barcode = document.getElementById('barcode').value;
            var hasilbarcode = barcode.toUpperCase();
            var desc = document.getElementById('desc').value;
            var hasildesc = desc.toUpperCase();
            kategori_value = $('#kategori option:selected').data('id');
            satuan_value = $('#satuan option:selected').data('id');


            document.getElementById('nama').value = '';
            document.getElementById('barcode').value = '';
            document.getElementById('desc').value = '';


            if (satuan == '' || kategori == '' || nama == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                // set array awal
                // Nama Barang + NO + ID
                var inputArray = document.getElementById('inputArray').value;
                if (inputArray == '') {
                    var cekArr = [];
                } else {
                    var cekArr = [];
                    strArray = inputArray.split(",");
                    for (var i = 0; i < strArray.length; i++) {
                        cekArr.push(strArray[i]);
                    }
                    var cekArr = cekArr;
                }

                // NO + ID
                var inputArrayNoID = document.getElementById('inputArrayNoID').value;
                if (inputArrayNoID == '') {
                    var cekArrNoID = [];
                } else {
                    var cekArrNoID = [];
                    strArray = inputArrayNoID.split(",");
                    for (var i = 0; i < strArray.length; i++) {
                        cekArrNoID.push(strArray[i]);
                    }
                    var cekArrNoID = cekArrNoID;
                }

                // NO 
                var inputArrayNo = document.getElementById('inputArrayNo').value;
                if (inputArrayNo == '') {
                    var cekArrNo = [];
                } else {
                    var cekArrNo = [];
                    strArray = inputArrayNo.split(",");
                    for (var i = 0; i < strArray.length; i++) {
                        cekArrNo.push(strArray[i]);
                    }
                    var cekArrNo = cekArrNo;
                }

                // ID
                var inputArrayID = document.getElementById('inputArrayID').value;
                if (inputArrayID == '') {
                    var cekArrID = [];
                } else {
                    var cekArrID = [];
                    strArray = inputArrayID.split(",");
                    for (var i = 0; i < strArray.length; i++) {
                        cekArrID.push(strArray[i]);
                    }
                    var cekArrID = cekArrID;
                }

                // cek inputan
                // Nama Barang + NO + ID
                var cekGabungan = String(hasilnama + satuan + kategori);
                isVal = cekArr.includes(cekGabungan)

                // NO
                var cekGabunganNo = String(hasilbarcode);
                isValNo = cekArrNo.includes(cekGabunganNo)


                // cek salah satu validasi
                if (isVal == true || isValNo == true) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Barcode Sudah ada',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                } else {
                    // push ke array
                    cekArr.push(cekGabungan);
                    cekArrNoID.push(cekGabunganNo);

                    // set inputan ke form
                    document.getElementById('inputArray').value = cekArr;
                    document.getElementById('inputArrayNo').value = cekArrNo;


                    $("#tableBarang tr:last").after(`
                        <tr>
                            <td class="text-left">${hasilnama}</td>
                            <td class="text-left">${hasilbarcode}</td>
                            <td class="text-left">${hasildesc}</td>
                            <td hidden>${satuan}</td> 
                            <td hidden>${kategori}</td>  
                            <td class="text-left">${satuan_value}</td>
                            <td class="text-left">${kategori_value}</td>     
                            <td>
                                <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                            </td>
                              
                        </tr>
                    `)

                    // document.getElementById('no_inv').value = '';
                    // document.getElementById('idbarang').value = '';
                    // document.getElementById('indikasi').value = '';
                }
            }
        }


        $(document).ready(function() {
            //fungsi hapus
            $("#tableBarang").on('click', '.delete-record', function() {
                $(this).parent().parent().remove()
            })

            $("#save").on('click', function() {
                let databarang = []

                $("#tableBarang").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        hasilnama = tableData.eq(0).text(),
                        hasilbarcode = tableData.eq(1).text(),
                        hasildesc = tableData.eq(2).text(),
                        satuan = tableData.eq(3).text(),
                        kategori = tableData.eq(4).text()


                    //ini filter data null
                    if (hasilnama != '') {
                        databarang.push({
                            hasilnama,
                            hasilbarcode,
                            hasildesc,
                            satuan,
                            kategori

                        });
                    }
                })

                jQuery.ajax({
                    type: "POST",
                    url: '{{ route('bursa_produk.store') }}',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        databarang
                    },
                    success: (response) => {
                        // console.log(response)
                        if (response.code === 200) {

                            Swal.fire(
                                'Success',
                                'Data Produk Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/bursa/bursa_produk'
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanda * (bintang) wajib diisi',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }
                    },
                    error: err => console.log(err)
                });
            });

            $("#batal").on('click', function() {
                var APP_URL = {!! json_encode(url('/')) !!}
                window.location = APP_URL + '/bursa/bursa_produk'
            })
        })
    </script>
@endsection
