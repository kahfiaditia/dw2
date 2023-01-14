@extends('layouts.main')
@section('container')

    <body>
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
                                <form class="needs-validation"
                                    action="{{ route('perawatan.uksProses', $perawatan[0]->kode_perawatan) }}"
                                    method="POST" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Kode Perawatan <code>*</code></label>
                                                <input type="disable" class="form-control" id="kode_perawatan"
                                                    name="kode_perawatan" value="{{ $perawatan[0]->kode_perawatan }}"
                                                    disabled>
                                                <input type="hidden" name="url" id="url"
                                                    value="{{ $perawatan[0]->kode_perawatan }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Siswa <code>*</code></label>
                                                <input type="disable" class="form-control" name="siswa" id="siswa"
                                                    value="{{ $perawatan[0]->siswa->nama_lengkap }}" readonly>
                                                {!! $errors->first('nama_peminjam', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Masuk<code>*</code></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="masuk" id="masuk"
                                                        value="{{ $perawatan[0]->masuk }}" disabled>
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Gejala<code>*</code></label>
                                                <div class="input-group" id="gejala" name="gejala">
                                                    <input type="disable" class="form-control"
                                                        value="{{ $perawatan[0]->gejala }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea type="text" class="form-control" id="desc" disabled placeholder="Keterangan">{{ $perawatan[0]->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Jam Keluar <code>*</code></label>
                                                <div class="input-group" id="timepicker-input-group2">
                                                    <input id="timepicker2" name="keluar" type="text"
                                                        value="{{ date('H:i') }}" class="form-control"
                                                        data-provide="timepicker">
                                                    <span class="input-group-text"><i
                                                            class="mdi mdi-clock-outline"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data diisi.
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Data diisi.
                                                </div>
                                                {!! $errors->first('nama_barang', '<div class="invalid-validasi">:message</div>') !!}
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
                                                        <th class="text-center" style="width: 20%">Qty
                                                        </th>
                                                        <th class="text-center" style="width: 15%">Kadaluarsa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($obat_keluar as $item)
                                                        <tr>
                                                            <td class="text-center" style="width: 5%">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center" style="width: 20%">
                                                                {{ $item->obat }} </td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->total }}</td>
                                                            <td class="text-center" style="width: 15%">
                                                                {{ $item->tgl_ed }} </td>
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
                                            <button class="btn btn-primary approve_confirm" type="submit"
                                                style="float: right" id="add">Siswa Keluar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.approve_confirm').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Selesai Perawatan',
                    text: 'Ingin menyelesaikan perawatan?',
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
