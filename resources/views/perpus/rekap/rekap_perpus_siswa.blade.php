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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rekap_perpus.index') }}">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Rekap Perpus</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Rekap Perpus Per-Siswa</span>
                                    </a>
                                </li>
                            </ul>
                            <br>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <i class="bx bx-search-alt font-size-18"></i>
                                            <b>Cari & Unduh Data</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                <div class="modal bs-example-modal" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="col-md-12">
                                                                    <h5 class="modal-title">Peminjam</h5>
                                                                    <div class="col-md-12">
                                                                        <select class="form-control select select2 peminjam"
                                                                            name="peminjam" style="width: 100%" required
                                                                            id="peminjam">
                                                                            <option value="">--Pilih Peminjam--
                                                                            </option>
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
                                                                            <input class="form-check-input radio"
                                                                                type="radio" name="toggle" checked
                                                                                id="inlineRadio1" value="Barcode">
                                                                            <label class="form-check-label"
                                                                                for="inlineRadio1">Barcode</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input radio"
                                                                                type="radio" name="toggle"
                                                                                id="inlineRadio2" value="Scan Kamera">
                                                                            <label class="form-check-label"
                                                                                for="inlineRadio2">Scan
                                                                                Kamera</label>
                                                                        </div>
                                                                        <div class="mb-3 text-muted div_barcode">
                                                                            <input type="text" name="scanner_barcode"
                                                                                autofocus
                                                                                class="form-control scanner_barcode"
                                                                                id="scanner_barcode" placeholder="Barcode">
                                                                        </div>
                                                                        <div class="mb-3 text-muted div_scan_camera">
                                                                            <div id="qr-reader"></div>
                                                                            <div id="qr-reader-results"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{ route('rekap_perpus.rekap_perpus_siswa') }}"
                                                                    class="btn btn-secondary waves-effect">Batal</a>
                                                                <button type="button" class="btn btn-primary"
                                                                    id="save">Cari</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if ($perpus)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3" style="float: right">
                                            <a href="{{ route('rekap_perpus.export_rekap_perpus_siswa', 'kode=' . Crypt::encryptString($barcode) . '&peminjam=' . $peminjam) }}"
                                                class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                    class="bx bx-cloud-download me-1"></i>Unduh</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">ID Barcode</label>
                                            <input type="text" class="form-control" value="{{ $barcode }}"
                                                readonly placeholder="ID Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">NIS/NIKS</label>
                                            <input type="text" class="form-control" value="{{ $nis }}"
                                                readonly placeholder="NIS/NIKS">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" value="{{ $nama }}"
                                                readonly placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" class="form-control" value="{{ $kelas }}"
                                                readonly placeholder="Kelas">
                                        </div>
                                    </div>
                                </div>
                                <table id="table" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Peminjam</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Estimasi Kembali</th>
                                            <th>Tanggal Kembali</th>
                                            <th width="150px;">Buku</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perpus as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->kode_transaksi }}</td>
                                                <td>{{ $item->peminjam }}</td>
                                                <td>{{ $item->tgl_pinjam }}</td>
                                                <td>{{ $item->tgl_perkiraan_kembali }}</td>
                                                <td>{{ $item->tgl_kembali }}</td>
                                                <td>{{ $item->buku->judul }}</td>
                                                <td class="text-center">{{ $item->jml }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
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
                url: '{{ route('rekap_perpus.getBarcodePerpus') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    scanner_barcode,
                    value_peminjam,
                },
                success: (response) => {
                    if (response.code === 200) {
                        barcode = response.barcode;
                        var APP_URL = {!! json_encode(url('/')) !!}
                        window.location = APP_URL + '/rekap_perpus_siswa?kode=' + barcode + '&peminjam=' +
                            value_peminjam;
                    } else {
                        Swal.fire(
                            'Gagal',
                            'Data tidak terdaftar!',
                            'error',
                        )
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
                } else if (metode_scan == 'Scan Kamera') {
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
