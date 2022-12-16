@extends('layouts.main')
@section('container')

    <body class="myLoad">
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
                <form id="form" class="needs-validation" action="{{ route('perawatan.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 jenjang_siswa">
                                            <div class="mb-3">
                                                <label class="form-label">Jenjang <code>*</code></label>
                                                <select class="form-control select select2 classes" name="jenjang"
                                                    id="jenjang" required>
                                                    <option value="" required>--Pilih Jenjang--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('jenjang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tgl <code>*</code></label>
                                                <div class="input-group" id="datepicker3">
                                                    <input type="text" class="form-control tgl" placeholder="yyyy-mm-dd"
                                                        name="tgl" id="tgl" value="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker3'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('Tanggal', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Masuk <code>*</code></label>
                                                <div class="input-group" id="timepicker-input-group2">
                                                    <input id="timepicker2" type="text" class="form-control"
                                                        data-provide="timepicker">
                                                    <span class="input-group-text"><i
                                                            class="mdi mdi-clock-outline"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                {!! $errors->first('timepicker2', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Gejala</label>
                                                <textarea type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="gejala"
                                                    id="gejala" placeholder="Gejala / Indikasi" required></textarea>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('gejala', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea type="text" class="form-control" style="text-transform:uppercase" id="desc" placeholder="Deskripsi"
                                                    style="text-transform:uppercase" required></textarea>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Obat <code>*</code></label>
                                                <select class="form-control select select2 obat" name="obat"
                                                    id="obat" required>
                                                    <option value="" required>--Pilih Obat--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('jenjang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Kadaluarsa <code>*</code></label>
                                                <select class="form-control select select2 exp" name="exp"
                                                    id="exp" required>
                                                    <option value="" required>--Pilih Kadaluarsa--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('exp', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Kuantiti <code>*</code></label>
                                                <input type="number" min=1 class="form-control" id="qty"
                                                    name="qty" placeholder="Qty Obat" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('qty', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-mb-2">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="tableObat()">Tambah
                                                Obat</a>
                                        </div>
                                        <input type="hidden" id="inputArray">
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tableObat">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">Siswa</th>
                                                        <th class="text-center" style="width: 10%">Tgl</th>
                                                        <th class="text-center" style="width: 10%">Masuk</th>
                                                        <th class="text-center" style="width: 10%">Gejala</th>
                                                        <th class="text-center" style="width: 10%">Deskripsi</th>
                                                        <th class="text-center" style="width: 10%">Obat</th>
                                                        <th class="text-center" style="width: 10%">Kadaluarsa</th>
                                                        <th class="text-center" style="width: 10%">kuantiti</th>
                                                        <th class="text-center" style="width: 10%">Aksi</th>
                                                        </th>
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
        function tableObat() {

            var siswa = document.getElementById('siswa').value;
            var tgl = document.getElementById('tgl').value;
            var jam_masuk = document.getElementById('timepicker2').value;
            var gejala = document.getElementById('gejala').value;
            var desc = document.getElementById('desc').value;
            var obat = document.getElementById('obat').value;
            var exp = document.getElementById('exp').value;
            var qty = document.getElementById('qty').value;

            console.log(siswa);
            console.log(tgl);
            console.log(jam_masuk);
            console.log(gejala);
            console.log(desc);
            console.log(obat);
            console.log(exp);
            console.log(qty);

            document.getElementById('obat').value = '';
            document.getElementById('qty').value = '';



            if (obat == '' || exp == '' || qty == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1900,
                })
            } else if (siswa == '' || gejala == '' || desc == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1900,
                })

            } else {
                $("#tableObat tr:last").after(`
                    <tr>
                        <td class="text-left">${siswa}</td>
                        <td class="text-left">${tgl}</td>
                        <td class="text-left">${jam_masuk}</td>
                        <td class="text-left">${gejala}</td>
                        <td class="text-left">${desc}</td>
                        <td class="text-left">${obat}</td>
                        <td class="text-left">${exp}</td>
                        <td class="text-left">${qty}</td>      
                        <td>
                            <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                        </td>
                             
                    </tr>
                `)
            }
        }

        $("#tableObat").on('click', '.delete-record', function() {
            $(this).parent().parent().remove()
        })

        $(document).ready(function() {
            //fungsi hapus


            $("#save").on('click', function() {
                let dataperawatan = []

                $("#tableObat").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        siswa = tableData.eq(0).text(),
                        tgl = tableData.eq(1).text(),
                        jam_masuk = tableData.eq(2).text(),
                        gejala = tableData.eq(3).text(),
                        desc = tableData.eq(4).text(),
                        obat = tableData.eq(5).text(),
                        qty = tableData.eq(7).text(),
                        exp = tableData.eq(6).text()


                    //ini filter data null
                    if (siswa != '') {
                        dataperawatan.push({
                            siswa,
                            tgl,
                            jam_masuk,
                            gejala,
                            desc,
                            obat,
                            exp,
                            qty
                        });
                    }
                    console.log(dataperawatan)
                })

                jQuery.ajax({
                    type: "POST",
                    url: '{{ route('perawatan.store') }}',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        dataperawatan
                    },
                    success: (response) => {
                        console.log(response)
                        if (response.code === 200) {
                            Swal.fire(
                                'Success',
                                'Data Perawatan Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/uks/perawatan'
                            })
                        } else {
                            // console.log(response)
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanda * (bintang) wajib 22222',
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
                window.location = APP_URL + '/uks/perawatan'
            })

            $.ajax({
                type: "POST",
                url: '{{ route('invoice.get_jenjang') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    // console.log(response)
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

                        $('.classes').append(
                            `<option value="${item.id}" >${item.level+' '+classes+' '+jurusan+' '+type}</option>`
                        )

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

                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });

            $.ajax({
                type: "POST",
                url: '{{ route('perawatan.get_obat') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    // console.log(response)
                    $.each(response.data, function(i, item) {
                        if (item.obat) {
                            obat = item.obat;
                        } else {
                            obat = '';
                        }

                        $('.obat').append(
                            `<option value="${item.id}" >${item.obat}</option>`
                        )

                    })
                },
                error: (err) => {
                    // console.log(err);
                },
            });

            $(".obat").change(function() {
                let class_obat = $(this).val();
                $(".exp option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('perawatan.get_exp') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_obat
                    },
                    success: response => {
                        console.log(response)
                        $('.exp').append(`<option value="">-- Pilih Expired --</option>`)
                        $.each(response.data, function(i, item) {
                            $('.exp').append(
                                `<option value="${item.id}" >${item.tgl_ed}</option>`
                            )
                        })

                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        })

        $("#tablePinjam").on('click', '.delete-record', function() {
            $(this).parent().parent().remove()
        })
    </script>
@endsection
