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
                <form class="needs-validation"
                    action="{{ route('pinjaman.update', Crypt::encryptString($pinjaman[0]->kode_transaksi)) }}"
                    method="POST" novalidate>
                    @csrf
                    @method('PATCH')
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
                                                <input type="text" class="form-control" id="pengarang" name="pengarang"
                                                    value="{{ $employee }}" disabled placeholder="Pengarang">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tanggal Pinjam <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pinjam"
                                                        placeholder="yyyy-mm-dd" name="tgl_pinjam" id="tgl_pinjam"
                                                        value="{{ $pinjaman[0]->tgl_pinjam }}" disabled
                                                        data-date-end-date="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Estimasi Kembali <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pinjam"
                                                        placeholder="yyyy-mm-dd" name="tgl_pinjam" id="tgl_pinjam"
                                                        value="{{ $pinjaman[0]->tgl_perkiraan_kembali }}" disabled
                                                        data-date-end-date="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Tanggal Kembali <code>*</code></label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_pinjam"
                                                        placeholder="yyyy-mm-dd" name="tgl_pinjam" id="tgl_pinjam"
                                                        value="{{ $pinjaman[0]->tgl_kembali }}" disabled
                                                        data-date-end-date="{{ date('Y-m-d') }}"
                                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                        data-provide="datepicker" required data-date-autoclose="true">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="table_pinjaman">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">#</th>
                                                        <th class="text-center" style="width: 40%">Buku</th>
                                                        <th class="text-center" style="width: 20%">Jumlah Buku</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pinjaman as $list)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $list->buku->kategori->kode_kategori . ' - ' . $list->buku->judul }}
                                                            </td>
                                                            <td class="text-center">{{ $list->jml }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a href="{{ route('pinjaman.index') }}"
                                                class="btn btn-secondary waves-effect">Kembali</a>
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
    <script>
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
        }
    </script>
@endsection
