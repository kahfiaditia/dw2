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
                <form id="form" class="needs-validation" action="{{ route('bursa_pembelian.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Permintaan <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_permintaan"
                                                        placeholder="Tgl" name="tgl_permintaan" id="tgl_permintaan"
                                                        value="" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Kedatangan <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_permintaan"
                                                        placeholder="Tgl" name="tgl_kedatangan" id="tgl_kedatangan"
                                                        value="" max="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_kedatangan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Nomor DO/SJ</label>
                                                <input type="text" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="nomor_do"
                                                    name="nomor_do" placeholder="Nomor" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('nomor_do', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Supplier <code>*</code></label>
                                                <select class="form-control select select2 supplier" name="supplier"
                                                    id="supplier" required>
                                                    <option value="">-- PILIH --</option>
                                                    @foreach ($supplier as $supplier)
                                                        <option value="{{ $supplier->id }}" data-id="{{ $supplier->nama }}">
                                                            {{ $supplier->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('supplier', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Ongkir</label>
                                                <input type="number" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="ongkir"
                                                    name="ongkir" placeholder="Rp" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('ongkir', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Potongan</label>
                                                <input type="number" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="potongan"
                                                    name="potongan" placeholder="Rp" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('potongan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Total Pembelian</label>
                                                <input type="number" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="total_nilai"
                                                    name="total_nilai" placeholder="Rp" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('total_nilai', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Pembayaran <code>*</code></label>
                                                <select class="form-control select select2 supplier"
                                                    name="status_pembayaran" id="status_pembayaran" required>
                                                    <option value="">-- PILIH --</option>
                                                    <option value="1"> LUNAS </option>
                                                    <option value="2"> BELUM LUNAS </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('status_pembayaran', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label class="form-label">Produk <code>*</code></label>
                                                <select class="form-control select select2 produk" name="produk"
                                                    id="produk" required>
                                                    <option value="">-- PILIH --</option>
                                                    @foreach ($produk as $produk)
                                                        <option value="{{ $produk->id }}" data-id="{{ $produk->nama }}">
                                                            {{ $produk->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('produk', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label>Kadaluarsa <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_kadaluarsa"
                                                        placeholder="Tgl" name="tgl_kadaluarsa" id="tgl_kadaluarsa"
                                                        value="" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_permintaan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="harga_total_produk">Harga <code>*</code></label>
                                                <input type="text" class="form-control" onkeyup="hitungHargaPerUnit()"
                                                    oninput="this.value=this.value.toUpperCase()" id="harga_total_produk"
                                                    name="harga_total_produk" placeholder="Rp" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('harga_total_produk', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="total_kuantiti">Kuantiti <code>*</code></label>
                                                <input type="text" class="form-control" onkeyup="hitungHargaPerUnit()"
                                                    oninput="this.value = this.value.toUpperCase()" id="total_kuantiti"
                                                    name="total_kuantiti" placeholder="Jumlah" required />
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('total_kuantiti', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="harga_per_pcs">Harga Satuan</label>
                                                <input type="text" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="harga_per_pcs"
                                                    name="harga_per_pcs" placeholder="Rp" required disabled>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('harga_per_pcs', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label>Harga Jual <code>*</code></label>
                                                <input type="number" class="form-control" min="0" step="1000"
                                                    id="nilai_jual" name="nilai_jual" placeholder="Rp" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('nilai_jual', '<div class="invalid-validasi">:message</div>') !!}
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
                                                        <th class="text-center" style="width: 10%">Produk</th>
                                                        <th class="text-center" style="width: 10%">Kadaluarsa</th>
                                                        <th class="text-center" style="width: 10%">Harga</th>
                                                        <th class="text-center" style="width: 10%">Kuantiti</th>
                                                        <th class="text-center" style="width: 10%">Harga Satuan</th>
                                                        <th class="text-center" style="width: 10%">Harga Jual</th>
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
        function hitungHargaPerUnit() {
            const totalHarga = document.getElementById('harga_total_produk').value;
            const total_kuantiti = document.getElementById('total_kuantiti').value;
            const hargaPerUnitInput = document.getElementById('harga_per_pcs');

            if (totalHarga && total_kuantiti) {
                const hargaPerUnit = totalHarga / total_kuantiti;
                hargaPerUnitInput.value = hargaPerUnit;
            }
        }

        function tableBarang() {

            var tgl_permintaan = document.getElementById('tgl_permintaan').value;
            var tgl_kedatangan = document.getElementById('tgl_kedatangan').value;
            var nomor_do = document.getElementById('nomor_do').value;
            var supplier = document.getElementById('supplier').value;
            var ongkir = document.getElementById('ongkir').value;
            var potongan = document.getElementById('potongan').value;
            var total_nilai = document.getElementById('total_nilai').value;
            console.log(total_nilai);
            var status_pembayaran = document.getElementById('status_pembayaran').value;
            var produk = document.getElementById('produk').value;
            console.log(produk);
            var tgl_permintaan = document.getElementById('tgl_permintaan').value;
            var tgl_kadaluarsa = document.getElementById('tgl_kadaluarsa').value;
            var harga_total_produk = document.getElementById('harga_total_produk').value;
            var total_kuantiti = document.getElementById('total_kuantiti').value;
            console.log(total_kuantiti);
            var harga_per_pcs = document.getElementById('harga_per_pcs').value;
            var nilai_jual = document.getElementById('nilai_jual').value;

            tgl_permintaan_value = $('#tgl_permintaan option:selected').data('id');
            tgl_kedatangan_value = $('#tgl_kedatangan option:selected').data('id');
            supplier_value = $('#supplier option:selected').data('id');
            status_pembayaran_value = $('#status_pembayaran option:selected').data('id');

            tgl_kadaluarsa_value = $('#tgl_kedatangan option:selected').data('id');

            document.getElementById('tgl_kadaluarsa').value = '';
            document.getElementById('harga_total_produk').value = '';
            document.getElementById('total_kuantiti').value = '';
            document.getElementById('harga_per_pcs').value = '';
            document.getElementById('nilai_jual').value = '';

            // ruang_value = $('#ruang option:selected').data('id');

            if (produk == '' || tgl_kadaluarsa == '' || harga_total_produk == '' || total_kuantiti == '' || harga_per_pcs ==
                '' ||
                nilai_jual == '' || tgl_permintaan == '' || tgl_kedatangan == '' || supplier == '' || status_pembayaran ==
                '') {
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
                var cekGabungan = String(produk);
                isVal = cekArr.includes(cekGabungan)

                // NO
                var cekGabunganNo = String(produk);
                isValNo = cekArrNo.includes(cekGabunganNo)


                // cek salah satu validasi
                if (isVal == true || isValNo == true) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Produk Sudah ada',
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
                            <td hidden>${tgl_permintaan}</td>
                            <td hidden>${tgl_kedatangan}</td>
                            <td hidden>${nomor_do}</td>
                            <td hidden>${supplier}</td>
                            <td hidden>${ongkir}</td>
                            <td hidden>${potongan}</td>
                            <td hidden>${total_nilai}</td>
                            <td hidden>${status_pembayaran}</td>
                            <td class="text-left">${produk}</td>
                            <td class="text-left">${tgl_kadaluarsa}</td>
                            <td class="text-left">${harga_total_produk}</td>
                            <td class="text-left">${total_kuantiti}</td>
                            <td class="text-left">${harga_per_pcs}</td>
                            <td class="text-left">${nilai_jual}</td>   
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
                let datapembelian = []

                $("#tableBarang").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        tgl_permintaan = tableData.eq(0).text(),
                        tgl_kedatangan = tableData.eq(1).text(),
                        nomor_do = tableData.eq(2).text(),
                        supplier = tableData.eq(3).text(),
                        ongkir = tableData.eq(4).text(),
                        potongan = tableData.eq(5).text(),
                        total_nilai = tableData.eq(6).text(),
                        status_pembayaran = tableData.eq(7).text(),
                        produk = tableData.eq(8).text(),
                        tgl_kadaluarsa = tableData.eq(9).text(),
                        harga_total_produk = tableData.eq(10).text(),
                        total_kuantiti = tableData.eq(11).text(),
                        harga_per_pcs = tableData.eq(12).text(),
                        nilai_jual = tableData.eq(13).text()

                    //ini filter data null
                    if (produk != '') {
                        datapembelian.push({
                            tgl_permintaan,
                            tgl_kedatangan,
                            nomor_do,
                            supplier,
                            ongkir,
                            potongan,
                            total_nilai,
                            status_pembayaran,
                            produk,
                            tgl_kadaluarsa,
                            harga_total_produk,
                            total_kuantiti,
                            harga_per_pcs,
                            nilai_jual
                        });
                    }
                })

                jQuery.ajax({
                    type: "POST",
                    url: '{{ route('bursa_pembelian.store') }}',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        datapembelian
                    },
                    success: (response) => {
                        // console.log(response);
                        if (response.code === 200) {

                            Swal.fire(
                                'Success',
                                'Data Pembelian Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/bursa/bursa_pembelian'
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
                window.location = APP_URL + '/bursa/bursa_pembelian'
            })
        })
    </script>
@endsection
