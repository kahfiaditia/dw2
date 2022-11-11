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
                <form class="needs-validation" action="{{ route('pinjaman.store') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="milisecond" id="milisecond" value="{{ $milisecond }}">
                    <div class="row">
                        <div class="col-xl-12">
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
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Peminjam <code>*</code></label>
                                                <select class="form-control select select2 peminjam" name="peminjam"
                                                    required id="peminjam">
                                                    <option value="">--Pilih Peminjam--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_siswa">
                                            <div class="mb-3">
                                                <label class="form-label">Jenjang <code>*</code></label>
                                                <select class="form-control select select2 classes" name="jenjang" required
                                                    id="jenjang">
                                                    <option value="">--Pilih Jenjang--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('jenjang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_siswa">
                                            <div class="mb-3">
                                                <label for="">Siswa <code>*</code></label>
                                                <select class="form-control select select2 siswa" name="siswa" required
                                                    id="siswa">
                                                    <option value="">--Pilih Siswa--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('siswa', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_guru">
                                            <div class="mb-3">
                                                <label for="">Guru/Karyawan <code>*</code></label>
                                                <select class="form-control select select2 karyawan" name="karyawan"
                                                    required id="karyawan">
                                                    <option value="">--Pilih Guru/Karyawan--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('karyawan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tanggal Pinjam <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pinjam"
                                                        placeholder="yyyy-mm-dd" name="tgl_pinjam" id="tgl_pinjam"
                                                        value="{{ date('Y-m-d') }}"
                                                        data-date-end-date="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('tgl_pinjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row gy-2 gx-3 align-items-center">
                                        <h5 class="card-title">Tambah Buku</h5>
                                        <div class="col-sm-auto col-md-3">
                                            <select class="form-control select select2 book" id="buku_id">
                                                <option value="">--Pilih Buku--</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-auto col-md-3">
                                            <input type="text" class="form-control number-only" id="jml_buku"
                                                readonly value="1" placeholder="Jumlah Buku">
                                        </div>
                                        <div class="col-sm-auto col-md-3">
                                            <a type="submit" class="btn btn-info w-md" id="add">Tambah buku</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="table_pinjaman">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">#</th>
                                                        <th class="text-center" style="width: 40%">Buku</th>
                                                        <th class="text-center" style="width: 20%">Jumlah Buku</th>
                                                        <th class="text-center" style="width: 10%">Aksi</th>
                                                        <th class="text-center" hidden>buku_id</th>
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
                <br>
            </div>
        </div>
    </body>
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
                peminjam = document.getElementById("peminjam").value;
                // get value database 
                getValueScanBarcodeCamera(barcode, peminjam)

                var settingBarcode = {
                    "barcode": {
                        "status": 'on',
                        "metode": 'Scan Kamera',
                    }
                };
                localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));
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

            // load karyawan
            var select_peminjam = document.getElementById('peminjam');
            var peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
            if (peminjam == 'Siswa') {
                $('.peminjam_siswa').show();
                $('.peminjam_guru').hide();
                document.getElementById("karyawan").required = false
                document.getElementById("jenjang").required = true
                document.getElementById("siswa").required = true
            } else if (peminjam == 'Guru' || peminjam == 'Karyawan') {
                $('.peminjam_guru').show();
                $('.peminjam_siswa').hide();
                document.getElementById("karyawan").required = true
                document.getElementById("jenjang").required = false
                document.getElementById("siswa").required = false
            } else {
                $('.peminjam_guru').hide();
                $('.peminjam_siswa').hide();
            }

            // set barcodeScanner hide
            $('.barcodeScanner').hide();
            collapseOne = document.getElementById("collapseOne");
            collapseOne.classList.remove("show");

            // cek localStorageBarcode jika on
            var localPerpusDharmaBarcode = JSON.parse(localStorage.getItem("localPerpusDharmaBarcode"));
            if (localPerpusDharmaBarcode.barcode.status == 'on') {
                $('.barcodeScanner').show();
                element = document.getElementById("accordion-button");
                element.classList.remove("collapsed");
                collapseOne = document.getElementById("collapseOne");
                collapseOne.classList.add("show");
            }

            if (localPerpusDharmaBarcode.barcode.metode == 'Barcode') {
                $('.div_barcode').show();
                document.getElementById("inlineRadio1").checked = true;
            }

            if (localPerpusDharmaBarcode.barcode.metode == 'Scan Kamera') {
                $('.div_scan_camera').show();
                document.getElementById("inlineRadio2").checked = true;
            }
        }

        function getValueScanBarcodeCamera(barcode, peminjam) {
            $.ajax({
                type: "POST",
                url: '{{ route('pinjaman.scanBarcode') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    barcode,
                    peminjam
                },
                success: response => {
                    // initialize header
                    milisecond = document.getElementById("milisecond").value;
                    peminjam = document.getElementById("peminjam").value;
                    tgl_pinjam = document.getElementById("tgl_pinjam").value;
                    if (response.type == 'Siswa') {
                        siswa = response.id;
                        jenjang = response.jenjang;
                        var dataPerpus = {
                            "header": {
                                "milisecond": milisecond,
                                "peminjam": peminjam,
                                "jenjang": jenjang,
                                "siswa": siswa,
                                "karyawan": '',
                                "tgl_pinjam": tgl_pinjam
                            }
                        };
                        localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));

                        Swal.fire({
                            title: 'Scan Barcode',
                            text: "Data Siswa tersimpan",
                            icon: 'success',
                            timer: 500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    } else if (response.type == 'Guru') {
                        guru = response.id;
                        var dataPerpus = {
                            "header": {
                                "milisecond": milisecond,
                                "peminjam": peminjam,
                                "jenjang": '',
                                "siswa": '',
                                "karyawan": guru,
                                "tgl_pinjam": tgl_pinjam
                            }
                        };
                        localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));

                        Swal.fire({
                            title: 'Scan Barcode',
                            text: "Data Guru tersimpan",
                            icon: 'success',
                            timer: 500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    } else if (response.type == 'Karyawan') {
                        karyawan = response.id;
                        var dataPerpus = {
                            "header": {
                                "milisecond": milisecond,
                                "peminjam": peminjam,
                                "jenjang": '',
                                "siswa": '',
                                "karyawan": karyawan,
                                "tgl_pinjam": tgl_pinjam
                            }
                        };
                        localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));

                        Swal.fire({
                            title: 'Scan Barcode',
                            text: "Data Karyawan tersimpan",
                            icon: 'success',
                            timer: 500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    } else if (response.type == 'buku') {
                        buku_id = response.id;
                        judul = response.jenjang;
                        var dataPerpusItems = JSON.parse(localStorage.getItem("localPerpusDharmaItems"));
                        var item = {
                            "buku_id": buku_id,
                            "judul": judul,
                            "jml_buku": 1,
                        }
                        dataPerpusItems.items.push(item);
                        localStorage.setItem('localPerpusDharmaItems', JSON.stringify(dataPerpusItems));

                        Swal.fire({
                            title: 'Scan Barcode',
                            text: "Data Buku tersimpan",
                            icon: 'success',
                            timer: 500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data tidak terdaftar!',
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    }
                },
                error: (err) => {
                    console.log(err);
                },
            });
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
                peminjam = document.getElementById("peminjam").value;
                // get value database 
                getValueScanBarcodeCamera(barcode, peminjam)

                // set proses barcode
                var settingBarcode = {
                    "barcode": {
                        "status": 'on',
                        "metode": 'Barcode',
                    }
                };
                localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));
            });

            let increment = 0;

            // set localStorage awal
            defaultLocalStorage();

            function defaultLocalStorage() {
                var dataPerpus = JSON.parse(localStorage.getItem("localPerpusDharma"));
                if (dataPerpus == null) {
                    var dataPerpus = {
                        "header": {
                            "milisecond": '',
                            "peminjam": '',
                            "jenjang": '',
                            "siswa": '',
                            "karyawan": '',
                            "tgl_pinjam": ''
                        }
                    };
                    localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));
                }

                var dataPerpusItems = JSON.parse(localStorage.getItem("localPerpusDharmaItems"));
                if (dataPerpusItems == null) {
                    var dataPerpusItems = {
                        "items": []
                    };
                    localStorage.setItem('localPerpusDharmaItems', JSON.stringify(dataPerpusItems));
                }

                var dataPerpusItemsBarcode = JSON.parse(localStorage.getItem("localPerpusDharmaBarcode"));
                if (dataPerpusItemsBarcode == null) {
                    var settingBarcode = {
                        "barcode": {
                            "status": 'off',
                            "metode": '',
                        }
                    };
                    localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));
                }
            }

            var dataPerpus = JSON.parse(localStorage.getItem("localPerpusDharma"));
            if (dataPerpus.header.siswa) {
                getSiswa(dataPerpus.header.siswa);
            }

            arr_peminjam = ['Siswa', 'Guru', 'Karyawan'];
            for (let dropdown = 0; dropdown < arr_peminjam.length; dropdown++) {
                $('.peminjam').append(
                    `<option value="${arr_peminjam[dropdown]}" >${arr_peminjam[dropdown]}</option>`
                )
            }

            function getSiswa(siswa) {
                let class_jenjang = dataPerpus.header.jenjang;
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('invoice.get_siswa') }}',
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

            if (dataPerpus.header.milisecond) {
                document.getElementById("milisecond").value = dataPerpus.header.milisecond;
            }

            if (dataPerpus.header.tgl_pinjam) {
                document.getElementById("tgl_pinjam").value = dataPerpus.header.tgl_pinjam;
            }

            if (dataPerpus.header.peminjam) {
                document.getElementById("peminjam").value = dataPerpus.header.peminjam;
            }

            var dataPerpusItems = JSON.parse(localStorage.getItem("localPerpusDharmaItems"));
            if (dataPerpusItems) {
                getItems(dataPerpusItems.items);
            }

            function getItems(items) {
                increment++;
                for (let i = 0; i < items.length; i++) {
                    if (items.length > 0 && items[i].judul != '') {
                        $("#table_pinjaman tr:last").after(`
                            <tr>
                                <td class="text-center">${increment++}</td>   
                                <td class="">${items[i].judul}</td>    
                                <td class="text-center">${items[i].jml_buku}</td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn-sm deleteItems" id="deleteItems">Delete</a>    
                                </td>
                                <td class="text-center" hidden>${items[i].buku_id}</td>
                            </tr>
                        `)
                    }
                }
            }

            $(".peminjam").change(function() {
                let peminjam = $(this).val();
                $('#siswa').val("").trigger('change')
                $('#jenjang').val("").trigger('change')
                $('#karyawan').val("").trigger('change')

                if (peminjam == 'Siswa') {
                    $('.peminjam_siswa').show();
                    $('.peminjam_guru').hide();
                    document.getElementById("karyawan").required = false
                    document.getElementById("jenjang").required = true
                    document.getElementById("siswa").required = true
                } else {
                    $('.peminjam_guru').show();
                    $('.peminjam_siswa').hide();
                    document.getElementById("karyawan").required = true
                    document.getElementById("jenjang").required = false
                    document.getElementById("siswa").required = false

                    // load karyawan
                    var select_peminjam = document.getElementById('peminjam');
                    var value_peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
                    loadKaryawan(value_peminjam)
                }
                setLocalStorage('header');
            });

            // load jenjang
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

                        if (dataPerpus.header.jenjang == item.id) {
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

            $(".classes").change(function() {
                let class_jenjang = $(this).val();
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('invoice.get_siswa') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_jenjang
                    },
                    success: response => {
                        $('.siswa').append(`<option value="">-- Pilih Siswa --</option>`)
                        $.each(response.data, function(i, item) {
                            $('.siswa').append(
                                `<option value="${item.id}">${item.nama_lengkap}</option>`
                            )
                        })
                        $('#siswa').val("").trigger('change')
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });

            $(".siswa").change(function() {
                setLocalStorage('header');
            });

            $(".tgl_pinjam").change(function() {
                setLocalStorage('header');
            });

            // load karyawan
            var select_peminjam = document.getElementById('peminjam');
            var value_peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
            $.ajax({
                type: "POST",
                url: '{{ route('employee.dropdown_karyawan') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    value_peminjam
                },
                success: response => {
                    if (response.length > 0) {
                        $.each(response, function(i, item) {
                            if (dataPerpus.header.karyawan == item.id) {
                                $('.karyawan').append(
                                    `<option value="${item.id}" selected>${item.nama_lengkap}</option>`
                                )
                            } else {
                                $('.karyawan').append(
                                    `<option value="${item.id}" >${item.nama_lengkap}</option>`
                                )
                            }
                        })
                    }
                },
                error: (err) => {
                    console.log(err);
                },
            });

            function loadKaryawan(value_peminjam, old) {
                var dataPerpus = JSON.parse(localStorage.getItem("localPerpusDharma"));
                $(".karyawan option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('employee.dropdown_karyawan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value_peminjam
                    },
                    success: response => {
                        $('.karyawan').append(`<option value="">-- Pilih Karyawan --</option>`)
                        if (response.length > 0) {
                            $.each(response, function(i, item) {
                                if (dataPerpus.header.karyawan == item.id) {
                                    $('.karyawan').append(
                                        `<option value="${item.id}" selected>${item.nama_lengkap}</option>`
                                    )
                                } else {
                                    $('.karyawan').append(
                                        `<option value="${item.id}" >${item.nama_lengkap}</option>`
                                    )
                                }
                            })
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            }

            $(".karyawan").change(function() {
                setLocalStorage('header');
            });

            // load book
            $.ajax({
                type: "POST",
                url: '{{ route('buku.dropdown') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response, function(i, item) {
                        $('.book').append(
                            `<option value="${item.id}" data-id="${item.kode_kategori+' - '+item.judul}">${item.kode_kategori+' - '+item.judul}</option>`
                        )
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            function setLocalStorage(type) {
                // initialize header
                milisecond = document.getElementById("milisecond").value;
                peminjam = document.getElementById("peminjam").value;
                jenjang = document.getElementById("jenjang").value;
                siswa = document.getElementById("siswa").value;
                karyawan = document.getElementById("karyawan").value;
                tgl_pinjam = document.getElementById("tgl_pinjam").value;

                if (type == 'header') {
                    var dataPerpus = {
                        "header": {
                            "milisecond": milisecond,
                            "peminjam": peminjam,
                            "jenjang": jenjang,
                            "siswa": siswa,
                            "karyawan": karyawan,
                            "tgl_pinjam": tgl_pinjam

                        }
                    };
                    localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));
                }
            }

            $("#add").on('click', function() {
                increment++;
                // setStorageLocalItems
                defaultLocalStorage();

                // initialize header
                milisecond = document.getElementById("milisecond").value;
                jenjang = document.getElementById("jenjang").value;
                siswa = document.getElementById("siswa").value;
                tgl_pinjam = document.getElementById("tgl_pinjam").value;
                // items
                judul = $('#buku_id option:selected').data('id');
                buku_id = document.getElementById("buku_id").value;
                jml_buku = document.getElementById("jml_buku").value;

                if (jml_buku === '' || buku_id === '') {
                    Swal.fire(
                        'Gagal',
                        'Buku dan jumlah buku yang dipinjam wajib diisi',
                        'error'
                    )
                } else {
                    $("#table_pinjaman tr:last").after(`
                        <tr>
                            <td class="text-center">${increment}</td>   
                            <td class="">${judul}</td>    
                            <td class="text-center">${jml_buku}</td>
                            <td class="text-center">
                                <a class="btn btn-danger btn-sm deleteItems" id="deleteItems">Delete</a>    
                                </td>
                            <td class="text-center" hidden>${buku_id}</td>
                        </tr>
                    `)

                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td')
                        tableData.eq(0).text(index)
                    })

                    var dataPerpusItems = JSON.parse(localStorage.getItem("localPerpusDharmaItems"));
                    var item = {
                        "buku_id": buku_id,
                        "judul": judul,
                        "jml_buku": jml_buku,
                    }
                    dataPerpusItems.items.push(item);
                    localStorage.setItem('localPerpusDharmaItems', JSON.stringify(dataPerpusItems));

                    // null items
                    $('#buku_id').val("").trigger('change')
                    // $('#jml_buku').val("")
                }

                $(".deleteItems").on('click', function() {
                    $(this).parent().parent().remove()

                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td')
                        tableData.eq(0).text(index)
                    })

                    // hapus localStorage
                    localStorage.removeItem("localPerpusDharmaItems");

                    var dataPerpusItems = {
                        'items': []
                    };
                    // looping no
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td'),
                            judul = tableData.eq(1).text(),
                            jml_buku = tableData.eq(2).text(),
                            buku_id = tableData.eq(4).text()

                        tableData.eq(0).text(index)

                        var item = {
                            "buku_id": buku_id,
                            "judul": judul,
                            "jml_buku": jml_buku,
                        }
                        if (buku_id != '') {
                            dataPerpusItems.items.push(item);
                        }
                    })
                    localStorage.setItem('localPerpusDharmaItems', JSON.stringify(
                        dataPerpusItems));
                })
            })

            $(".deleteItems").on('click', function() {
                $(this).parent().parent().remove()

                // looping no
                $("#table_pinjaman").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td')
                    tableData.eq(0).text(index)
                })

                // hapus localStorage
                localStorage.removeItem("localPerpusDharmaItems");

                var dataPerpusItems = {
                    'items': []
                };
                // looping no
                $("#table_pinjaman").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        judul = tableData.eq(1).text(),
                        jml_buku = tableData.eq(2).text(),
                        buku_id = tableData.eq(4).text()

                    tableData.eq(0).text(index)

                    var item = {
                        "buku_id": buku_id,
                        "judul": judul,
                        "jml_buku": jml_buku,
                    }
                    if (buku_id != '') {
                        dataPerpusItems.items.push(item);
                    }
                })
                localStorage.setItem('localPerpusDharmaItems', JSON.stringify(
                    dataPerpusItems));
            })

            $("#batal").on('click', function() {
                // hapus localStorage
                localStorage.removeItem("localPerpusDharma");
                localStorage.removeItem("localPerpusDharmaBarcode");
                localStorage.removeItem("localPerpusDharmaItems");

                var APP_URL = {!! json_encode(url('/')) !!}
                window.location = APP_URL + '/pinjaman'
            })

            $("#accordion-button").on('click', function() {
                $('.barcodeScanner').show();
            })

            $("#save").on('click', function() {
                // hapus localStorage
                var localPerpusDharma = JSON.parse(localStorage.getItem("localPerpusDharma"));
                var localPerpusDharmaItems = JSON.parse(localStorage.getItem("localPerpusDharmaItems"));
                if (localPerpusDharmaItems.items.length > 0 && localPerpusDharma.header.peminjam &&
                    localPerpusDharma.header.milisecond && localPerpusDharma.header.tgl_pinjam && (
                        localPerpusDharma.header.siswa || localPerpusDharma.header.karyawan)) {
                    let datas = []
                    $("#table_pinjaman").find("tr").each(function(index, element) {
                        let tableData = $(this).find('td'),
                            judul = tableData.eq(1).text(),
                            jml_buku = tableData.eq(2).text(),
                            buku_id = tableData.eq(4).text()

                        datas.push({
                            buku_id,
                            jml_buku
                        })
                    })
                    let data_post = datas.filter(data => data.buku_id !== "")
                    let milisecond = localPerpusDharma.header.milisecond;
                    let peminjam = localPerpusDharma.header.peminjam;
                    let tgl_pinjam = localPerpusDharma.header.tgl_pinjam;
                    let siswa = localPerpusDharma.header.siswa;
                    let karyawan = localPerpusDharma.header.karyawan;
                    let jenjang = localPerpusDharma.header.jenjang;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('pinjaman.store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            data_post,
                            milisecond,
                            peminjam,
                            tgl_pinjam,
                            siswa,
                            karyawan,
                            jenjang
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                // hapus localStorage
                                localStorage.removeItem("localPerpusDharma");
                                localStorage.removeItem("localPerpusDharmaBarcode");
                                localStorage.removeItem("localPerpusDharmaItems");

                                Swal.fire(
                                    'Success',
                                    'Peminjaman Buku berhasil',
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    window.location = APP_URL + '/pinjaman'
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanda * (bintang) dan Buku wajib diisi',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                }
            })
        });
    </script>
@endsection
