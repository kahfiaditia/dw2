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
                <form id="form" class="needs-validation" action="{{ route('bursa_pembelian.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    id="accordion-button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    <i class="bx bx-search-alt font-size-18"></i>
                                                    <b>Barcode</b>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body barcodeScanner">
                                                    <div class="row text-muted">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4 text-center">
                                                            <label class="form-label">Metode Scan</label>
                                                            <div class="mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input radio" type="radio"
                                                                        name="toggle" id="inlineRadio1" value="Barcode">
                                                                    <label class="form-check-label"
                                                                        for="inlineRadio1">Barcode</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input radio" type="radio"
                                                                        name="toggle" id="inlineRadio2"
                                                                        value="Scan Kamera">
                                                                    <label class="form-check-label" for="inlineRadio2">Scan
                                                                        Kamera</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row text-muted div_barcode">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4">
                                                            <input type="text" name="scanner_barcode" autofocus
                                                                class="form-control scanner_barcode" id="scanner_barcode"
                                                                placeholder="Barcode">
                                                        </div>
                                                    </div>
                                                    <div class="row text-muted div_scan_camera">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4">
                                                            <div id="qr-reader"></div>
                                                            <div id="qr-reader-results"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Pilih
                                                        produk</label>
                                                    <select id="produk" class="form-control select select2 produk"
                                                        name="produk" id="produk" required>
                                                        <option value="" selected>-- Pilih Produk --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Barcode
                                                    </label>
                                                    <input type="text" class="form-control" id="barcode1"
                                                        name="barcode1" placeholder="Barcode" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Stok
                                                        produk</label>
                                                    <input type="text" class="form-control" id="stok" name="stok"
                                                        placeholder="Stok" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="formrow-inputState" class="form-label">Harga Jual</label>
                                                    <input type="text" class="form-control"
                                                        onkeyup="hitungTotalHargaProduk()" id="nilai_jual"
                                                        name="nilai_jual" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="formrow-inputZip" class="form-label">Jumlah</label>
                                                    <input type="number" min="1" class="form-control"
                                                        onkeyup="hitungTotalHargaProduk()" id="qty" name="qty">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="formrow-inputZip" class="form-label">Total</label>
                                                    <input type="text" class="form-control" id="total1"
                                                        name="total1" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 invisible">
                                                <div class="mb-3">
                                                    <label for="formrow-inputZip" class="form-label">Modal</label>
                                                    <input type="text" class="form-control"
                                                        onkeyup="hitungTotalHargaProduk()" id="nilai_per_pcs"
                                                        name="nilai_per_pcs" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <a type="submit" id="button" class="btn btn-info w-md"
                                                    onclick="tambahBarang()">Tambah
                                                    Produk</a>
                                            </div>
                                            <div class="col-lg-3 invisible">
                                                <div class="mb-3">
                                                    <label for="formrow-inputState" class="form-label">Total
                                                        Modal</label>
                                                    <input type="text" class="form-control" id="total_modal"
                                                        name="total_modal" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 invisible">
                                                <div class="mb-3">
                                                    <label for="formrow-inputZip" class="form-label">Total
                                                        Margin</label>
                                                    <input type="number" class="form-control" id="margin"
                                                        name="margin" disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="invisible">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="tambahBarang()">Tambah
                                                Produk</a>
                                        </div>
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-1">Daftar Belanja</h4>
                                    <form>
                                        <div class="row">
                                            <div class="row mt-4">
                                                <div class="col-lg-6 jenjang_siswa">
                                                    <div class="mb-3">
                                                        <label for="formrow-firstname-input" class="form-label">
                                                            Pembeli</label>
                                                        <select class="form-control select select2 classes" name="jenjang"
                                                            id="jenjang" required>
                                                            <option value="" required>--Pilih Pembeli--</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('jenjang', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Siswa <code>*</code></label>
                                                        <select class="form-control select select2 siswa" name="siswa"
                                                            id="siswa" required>
                                                            <option value="" required>--Pilih Siswa--</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('siswa', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-responsive table-bordered table-striped"
                                                    id="grandTotal">
                                                    <tbody>
                                                        <tr>
                                                            <th class="text-right" style="float: right"><span
                                                                    id="val">Total</span></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-responsive table-bordered table-striped"
                                                    id="tambahBarang">
                                                    <tbody>
                                                        <tr>
                                                            <th class="text-center" style="width: 10%">Produk</th>
                                                            <th class="text-center" style="width: 10%">Qty</th>
                                                            <th class="text-center" style="width: 10%">Harga</th>
                                                            <th class="text-center" style="width: 10%">Sub Total</th>
                                                            <th class="text-center" style="width: 10%">Aksi</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">
                                                        Jenis Pembayaran</label>
                                                    <select id="jenis_pembayaran" name="jenis_pembayaran"
                                                        class="form-control select select2 jenis_pembayaran" required>
                                                        <option value="1" selected> Cash / Tunai</option>
                                                        <option value="2"> Transfer</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">
                                                        Catatan</label>
                                                    <textarea type="text" class="form-control" name="keterangan1" id="keterangan1" placeholder="Keterangan"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div>
                                                    <a class="btn btn-danger" type="submit" id="batal"
                                                        style="float: left">Reset</a>
                                                    <a class="btn btn-primary" type="submit" style="float: right"
                                                        id="save">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script src="{{ asset('assets/scanner/html5-qrcode.min.js') }}"></script>
    <script>
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                barcode = decodedText;

                // get value database 
                getValueScanBarcodeCamera(barcode, 'Siswa')
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

        function myLoad() {
            // area scanner dan barcode
            $('.div_scan_camera').hide();
            $('.div_barcode').hide();

            collapseOne.classList.remove("show");
        }

        function hitungTotalHargaProduk() {
            const harga_produk = document.getElementById('nilai_jual').value;
            const harga_modal = document.getElementById('nilai_per_pcs').value;
            const kuantiti = document.getElementById('qty').value;
            const hargaTotalInput = document.getElementById('total1');
            const hargaTotalModal = document.getElementById('total_modal');
            const nilaiTotalMargin = document.getElementById('margin');


            if (harga_produk && kuantiti) {
                const HargaProduk = harga_produk * kuantiti;
                hargaTotalInput.value = HargaProduk;

                if (harga_modal) {
                    const HargaModal = harga_modal * kuantiti;
                    hargaTotalModal.value = HargaModal;

                    const margin = HargaProduk - HargaModal;
                    nilaiTotalMargin.value = margin;
                }
            }

        }

        function getValueScanBarcodeCamera(barcode, pembeli) {
            $.ajax({
                type: "POST",
                url: '{{ route('bursa_penjualan.scanBarcode') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    barcode,
                    pembeli
                },
                success: response => {
                    // initialize header
                    if (response.type == 'Siswa') {
                        siswa = response.id;
                        jenjang = response.jenjang;

                        var dataPerpus = {
                            "header": {
                                "jenjang": jenjang,
                                "siswa": siswa,
                            }
                        };
                        localStorage.setItem('localPenjualanPelanggan', JSON.stringify(dataPerpus));
                        location.reload();
                    } else if (response.type == 'produk') {
                        console.log(response)
                        id = response.id;
                        produk_value = response.jenjang;
                        qty = 1;
                        nilai_jual = response.harga_jual;
                        modal = response.harga_beli;
                        total = nilai_jual * qty;
                        margin = nilai_jual - modal;
                        sub_modal = (total - margin) / qty;

                        var jenis_pembayaran = document.getElementById('jenis_pembayaran').value;
                        var siswa = document.getElementById('siswa').value;
                        var keterangan1 = document.getElementById('keterangan1').value;

                        $("#tambahBarang tr:last").after(`
                            <tr>
                                <td class="text-center">${produk_value}</td>
                                <td class="text-center">${qty}</td>
                                <td class="text-center">${nilai_jual}</td>
                                <td class="text-center">${total}</td>
                                <td class="text-left" hidden>${id}</td>
                                <td class="text-left" hidden>${modal}</td>
                                <td class="text-left" hidden>${sub_modal}</td>
                                <td class="text-left" hidden>${margin}</td>
                                <td class="text-left" hidden>${jenis_pembayaran}</td>
                                <td class="text-left" hidden>${siswa}</td>
                                <td class="text-left" hidden>${keterangan1}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm delete-record center" onClick="onClickRemove" data-id="delete">Delete</a>    
                                </td>
                            </tr>                         
                        `)
                        // Menghapus baris tabel yang sesuai dengan tombol "Delete"
                        // Memanggil fungsi updateSubTotal() untuk mengurangi subtotal
                        $(document).on("click", ".delete-record", function() {

                            $(this).closest("tr").remove();


                            updateSubTotal();
                        });
                        // Menghapus baris tabel yang sesuai dengan tombol "Delete"



                        // Fungsi untuk mengupdate subtotal
                        updateSubTotal();

                        function updateSubTotal() {
                            var table = document.getElementById("tambahBarang");
                            let subTotal = Array.from(table.rows).slice(1).reduce((total, row) => {
                                return total + parseFloat(row.cells[3].innerHTML.replace(/[^\d\,]/g,
                                    ''));
                            }, 0);
                            document.getElementById("val").innerHTML = "Total = Rp " + subTotal.toLocaleString(
                                "id-ID") + ",00";
                            console.log(val);
                        }
                        // Fungsi untuk mengupdate subtotal
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data tidak terdaftar!',
                            showConfirmButton: false,
                            timer: 1500,
                            // willClose: () => {
                            //     location.reload();
                            // }
                        })
                    }
                },
                error: (err) => {
                    console.log(err);
                },
            });
        }

        var dataPenjualanItems = JSON.parse(localStorage.getItem("localPenjualanProduk"));
        if (dataPenjualanItems == null) {
            var dataPenjualanItems = {
                "items": []
            };
            localStorage.setItem('localPenjualanProduk', JSON.stringify(dataPenjualanItems));
        }


        function tambahBarang() {
            var produk = document.getElementById('produk').value;
            var stok = document.getElementById('stok').value;
            var nilai_jual = document.getElementById('nilai_jual').value;
            var total = document.getElementById('total1').value;
            var modal = document.getElementById('nilai_per_pcs').value;
            var qty = document.getElementById('qty').value;
            var total_modal = document.getElementById('total_modal').value;
            var margin = document.getElementById('margin').value;
            produk_value = $('#produk option:selected').data('id');
            var jenis_pembayaran = document.getElementById('jenis_pembayaran').value;
            var siswa = document.getElementById('siswa').value;
            var keterangan1 = document.getElementById('keterangan1').value;

            $('#produk').val("").trigger('change')

            document.getElementById('barcode1').value = '';
            document.getElementById('stok').value = '';
            document.getElementById('nilai_jual').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('total1').value = '';
            document.getElementById('jenis_pembayaran').value = '';
            document.getElementById('nilai_per_pcs').value = '';
            document.getElementById('total_modal').value = '';
            document.getElementById('margin').value = '';
            document.getElementById('keterangan1').value = '';


            if (produk == '' || nilai_jual == '' || qty == '' || total == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                $("#tambahBarang tr:last").after(`
                        <tr>
                            <td class="text-center">${produk_value}</td>
                            <td class="text-center">${qty}</td>
                            <td class="text-center">${nilai_jual}</td>
                            <td class="text-center">${total}</td>
                            <td class="text-left" hidden>${produk}</td>
                            <td class="text-left" hidden>${modal}</td>
                            <td class="text-left" hidden>${total_modal}</td>
                            <td class="text-left" hidden>${margin}</td>
                            <td class="text-left" hidden>${jenis_pembayaran}</td>
                            <td class="text-left" hidden>${siswa}</td>
                            <td class="text-left" hidden>${keterangan1}</td>
                            <td>
                                <a class="btn btn-danger btn-sm delete-record center" data-id="delete">Delete</a>    
                            </td>
                        </tr> 
                    `)

                $(document).on("click", ".delete-record", function() {
                    // Menghapus baris tabel yang sesuai dengan tombol "Delete"
                    $(this).closest("tr").remove();

                    // Memanggil fungsi updateSubTotal() untuk mengurangi subtotal
                    updateSubTotal();
                });

                // Fungsi untuk mengupdate subtotal
                updateSubTotal(); // nominal total dari barcode
                function updateSubTotal() {
                    var table = document.getElementById("tambahBarang");
                    let subTotal = Array.from(table.rows).slice(1).reduce((total, row) => {
                        return total + parseFloat(row.cells[3].innerHTML.replace(/[^\d\,]/g,
                            ''));
                    }, 0);
                    document.getElementById("val").innerHTML = "Total = Rp " + subTotal.toLocaleString(
                        "id-ID") + ",00";
                    console.log(val);
                }
            }

        }

        $(document).ready(function() {
            $('.radio').click(function() {
                let metode_scan = $(this).val();
                if (metode_scan == 'Barcode') {
                    $('.div_scan_camera').hide();
                    $('.div_barcode').show();
                } else {
                    $('.div_scan_camera').show();
                    $('.div_barcode').hide();
                }
            });

            $(".scanner_barcode").change(function() {
                let barcode = $(this).val();
                // get value database 
                getValueScanBarcodeCamera(barcode, 'Siswa')
            });

            //fungsi hapus
            $("#tambahBarang").on('click', '.delete-record', function() {
                $(this).parent().parent().remove()
            })

            $("#save").on('click', function() {
                let datapenjualan = []

                $("#tambahBarang").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        produk_value = tableData.eq(0).text(),
                        qty = tableData.eq(1).text(),
                        nilai_jual = tableData.eq(2).text(),
                        total = tableData.eq(3).text(),
                        produk = tableData.eq(4).text(),
                        modal = tableData.eq(5).text(),
                        total_modal = tableData.eq(6).text(),
                        margin = tableData.eq(7).text(),
                        jenis_pembayaran = tableData.eq(8).text(),
                        siswa = tableData.eq(9).text(),
                        keterangan1 = tableData.eq(10).text()

                    //ini filter data null
                    if (produk != '') {
                        datapenjualan.push({
                            produk_value,
                            qty,
                            nilai_jual,
                            total,
                            produk,
                            modal,
                            total_modal,
                            margin,
                            jenis_pembayaran,
                            siswa,
                            keterangan1,
                        });
                    }
                })

                jQuery.ajax({
                    type: "POST",
                    url: '{{ route('bursa_penjualan.store') }}',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        datapenjualan
                    },
                    success: (response) => {
                        console.log(response);
                        if (response.code === 200) {

                            // set local null

                            var dataPenjualan = {
                                "header": {
                                    "jenjang": '',
                                    "siswa": '',
                                }
                            };
                            localStorage.setItem('localPenjualanPelanggan', JSON
                                .stringify(
                                    dataPenjualan));

                            Swal.fire(
                                'Success',
                                'Data Penjualan Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL +
                                    '/bursa/bursa_penjualan'
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

                var dataPenjualan = {
                    "header": {
                        "jenjang": '',
                        "siswa": '',
                    }
                };
                localStorage.setItem('localPenjualanPelanggan', JSON.stringify(dataPenjualan));

                var APP_URL = {!! json_encode(url('/')) !!}
                window.location = APP_URL + '/bursa/bursa_penjualan'
            })

            var dataPenjualan = JSON.parse(localStorage.getItem("localPenjualanPelanggan"));


            $.ajax({
                type: "POST",
                url: '{{ route('invoice.get_jenjang') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response.data, function(i, item) {
                        if (item.jurusan) {
                            jurusan = item.jurusan;
                        } else {
                            jurusan = '';
                        }

                        if (item.classes) {
                            classes = item.classes;
                        } else {
                            classes = '';
                        }

                        if (item.type) {
                            type = item.type;
                        } else {
                            type = '';
                        }

                        if (dataPenjualan.header.jenjang == item.id) {
                            console.log(response)
                            $('.classes').append(
                                `<option value="${item.id}" selected>${item.level+' '+classes+' '+jurusan+' '+type}</option>`
                            )
                        } else {
                            $('.classes').append(
                                `<option value="${item.id}" >${item.level+' '+classes+' '+jurusan+' '+type}</option>`
                            )
                        }
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            if (dataPenjualan.header.siswa) {
                getSiswa(dataPenjualan.header.siswa);
            }

            function getSiswa(siswa) {
                let class_jenjang = dataPenjualan.header.jenjang;
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('bursa_penjualan.get_siswa') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_jenjang
                    },
                    success: response => {
                        $('.siswa').append(`<option value="">-- Pilih Siswa --</option>`)
                        $.each(response.data, function(i, item) {
                            if (siswa == item.id) {
                                $('.siswa').append(
                                    `<option value="${item.id}" selected>${item.nama_lengkap}</option>`
                                )
                            } else {
                                $('.siswa').append(
                                    `<option value="${item.id}">${item.nama_lengkap}</option>`
                                )
                            }
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            }

            $(".classes").change(function() {
                let class_jenjang = $(this).val();
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('bursa_penjualan.get_siswa') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_jenjang
                    },
                    success: response => {
                        $('.siswa').append(
                            `<option value="">-- Pilih Siswa --</option>`)
                        $.each(response.data, function(i, item) {
                            $('.siswa').append(
                                `<option value="${item.id}" data-id="${item.nama_lengkap}">${item.nama_lengkap}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        })

        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: '{{ route('bursa_penjualan.get_produk') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },

                success: response => {
                    $.each(response.data, function(i, item) {
                        $('.produk').append(
                            `<option value="${item.id}" data-id="${item.nama}" data-value="${item.stok}" data-value1="${item.harga_jual}" data-value2="${item.harga_beli}" data-value3="${item.barcode}">${item.nama}</option>`
                        )
                    })

                    $(".produk").change(function() {
                        var barcode1 = $('option:selected', this).attr('data-value3');
                        document.getElementById("barcode1").value = barcode1;
                    });

                    $(".produk").change(function() {
                        var stok = $('option:selected', this).attr('data-value');
                        document.getElementById("stok").value = stok;
                    });

                    $(".produk").change(function() {
                        var nilai_jual = $('option:selected', this).attr('data-value1');
                        document.getElementById("nilai_jual").value = nilai_jual;
                    });

                    $(".produk").change(function() {
                        var nilai_beli = $('option:selected', this).attr('data-value2');
                        document.getElementById("nilai_per_pcs").value = nilai_beli;
                    });
                },
                error: (err) => {
                    console.log(err);
                },
            });
        })
    </script>
@endsection
