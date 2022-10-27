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
                <form class="needs-validation" action="{{ route('employee.update_ijazah') }}" enctype="multipart/form-data"
                    method="POST" novalidate>
                    @csrf
                    <?php $id = Crypt::encryptString($item->id); ?>
                    <?php $karyawan_id = Crypt::encryptString($item->karyawan_id); ?>
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="karyawan_id" value="{{ $karyawan_id }}">
                    <div class="row">
                        @if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')
                            <?php $device = 'style="display:none;"';
                            $column = '12'; ?>
                        @else
                            <?php $device = '';
                            $column = '10'; ?>
                        @endif
                        <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Karyawan</p>
                                </a>
                                <a class="nav-link active">
                                    <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Ijazah</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">SK Pengangkatan</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Jumlah Anak</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-phone check-nav-icon mt-2"></i>
                                    <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Riwayat Penyakit</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-<?php echo $column; ?> col-sm-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                    aria-labelledby="v-pills-shipping-tab">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom02" class="form-label">Jenis
                                                            <code>*</code></label>
                                                        <select class="form-control select select2" name="type"
                                                            id="type" required>
                                                            <option value="">--Pilih Jenis--</option>
                                                            <option value="Akademik"
                                                                {{ $item->type === 'Akademik' ? 'selected' : '' }}>
                                                                Akademik</option>
                                                            <option value="Non Akademik"
                                                                {{ $item->type === 'Non Akademik' ? 'selected' : '' }}>Non
                                                                Akademik</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                        {!! $errors->first('type', '<div class="invalid-validasi">:message</div>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">Dokumen
                                                            Sertifikat/Ijazah (Max 2 Mb) <code>*</code></label>
                                                        <input class="form-control dok_ijazah" type="file"
                                                            name="dok_ijazah" id="dok_ijazah">
                                                        @if ($item->dok_ijazah)
                                                            <a href="javascript:void(0)"
                                                                data-id="{{ $item->dok_ijazah . '|ijazah|ijazah' }}"
                                                                id="get_data_dok" data-bs-toggle="modal"
                                                                data-bs-target=".bs-example-modal-lg-dok">
                                                                <i
                                                                    class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                Dokumen
                                                            </a>
                                                            <input type="hidden" name="dok_ijazah_old"
                                                                value="{{ $item->dok_ijazah }}">
                                                        @endif
                                                        <div class="invalid-feedback">
                                                            Data wajib diisi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button fw-medium headAkademik"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne" aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                            Akademik
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse akademik show"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="text-muted">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Nama
                                                                                Sekolah/Universitas <code>*</code></label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama_pendidikan"
                                                                                name="nama_pendidikan"
                                                                                value="{{ $item->nama_pendidikan }}"
                                                                                required autofocus
                                                                                placeholder="Nama Sekolah/Universitas">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('nama_pendidikan', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar
                                                                                <code>*</code></label>
                                                                            <select class="form-control select select2"
                                                                                name="gelar_ijazah" id="gelar_ijazah"
                                                                                required>
                                                                                <option value="">--Pilih Gelar--
                                                                                </option>
                                                                                @foreach ($jurusan as $jurusan)
                                                                                    <option value="{{ $jurusan }}"
                                                                                        {{ $item->gelar_ijazah === $jurusan ? 'selected' : '' }}>
                                                                                        {{ $jurusan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_ijazah', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Jurusan
                                                                                <code>*</code></label>
                                                                            <input type="text" class="form-control"
                                                                                id="jurusan" name="jurusan"
                                                                                value="{{ $item->jurusan }}" required
                                                                                placeholder="Jurusan">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('jurusan', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Tahun Pendidikan <code>*</code></label>
                                                                            <div class="input-daterange input-group">
                                                                                <input type="text"
                                                                                    style="padding: 7px;"
                                                                                    class="form-control datepicker"
                                                                                    name="tahun_masuk"
                                                                                    value="{{ $item->tahun_masuk }}"
                                                                                    maxlength="4"
                                                                                    placeholder="Tahun Masuk"
                                                                                    id="tahun_masuk" required>
                                                                                <input type="text"
                                                                                    class="form-control datepicker"
                                                                                    name="tahun_lulus"
                                                                                    value="{{ $item->tahun_lulus }}"
                                                                                    maxlength="4"
                                                                                    placeholder="Tahun Lulus"
                                                                                    id="tahun_lulus" required>
                                                                                <div class="invalid-feedback">
                                                                                    Data wajib diisi.
                                                                                </div>
                                                                                {!! $errors->first('tahun_lulus', '<div class="invalid-validasi">:message</div>') !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar
                                                                                Akademik Panjang</label>
                                                                            <input type="text" class="form-control"
                                                                                id="gelar_akademik_panjang"
                                                                                name="gelar_akademik_panjang"
                                                                                value="{{ $item->gelar_akademik_panjang }}"
                                                                                placeholder="Gelar Akademik Panjang">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_akademik_panjang', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar
                                                                                Akademik Pendek</label>
                                                                            <input type="text" class="form-control"
                                                                                id="gelar_akademik_pendek"
                                                                                name="gelar_akademik_pendek"
                                                                                value="{{ $item->gelar_akademik_pendek }}"
                                                                                placeholder="Gelar Akademik Pendek">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_akademik_pendek', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button fw-medium headNonAkademik "
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                                            aria-controls="collapseTwo">
                                                            Non Akademik
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse non show"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="text-muted">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Nama
                                                                                Instansi/Lembaga Penerbit Sertifikat
                                                                                <code>*</code></label>
                                                                            <input type="text" class="form-control"
                                                                                id="instansi" name="instansi"
                                                                                value="{{ $item->instansi }}" required
                                                                                placeholder="Nama Instansi/Lembaga Penerbit Sertifikat">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('instansi', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar
                                                                                <code>*</code></label>
                                                                            <select class="form-control select select2"
                                                                                name="gelar_ijazah_non"
                                                                                id="gelar_ijazah_non" required>
                                                                                <option value="">--Pilih Gelar--
                                                                                </option>
                                                                                @foreach ($jurusan_non as $jurusan)
                                                                                    <option value="{{ $jurusan }}"
                                                                                        {{ $item->gelar_ijazah === $jurusan ? 'selected' : '' }}>
                                                                                        {{ $jurusan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_ijazah_non', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar Non
                                                                                Akademik Panjang</label>
                                                                            <input type="text" class="form-control"
                                                                                id="gelar_non_akademik_panjang"
                                                                                name="gelar_non_akademik_panjang"
                                                                                value="{{ $item->gelar_non_akademik_panjang }}"
                                                                                placeholder="Gelar Non Akademik Panjang">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_non_akademik_panjang', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom02"
                                                                                class="form-label">Gelar Non
                                                                                Akademik Pendek</label>
                                                                            <input type="text" class="form-control"
                                                                                id="gelar_non_akademik_pendek"
                                                                                name="gelar_non_akademik_pendek"
                                                                                value="{{ $item->gelar_non_akademik_pendek }}"
                                                                                placeholder="Gelar Non Akademik Pendek">
                                                                            <div class="invalid-feedback">
                                                                                Data wajib diisi.
                                                                            </div>
                                                                            {!! $errors->first('gelar_non_akademik_pendek', '<div class="invalid-validasi">:message</div>') !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('employee.ijazah', ['id' => $karyawan_id]) }}"
                                                        class="btn btn-secondary waves-effect">Cancel</a>
                                                    <button class="btn btn-primary" type="submit" style="float: right"
                                                        id="submit">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg-dok" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dynamic-content-dok"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            // valdasi extension
            $('#dok_ijazah').bind('change', function() {
                var file = document.querySelector("#dok_ijazah");
                if (/\.(jpe?g|png|jpg|pdf)$/i.test(file.files[0].name) === false) {
                    Swal.fire(
                        'Gagal',
                        'Tipe dokumen yang diperbolehkan jpeg, png, jpg, pdf',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_ijazah').value = null;
                } else {
                    var size = this.files[0].size / 1000;
                    if (size > 2000) {
                        Swal.fire(
                            'Gagal',
                            'Maksimal ukuran 2 MB',
                            'error'
                        ).then(function() {})
                        document.getElementById('dok_ijazah').value = null;
                    }
                }
            });

            $(".datepicker").change(function() {
                let tahun_masuk = document.getElementById("tahun_masuk").value;
                let tahun_lulus = document.getElementById("tahun_lulus").value;
                if (tahun_lulus < tahun_masuk && tahun_lulus != '') {
                    Swal.fire(
                        'Gagal',
                        'Tahun masuk tidak boleh lebih besar dari tahun lulus',
                        'error'
                    ).then(function() {
                        document.getElementById("submit").disabled = true;
                        document.getElementById("tahun_lulus").value = null;
                    })
                } else {
                    document.getElementById("submit").disabled = false;
                }
            });

            $(document).on('click', '#get_data_dok', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content-dok').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.dokumen') }}"
                $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        }
                    })
                    .done(function(url) {
                        $('#dynamic-content-dok').html(url); // load response
                        $('#modal-loader').hide(); // hide ajax loader
                    })
                    .fail(function(err) {
                        $('#dynamic-content').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });
            });

            $('#gelar_ijazah').bind('change', function() {
                let gelar_ijazah = document.getElementById("gelar_ijazah").value;
                if (gelar_ijazah === 'SD' || gelar_ijazah === 'SMP') {
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                    document.getElementById("jurusan").required = false;
                } else if (gelar_ijazah === 'SMA' || gelar_ijazah === 'SMK') {
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                    document.getElementById("jurusan").required = true;
                } else {
                    document.getElementById("gelar_akademik_panjang").required = true;
                    document.getElementById("gelar_akademik_pendek").required = true;
                    document.getElementById("jurusan").required = true;
                }
            });

            $('#gelar_ijazah_non').bind('change', function() {
                let gelar_ijazah_non = document.getElementById("gelar_ijazah_non").value;
                if (gelar_ijazah_non === 'Kursus' || gelar_ijazah_non === 'Seminar') {
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                    document.getElementById("jurusan").required = false;
                }
            });

            $('#type').bind('change', function() {
                let type = document.getElementById("type").value;
                if (type === 'Akademik') {
                    $('.akademik').addClass('show');
                    $('.non').removeClass('show');
                    $('.headNonAkademik').addClass('collapsed');
                    // non required
                    document.getElementById("gelar_non_akademik_panjang").required = false;
                    document.getElementById("gelar_non_akademik_pendek").required = false;
                    document.getElementById("gelar_ijazah_non").required = false;
                    document.getElementById("instansi").required = false;
                    // required
                    document.getElementById("nama_pendidikan").required = true;
                    document.getElementById("gelar_ijazah").required = true;
                    document.getElementById("tahun_masuk").required = true;
                    document.getElementById("tahun_lulus").required = true;
                    // cek gelar yg dipilih apa 
                    let gelar_ijazah = document.getElementById("gelar_ijazah").value;
                    if (gelar_ijazah === 'SD' || gelar_ijazah === 'SMP') {
                        document.getElementById("gelar_akademik_panjang").required = false;
                        document.getElementById("gelar_akademik_pendek").required = false;
                        document.getElementById("jurusan").required = false;
                    } else if (gelar_ijazah === 'SMA' || gelar_ijazah === 'SMK') {
                        document.getElementById("gelar_akademik_panjang").required = false;
                        document.getElementById("gelar_akademik_pendek").required = false;
                        document.getElementById("jurusan").required = true;
                    } else {
                        document.getElementById("gelar_akademik_panjang").required = true;
                        document.getElementById("gelar_akademik_pendek").required = true;
                        document.getElementById("jurusan").required = true;
                    }
                } else if (type === 'Non Akademik') {
                    $('.akademik').removeClass('show');
                    $('.non').addClass('show');
                    $('.headAkademik').addClass('collapsed');
                    // required
                    document.getElementById("gelar_non_akademik_panjang").required = true;
                    document.getElementById("gelar_non_akademik_pendek").required = true;
                    document.getElementById("gelar_ijazah_non").required = true;
                    document.getElementById("instansi").required = true;
                    // non required
                    document.getElementById("nama_pendidikan").required = false;
                    document.getElementById("gelar_ijazah").required = false;
                    document.getElementById("jurusan").required = false;
                    document.getElementById("tahun_masuk").required = false;
                    document.getElementById("tahun_lulus").required = false;
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                }
            });

            // start onload
            let type = document.getElementById("type").value;
            if (type === 'Akademik') {
                $('.akademik').addClass('show');
                $('.non').removeClass('show');
                $('.headNonAkademik').addClass('collapsed');
                // non required
                document.getElementById("gelar_non_akademik_panjang").required = false;
                document.getElementById("gelar_non_akademik_pendek").required = false;
                document.getElementById("gelar_ijazah_non").required = false;
                document.getElementById("instansi").required = false;
                // required
                document.getElementById("nama_pendidikan").required = true;
                document.getElementById("gelar_ijazah").required = true;
                document.getElementById("tahun_masuk").required = true;
                document.getElementById("tahun_lulus").required = true;

                let gelar_ijazah = document.getElementById("gelar_ijazah").value;
                if (gelar_ijazah === 'SD' || gelar_ijazah === 'SMP') {
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                    document.getElementById("jurusan").required = false;
                } else if (gelar_ijazah === 'SMA' || gelar_ijazah === 'SMK') {
                    document.getElementById("gelar_akademik_panjang").required = false;
                    document.getElementById("gelar_akademik_pendek").required = false;
                    document.getElementById("jurusan").required = true;
                } else {
                    document.getElementById("gelar_akademik_panjang").required = true;
                    document.getElementById("gelar_akademik_pendek").required = true;
                    document.getElementById("jurusan").required = true;
                }
            } else if (type === 'Non Akademik') {
                $('.akademik').removeClass('show');
                $('.non').addClass('show');
                $('.headAkademik').addClass('collapsed');
                // required
                document.getElementById("gelar_non_akademik_panjang").required = true;
                document.getElementById("gelar_non_akademik_pendek").required = true;
                document.getElementById("gelar_ijazah_non").required = true;
                document.getElementById("instansi").required = true;
                // non required
                document.getElementById("nama_pendidikan").required = false;
                document.getElementById("gelar_ijazah").required = false;
                document.getElementById("jurusan").required = false;
                document.getElementById("tahun_masuk").required = false;
                document.getElementById("tahun_lulus").required = false;
                document.getElementById("gelar_akademik_panjang").required = false;
                document.getElementById("gelar_akademik_pendek").required = false;
            }
            // end onload
        });
    </script>
@endsection
