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
                                @if (in_array('75', $session_menu))
                                    <a href="{{ route('pinjaman.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Pinjaman
                                    </a>
                                @endif
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
                                                <div class="col-md-12">
                                                    <label for="">Peminjam</label>
                                                    <input type="text" class="form-control" value="{{ $name }}"
                                                        readonly>
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
                                            <a href="{{ route('pinjaman.search_loan') }}"
                                                class="btn btn-secondary waves-effect">Batal</a>
                                            <button type="button" class="btn btn-primary" id="save">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="type" value="{{ $type }}">
                            <input type="hidden" id="user" value="{{ $user->id }}">
                            <table id="" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="2%">No</th>
                                        <th class="text-center" width="18%">Kode Transaksi</th>
                                        <th width="45%">Tgl Pinjam</th>
                                        <th width="18%">Tgl Perkiraan Kembali</th>
                                        <th class="text-center" width="12%">Tgl Kembali</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td class="text-center">
                                                @if ($item['flag'] == 'header')
                                                    {{ $no++ }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item['flag'] == 'header')
                                                    {{ $item['kode'] }}
                                                @endif
                                            </td>
                                            <td>{{ $item['tgl_pinjam'] }}</td>
                                            <td>{{ $item['tgl_perkiraan_kembali'] }}</td>
                                            <td class="text-center">{{ $item['tgl_kembali'] }}</td>
                                            <td>
                                                @if ($item['flag'] == 'detail')
                                                    <?php
                                                    $id = Crypt::encryptString($item['id']);
                                                    $kode = $item['kode'];
                                                    ?>
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('78', $session_menu))
                                                            @if ($item['tgl_kembali'] == null)
                                                                <form class="delete-form"
                                                                    action="{{ route('pinjaman.book_return', ['id' => $id, 'kode' => $kode]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a href class="text-success approve_confirm"><i
                                                                            class="mdi mdi-check-all font-size-18"></i></a>
                                                                </form>
                                                            @elseif ($item['tgl_kembali'] != null)
                                                                <form class="delete-form"
                                                                    action="{{ route('pinjaman.cancle_return', ['id' => $id, 'kode' => $kode]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a href class="text-danger cancle_confirm"><i
                                                                            class="mdi mdi-delete font-size-18"></i></a>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                // get value database 
                getValueScanBarcodeCamera(barcode, 'Buku')
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

        function getValueScanBarcodeCamera(scanner_barcode, value_peminjam) {
            var user = document.getElementById('user').value;
            var type = document.getElementById('type').value;
            $.ajax({
                type: 'POST',
                url: '{{ route('pinjaman.kembalikan_buku') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    scanner_barcode,
                    value_peminjam,
                    user,
                    type
                },
                success: (response) => {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/return_book/' + response
                                    .encrypt_peminjam + '/' + response
                                    .type
                            }
                        })
                    } else if (response.code == 404) {
                        Swal.fire({
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 1000,
                        })
                        document.getElementById('scanner_barcode').value = null;
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
                // get value database 
                getValueScanBarcodeCamera(barcode, 'Buku')
            });

            $("#save").on('click', function() {
                var scanner_barcode = document.getElementById('scanner_barcode').value;
                var value_peminjam = 'Buku';
                if (scanner_barcode == '' || value_peminjam == '' ||
                    value_peminjam == undefined || value_peminjam == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Peminjam dan Metode Scan wajib diisi',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                } else {
                    getValueScanBarcodeCamera(scanner_barcode, value_peminjam)
                }
            })

            $('.approve_confirm').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Approve Data',
                    text: 'Ingin mengembalikan pinjaman?',
                    icon: 'question',
                    showCloseButton: true,
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    focusConfirm: false,
                }).then((value) => {
                    if (value.isConfirmed) {
                        $(this).closest("form").submit()
                    }
                });
            });

            $('.cancle_confirm').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Batal Approve Data',
                    text: 'Ingin batal mengembalikan pinjaman?',
                    icon: 'question',
                    showCloseButton: true,
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    focusConfirm: false,
                }).then((value) => {
                    if (value.isConfirmed) {
                        $(this).closest("form").submit()
                    }
                });
            });
        });
    </script>
@endsection
