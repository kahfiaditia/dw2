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
                <form class="needs-validation" action="" method="POST" novalidate>
                    @csrf
                    <div class="row col-md-3" hidden>
                        <input type="text" name="milisecond" id="milisecond" value="{{ $pinjaman[0]->milisecond }}">
                        <input type="text" name="url" id="url"
                            value="{{ Crypt::encryptString($pinjaman[0]->kode_transaksi) }}">
                        <input type="text" name="kode_transaksi" id="kode_transaksi"
                            value="{{ $pinjaman[0]->kode_transaksi }}">
                        <input type="text" name="peminjaman_old" id="peminjaman_old"
                            value="{{ $pinjaman[0]->peminjam }}">
                        <input type="text" name="siswa_id_old" id="siswa_id_old" value="{{ $pinjaman[0]->siswa_id }}">
                        <input type="text" name="karyawan_id_old" id="karyawan_id_old"
                            value="{{ $pinjaman[0]->karyawan_id }}">
                        <input type="text" name="class_id_old" id="class_id_old" value="{{ $pinjaman[0]->class_id }}">
                    </div>
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
                                                    disabled id="peminjam">
                                                    <option value="">--Pilih Peminjam--</option>
                                                    <option value="Siswa"
                                                        {{ $pinjaman[0]->peminjam == 'Siswa' ? 'selected' : '' }}>Siswa
                                                    </option>
                                                    <option value="Guru"
                                                        {{ $pinjaman[0]->peminjam == 'Guru' ? 'selected' : '' }}>Guru
                                                    </option>
                                                    <option value="Karyawan"
                                                        {{ $pinjaman[0]->peminjam == 'Karyawan' ? 'selected' : '' }}>
                                                        Karyawan
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_siswa">
                                            <div class="mb-3">
                                                <?php
                                                if ($pinjaman[0]->siswa) {
                                                    if ($pinjaman[0]->siswa->classes_student->school_class) {
                                                        $classes = $pinjaman[0]->siswa->classes_student->school_class->classes;
                                                    } else {
                                                        $classes = null;
                                                    }
                                                    $jenjang = $pinjaman[0]->siswa->classes_student->school_level->level . ' ' . $classes . ' ' . $pinjaman[0]->siswa->classes_student->jurusan;
                                                } else {
                                                    $jenjang = null;
                                                }
                                                ?>
                                                <label class="form-label">Jenjang <code>*</code></label>
                                                <input type="text" class="form-control" id="pengarang" name="pengarang"
                                                    value="{{ $jenjang }}" disabled placeholder="Pengarang">
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_siswa">
                                            <div class="mb-3">
                                                <?php
                                                if ($pinjaman[0]->siswa) {
                                                    $siswa = $pinjaman[0]->siswa->nama_lengkap;
                                                } else {
                                                    $siswa = null;
                                                }
                                                ?>
                                                <label for="">Siswa <code>*</code></label>
                                                <input type="text" class="form-control" id="pengarang" name="pengarang"
                                                    value="{{ $siswa }}" disabled placeholder="Pengarang">
                                            </div>
                                        </div>
                                        <div class="col-md-3 peminjam_guru">
                                            <div class="mb-3">
                                                <?php
                                                if ($pinjaman[0]->employee) {
                                                    $employee = $pinjaman[0]->employee->nama_lengkap;
                                                } else {
                                                    $employee = null;
                                                }
                                                ?>
                                                <label for="">Guru/Karyawan <code>*</code></label>
                                                <input type="text" class="form-control" id="pengarang"
                                                    name="pengarang" value="{{ $employee }}" disabled
                                                    placeholder="Pengarang">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tanggal Pinjam <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pinjam"
                                                        placeholder="yyyy-mm-dd" name="tgl_pinjam" id="tgl_pinjam"
                                                        value="{{ $pinjaman[0]->tgl_pinjam }}"
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
                                        <h5 class="card-title">Tambah BUKU</h5>
                                        <div class="col-sm-auto col-md-3">
                                            <select class="form-control select select2" id="buku_id">
                                                <option value="">--Pilih Buku--</option>
                                                @foreach ($buku as $buku)
                                                    <option value="{{ $buku->id }}"
                                                        data-id="{{ $buku->kategori->kode_kategori . ' - ' . $buku->judul }}">
                                                        {{ $buku->kategori->kode_kategori . ' - ' . $buku->judul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-auto col-md-3">
                                            <input type="text" class="form-control number-only" id="jml_buku"
                                                placeholder="Jumlah Buku">
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
                                                        <th class="text-center" style="width: 10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pinjaman as $list)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $list->buku->kategori->kode_kategori . ' - ' . $list->buku->judul }}
                                                            </td>
                                                            <td class="text-center">{{ $list->jml }}</td>
                                                            <td class="text-center">
                                                                <?php $id = Crypt::encryptString($list->id); ?>
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
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a href="{{ route('pinjaman.index') }}"
                                                class="btn btn-secondary waves-effect">Batal</a>
                                            <a class="btn btn-primary" type="submit" style="float: right"
                                                id="submit">Simpan</a>
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
        <!-- modal -->
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

                // initialize header
                kode_transaksi = document.getElementById('kode_transaksi').value;
                milisecond = document.getElementById("milisecond").value;
                peminjam = document.getElementById('peminjaman_old').value;
                tgl_pinjam = document.getElementById("tgl_pinjam").value;
                siswa = document.getElementById("siswa_id_old").value;
                karyawan = document.getElementById("karyawan_id_old").value;
                jenjang = document.getElementById("class_id_old").value;
                $.ajax({
                    type: "POST",
                    url: '{{ route('pinjaman.scanBarcodeEdit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        barcode,
                        kode_transaksi,
                        milisecond,
                        peminjam,
                        tgl_pinjam,
                        siswa,
                        karyawan,
                        jenjang
                    },
                    success: response => {
                        if (response.code == 200) {
                            Swal.fire({
                                title: 'Scan Barcode',
                                text: `${response.message}`,
                                icon: 'success',
                                timer: 1000,
                                willClose: () => {
                                    location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: `${response.message}`,
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

                var settingBarcode = {
                    "barcode": {
                        "status": 'on',
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
            // load karyawan
            var select_peminjam = document.getElementById('peminjam');
            var peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
            if (peminjam == 'Siswa') {
                $('.peminjam_siswa').show();
                $('.peminjam_guru').hide();
            } else if (peminjam == 'Guru' || peminjam == 'Karyawan') {
                $('.peminjam_guru').show();
                $('.peminjam_siswa').hide();
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
        }

        $(document).ready(function() {
            let increment = 0;

            // set localStorage awal
            defaultLocalStorage();

            function defaultLocalStorage() {
                var dataPerpusItems = JSON.parse(localStorage.getItem("localPerpusDharmaBarcode"));
                if (dataPerpusItems == null) {
                    var settingBarcode = {
                        "barcode": {
                            "status": 'off',
                        }
                    };
                    localStorage.setItem('localPerpusDharmaBarcode', JSON.stringify(settingBarcode));
                }
            }

            $("#accordion-button").on('click', function() {
                $('.barcodeScanner').show();
            })

            $("#add").on('click', function() {
                increment++;
                // setStorageLocalItems
                defaultLocalStorage();

                // initialize header
                kode_transaksi = document.getElementById('kode_transaksi').value;
                milisecond = document.getElementById("milisecond").value;
                select_peminjam = document.getElementById('peminjam');
                peminjam = select_peminjam.options[select_peminjam.selectedIndex].value;
                tgl_pinjam = document.getElementById("tgl_pinjam").value;
                siswa = document.getElementById("siswa_id_old").value;
                karyawan = document.getElementById("karyawan_id_old").value;
                jenjang = document.getElementById("class_id_old").value;
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
                    let data_post = []
                    data_post.push({
                        buku_id,
                        jml_buku
                    })

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('pinjaman.store_edit') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            data_post,
                            kode_transaksi,
                            milisecond,
                            peminjam,
                            tgl_pinjam,
                            siswa,
                            karyawan,
                            jenjang
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    'Peminjaman Buku berhasil',
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    url = document.getElementById("url").value;
                                    window.location = APP_URL + '/pinjaman/' + url +
                                        '/edit'
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

                    // null items
                    $('#buku_id').val("").trigger('change')
                    $('#jml_buku').val("")
                }
            })

            $("#submit").on('click', function() {
                kode_transaksi = document.getElementById('kode_transaksi').value;
                tgl_pinjam = document.getElementById("tgl_pinjam").value;

                if (kode_transaksi === '' || tgl_pinjam === '') {
                    Swal.fire(
                        'Gagal',
                        'Tanggal wajib diisi',
                        'error'
                    )
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('pinjaman.post_update') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            kode_transaksi,
                            tgl_pinjam,
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    `${response.message}`,
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    url = document.getElementById("url").value;
                                    window.location = APP_URL + '/pinjaman/' + url +
                                        '/edit'
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
                }
            })

            $(document).on('click', '#get_data_edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content-edit').html(''); // leave it blank before ajax call
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
        });
    </script>
@endsection
