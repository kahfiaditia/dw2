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
                                            <input type="disable" class="form-control" name="siswa" id="siswa"
                                                value="{{ $perawatan[0]->siswa->nama_lengkap }}" readonly>
                                            {{-- <input type="disable" class="form-control" name="siswa" id="siswa"
                                                value="{{ $perawatan[0]->users->id }}" hidden> --}}
                                            {!! $errors->first('nama_peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3 wajib">
                                        <div class="mb-3">
                                            <label>Tanggal<code>*</code></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="tgl" id="tgl"
                                                    value="{{ $perawatan[0]->tgl }}" disabled>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                            </div>
                                            {!! $errors->first('tgl', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3 wajib">
                                        <div class="mb-3">
                                            <label>Jam Masuk<code>*</code></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="masuk" id="masuk"
                                                    value="{{ $perawatan[0]->masuk }}" disabled>
                                                <input type="text" class="form-control" name="id_stok_obat"
                                                    id="id_stok_obat" value="{{ $perawatan[0]->id_stok_obat }}" hidden>
                                                <input type="text" class="form-control" name="qty" id="qty"
                                                    value="{{ $perawatan[0]->qty }}" hidden>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row wajib">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Keluar <code>*</code></label>
                                                <div class="input-group" id="timepicker-input-group2">
                                                    <input id="timepicker2" name="keluar" type="text"
                                                        class="form-control" data-provide="timepicker">
                                                    <span class="input-group-text"><i
                                                            class="mdi mdi-clock-outline"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('nama_barang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="row modal-footer">
                                            <div class="col-sm-12">
                                                {{-- <button class="btn btn-primary" type="submit" style="float: left"
                                                    id="add">Siswa Keluar</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tableList">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">No</th>
                                                        <th class="text-center" style="width: 20%">Obat
                                                        </th>
                                                        <th class="text-center" style="width: 15%">Qty</th>
                                                        <th class="text-center" style="width: 15%">Kadaluarsa</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($perawatan as $item)
                                                        <tr>
                                                            <td class="text-center" style="width: 5%">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center" style="width: 20%">
                                                                {{ $item->uks_obat->obat }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->qty }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->stok_obat->tgl_ed }}</td>
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
                                            {{-- <a href="{{ route('perawatan.index') }}" class="btn btn-primary"
                                                type="submit" style="float: right">Simpan</a> --}}
                                            <button class="btn btn-primary" type="submit" style="float: right"
                                                id="add">Siswa Keluar</button>
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

            var keluar = document.getElementById('timepicker2').value;
            var kode_perawatan = document.getElementById('kode_perawatan').value;
            var id_stok_obat = document.getElementById('id_stok_obat').value;
            var qty = document.getElementById('qty').value;

            console.log(keluar)
            console.log(kode_perawatan)
            console.log(id_stok_obat)
            console.log(qty)


            if (keluar === '') {
                Swal.fire(
                    'Gagal',
                    'Inventaris yang dipinjam wajib diisi',
                    'error'
                )
            } else {
                let data_keluar = []
                data_keluar.push({
                    keluar,
                    kode_perawatan,
                    id_stok_obat,
                    qty
                })

                $.ajax({
                    type: 'POST',
                    url: '{{ route('perawatan.uksProses', $perawatan[0]->kode_perawatan) }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        data_keluar,
                        keluar,
                    },

                    success: (response) => {
                        console.log(response)
                        if (response.code === 200) {
                            Swal.fire(
                                'Success',
                                'Jam Keluar telah berhasil di input',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                url = document.getElementById("url").value;
                                window.location = APP_URL + '/uks/perawatan/'
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
            var url = "{{ route('inv_pinjaman.edit_barang') }}"
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
    </script>
@endsection
