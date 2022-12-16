@extends('layouts.main')
@section('container')

    <body class="InvPinjam()">
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

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 peminjam">
                                        <div class="mb-3">
                                            <label>Kode Perawatan <code>*</code></label>
                                            <input type="disable" class="form-control" id="kode_perawatan"
                                                name="kode_perawatan" value="{{ $perawatan[0]->kode_perawatan }}" disabled>
                                            <input type="hidden" name="url" id="url"
                                                value="{{ $perawatan[0]->kode_perawatan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 peminjam">
                                        <div class="mb-3">
                                            <label>Siswa <code>*</code></label>
                                            <input type="disable" class="form-control" name="nama_siswa" id="nama_siswa"
                                                value="{{ $perawatan[0]->siswa->nama_lengkap }}" readonly>
                                            <input type="disable" class="form-control" name="id_siswa" id="id_siswa"
                                                value="{{ $perawatan[0]->siswa->id }}" hidden>
                                            {!! $errors->first('nama_peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3 wajib">
                                        <div class="mb-3">
                                            <label>Tanggal Masuk UKS <code>*</code></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="tgl" id="tgl"
                                                    value="{{ $perawatan[0]->tgl }}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                            </div>
                                            {!! $errors->first('tgl', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3 wajib">
                                        <div class="mb-3">
                                            <label>Jam Masuk <code>*</code></label>
                                            <div class="input-group" id="timepicker-input-group2">
                                                <input id="timepicker2" type="text" class="form-control"
                                                    data-provide="timepicker">
                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Gejala</label>
                                            <textarea type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="gejala"
                                                id="gejala" name="gejala" value="{{ $perawatan[0]->gejala }}" required>{{ $perawatan[0]->gejala }}</textarea>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('gejala', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Deskripsi Perawatan</label>
                                            <textarea type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="desc"
                                                id="desc" name="desc" required>{{ $perawatan[0]->deksripsi }}</textarea>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('gejala', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row wajib">
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
                                                    <option value="" required>--Pilih Expired--</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('exp', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Kuantiti Obat <code>*</code></label>
                                                <div class="input-group">
                                                    <input type="number" min=1 class="form-control" name="qty"
                                                        id="qty" placeholder="Masukan jumlah obat">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row modal-footer">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary" type="submit" style="float: left"
                                                    id="add">Tambah Obat</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table
                                                class="table table-responsive table-bordered table table-striped nowrap w-100"
                                                id="tableList">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">No</th>
                                                        <th class="text-center" style="width: 20%">Obat
                                                        </th>
                                                        <th class="text-center" style="width: 15%">Expired</th>
                                                        <th class="text-center" style="width: 15%">qty</th>
                                                        <th class="text-center" style="width: 15%">Aksi</th>
                                                        <th class="text-center" hidden>{{ Auth::user()->id }}></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($perawatan as $item)
                                                        <tr>
                                                            <td class="text-center" style="width: 10%">
                                                                {{ $loop->iteration }}</td>

                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->uks_obat->obat }}</td>

                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->stok_obat->tgl_ed }}</td>

                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->qty }}</td>

                                                            <td class="text-center">

                                                                <?php $id = $item->id; ?>
                                                                <form class="delete-form"
                                                                    action="{{ route('perawatan.destroy_obat', $id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <div class="d-flex gap-3">
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
                                            <a href="{{ route('perawatan.index') }}"
                                                class="btn btn-secondary waves-effect">Kembali</a>
                                            <a href="{{ route('perawatan.index') }}" class="btn btn-primary"
                                                type="submit" style="float: right">Simpan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>

            <!-- modal -->
            <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
    <script>
        $("#add").on('click', function() {

            var kode_perawatan = document.getElementById('kode_perawatan').value;
            var nama_siswa = document.getElementById("nama_siswa").value;
            var gejala = document.getElementById("gejala").value;
            var desc = document.getElementById("desc").value;
            var id_siswa = document.getElementById("id_siswa").value;
            var tgl = document.getElementById('tgl').value;;
            var jam_masuk = document.getElementById('timepicker2').value;;
            var qty = document.getElementById("qty").value;
            var obat = document.getElementById("obat").value;
            var exp = document.getElementById("exp").value;


            console.log(kode_perawatan)
            console.log(id_siswa)
            console.log(gejala)
            console.log(desc)
            console.log(tgl)
            console.log(jam_masuk)
            console.log(obat)
            console.log(exp)


            if (nama_siswa === '') {
                Swal.fire(
                    'Gagal',
                    'Obat wajib diisi',
                    'error'
                )
            } else {
                let data_post = []
                data_post.push({
                    obat,
                })

                $.ajax({
                    type: 'POST',
                    url: '{{ route('perawatan.update_obat') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        data_post,
                        kode_perawatan,
                        nama_siswa,
                        id_siswa,
                        tgl,
                        jam_masuk,
                        gejala,
                        desc,
                        qty,
                        obat,
                        exp
                    },

                    success: (response) => {
                        if (response.code === 200) {
                            Swal.fire(
                                'Success',
                                'Perawatan Siswa berhasil',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                url = document.getElementById("url").value;
                                window.location = APP_URL + '/uks/perawatan/' + url +
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
                    error: err => console.log(err)
                })

            }

        })

        $(document).on('click', '#get_data_edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // it will get id of clicked row
            $('#dynamic-content-edit').html(''); // leave it blank before ajax call
            $('#modal-loader').show(); // load ajax loader
            var url = ""
            $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id
                    }

                })
                .done(function(url1) {
                    $('#dynamic-content-edit').html(url1); // load response
                    $('#modal-loader').hide(); // hide ajax loader
                })
                .fail(function(err) {
                    $('#dynamic-content').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });

        });

        $(document).ready(function() {
            //fungsi hapus
            $("#tableObat").on('click', '.delete-record', function() {
                $(this).parent().parent().remove()
            })

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
    </script>
@endsection
