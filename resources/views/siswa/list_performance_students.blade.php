@extends('layouts.main')
@section('container')
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
            {{-- cek device moblie atau bukan --}}
            <?php preg_match('/(chrome|firefox|avantgo|blackberry|android|blazer|elaine|hiptop|iphone|ipod|kindle|midp|mmp|mobile|o2|opera mini|palm|palm os|pda|plucker|pocket|psp|smartphone|symbian|treo|up.browser|up.link|vodafone|wap|windows ce; iemobile|windows ce; ppc;|windows ce; smartphone;|xiino)/i', $_SERVER['HTTP_USER_AGENT'], $version); ?>
            <div class="checkout-tabs">

                <div class="row">
                    @if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')
                        <?php $device = 'style="display:none;"';
                        $column = '12'; ?>
                    @else
                        <?php $device = '';
                        $column = '10'; ?>
                    @endif
                    @include('siswa.student_menu')
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                    <div class="page-title-left"></div>
                                                    <div class="page-title-right">
                                                        <ol class="breadcrumb m-0">
                                                            <a id="modal_trigger" data-toggle="modal"
                                                                data-target="#exampleModalLong" type="button"
                                                                class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                                                <i class="mdi mdi-plus me-1"></i> Tambah Prestasi
                                                            </a>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table id="datatable"
                                                            class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">Jenis Prestasi</th>
                                                                    <th class="text-center">Tingkat
                                                                    </th>
                                                                    <th class="text-center">Nama Prestasi</th>
                                                                    <th class="text-center">Tahun Prestasi</th>
                                                                    <th class="text-center">Penyelenggara</th>
                                                                    <th class="text-center">Peringkat</th>
                                                                    <th class="text-center">Opsi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($performances as $performance)
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            {{ $loop->iteration }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->jenis_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->tingkat_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->nama_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->tahun_prestasi }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->penyelenggara }}</td>
                                                                        <td class="text-center">
                                                                            {{ $performance->peringkat }}</td>
                                                                        <td class="text-center">
                                                                            <form
                                                                                action="{{ route('siswa.destroy_performance_student', \Crypt::encryptString($performance->id)) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <div class="d-flex gap-3">
                                                                                    <a href="{{ route('siswa.edit_performance_student', \Crypt::encryptString($performance->id)) }}"
                                                                                        class="text-success"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="edit"><i
                                                                                            class="mdi mdi-pencil font-size-18"></i></a>
                                                                                    <a href="#"
                                                                                        class="text-danger delete_confirm"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="hapus"><i
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
                                                        <a href="{{ route('siswa.show_periodic', \Crypt::encryptString($student->id)) }}"
                                                            class="btn btn-secondary waves-effect">Kembali</a>
                                                        <a href="{{ route('siswa.index_beasiswa_student', Crypt::encryptString($student->id)) }}"
                                                            style="float: right" class="btn btn-primary">Selanjutnya</a>
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
        </div>

        <div class="modal fade" id="modal_performance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Prestasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('siswa.store_performances') }}">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jenis Prestasi</label>
                                        <select name="jenis_prestasi" id="jenis" required class="form-control">
                                            <option value="">-- Pilih Jenis Prestasi --</option>
                                            <option value="Sains">Sains</option>
                                            <option value="Seni">Seni</option>
                                            <option value="Olahraga">Olahraga</option>
                                            <option value="Lain-lain">Lain-lain</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tingkat Prestasi</label>
                                        <select name="tingkat_prestasi" id="tingkat" class="form-control" required>
                                            <option value="">-- Pilih Tingkat Prestasi --</option>
                                            <option value="Sekolah">Sekolah</option>
                                            <option value="Kecamatan">Kecamatan</option>
                                            <option value="Kabupaten">Kabupaten</option>
                                            <option value="Provinsi">Provinsi</option>
                                            <option value="Nasional">Nasional</option>
                                            <option value="Internasional">Internasional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Nama Prestasi</label>
                                        <input type="text" class="form-control" name="nama_prestasi"
                                            placeholder="Nama Prestasi" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Tahun Prestasi</label>
                                        <input type="text" class="number-only form-control" name="tahun_prestasi"
                                            placeholder="Tahun Prestasi" maxlength="4" minlength="4" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Penyelenggara</label>
                                        <input type="text" class="form-control" name="penyelenggara"
                                            placeholder="Peneyelenggara" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Peringkat</label>
                                        <input type="text" class="number-only form-control" name="peringkat"
                                            placeholder="peringkat" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancel" class="btn btn-secondary"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#modal_trigger").on('click', function() {
            $("#modal_performance").modal('show')
        })

        $("#cancel").on('click', function() {
            $("#modal_performance").modal('toggle')
        })
    </script>
@endsection
