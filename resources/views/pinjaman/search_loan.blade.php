@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-left">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal bs-example-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-md-12">
                                                <h5 class="modal-title">Peminjam</h5>
                                                <div class="col-md-12">
                                                    <select class="form-control select select2 peminjam" name="peminjam"
                                                        style="width: 100%" required id="peminjam">
                                                        <option value="">--Pilih Peminjam--</option>
                                                        <option value="Siswa">Siswa</option>
                                                        <option value="Guru">Guru</option>
                                                        <option value="Karyawan">Karyawan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <h5 class="modal-title">Metode Scan</h5>
                                                <div class="col-md-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input radio" type="radio" name="toggle"
                                                            checked id="inlineRadio1" value="Barcode">
                                                        <label class="form-check-label" for="inlineRadio1">Barcode</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input radio" type="radio" name="toggle"
                                                            id="inlineRadio2" value="Scan Kamera">
                                                        <label class="form-check-label" for="inlineRadio2">Scan
                                                            Kamera</label>
                                                    </div>
                                                    <div class="mb-3 text-muted div_barcode">
                                                        <input type="text" name="scanner_barcode" autofocus
                                                            class="form-control scanner_barcode" id="scanner_barcode"
                                                            placeholder="Barcode">
                                                    </div>
                                                    <div class="mb-3 text-muted div_scan_camera">
                                                        <div id="qr-reader"></div>
                                                        <div id="qr-reader-results"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="save">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
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
                value_peminjam = document.getElementById("peminjam").value;
                // get value database 
                getValueScanBarcodeCamera(barcode, value_peminjam, 'Scan Kamera')
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

        function getValueScanBarcodeCamera(scanner_barcode, value_peminjam, metode) {
            $.ajax({
                type: 'POST',
                url: '{{ route('pinjaman.getsearch') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    scanner_barcode,
                    value_peminjam,
                },
                success: (response) => {
                    if (response.code == 200) {
                        if (response.data == 0) {
                            var dataPerpus = {
                                "header": {
                                    "milisecond": response.milisecond,
                                    "peminjam": response.peminjam,
                                    "jenjang": response.jenjang,
                                    "siswa": response.siswa,
                                    "karyawan": response.karyawan,
                                    "tgl_pinjam": response.tgl_pinjam
                                }
                            };
                            localStorage.setItem('localPerpusDharma', JSON.stringify(dataPerpus));

                            var APP_URL = {!! json_encode(url('/')) !!}
                            window.location = APP_URL + '/pinjaman/create'
                        } else if (response.data > 0) {
                            var APP_URL = {!! json_encode(url('/')) !!}
                            window.location = APP_URL + '/return_book/' + response.encrypt_peminjam + '/' +
                                response.peminjam
                        }

                        var settingBarcode = {
                            "barcode": {
                                "status": 'on',
                                "metode": metode,
                            }
                        };
                        localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));

                    } else if (response.code == 404) {
                        Swal.fire({
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    }
                },
                error: err => console.log("Interal Server Error")
            })

        }

        $(document).ready(function() {
            // area scanner dan barcode
            $('.div_scan_camera').hide();
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
                getValueScanBarcodeCamera(barcode, peminjam, 'Barcode')
            });

            $("#save").on('click', function() {
                var scanner_barcode = document.getElementById('scanner_barcode').value;
                var select_peminjam = document.getElementById('peminjam');
                var value_peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
                if (scanner_barcode == '' || value_peminjam == '' ||
                    value_peminjam == undefined || value_peminjam == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Peminjam dan Metode Scan wajib diisi',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                } else {
                    getValueScanBarcodeCamera(scanner_barcode, value_peminjam, 'Barcode')
                }
            })
        });
    </script>
@endsection
