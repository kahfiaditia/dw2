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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="modal-title">Peminjam</h5>
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
                                            <h5 class="modal-title">Metode Scan</h5>
                                            <div class="mb-3">
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
                                            </div>
                                            <div class="row text-muted div_barcode">
                                                <input type="text" name="scanner_barcode" autofocus
                                                    class="form-control scanner_barcode" id="scanner_barcode"
                                                    placeholder="Barcode">
                                            </div>
                                            <div class="row text-muted div_scan_camera">
                                                <div id="qr-reader"></div>
                                                <div id="qr-reader-results"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary">Cari</button>
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
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                barcode = decodedText;
                // peminjam = document.getElementById("peminjam").value;
                // get value database 
                getValueScanBarcodeCamera(barcode)

                // var settingBarcode = {
                //     "barcode": {
                //         "status": 'on',
                //         "metode": 'Scan Kamera',
                //     }
                // };
                // localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

        function getValueScanBarcodeCamera(barcode, peminjam) {}

        $(document).ready(function() {
            // area scanner dan barcode
            $('.div_scan_camera').hide();
            // $('.div_barcode').hide();

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
        });
    </script>
@endsection
