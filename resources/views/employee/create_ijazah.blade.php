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
        <?php preg_match('/(chrome|firefox|avantgo|blackberry|android|blazer|elaine|hiptop|iphone|ipod|kindle|midp|mmp|mobile|o2|opera mini|palm|palm os|pda|plucker|pocket|psp|smartphone|symbian|treo|up.browser|up.link|vodafone|wap|windows ce; iemobile|windows ce; ppc;|windows ce; smartphone;|xiino)/i', $_SERVER['HTTP_USER_AGENT'], $version) ?>
        <div class="checkout-tabs">
            <form class="needs-validation" action="{{ route("employee.store_ijazah") }}" enctype="multipart/form-data" method="POST" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="row">
                    @if($version[1] == "Android" || $version[1] == 'Mobile' || $version[1] == 'iPhone' )
                        <?php $device = 'style="display:none;"'; $column = '12'; ?>
                    @else
                        <?php $device = ''; $column = '10'; ?>
                    @endif
                    <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link">
                                <i class= "bx bxs-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Karyawan</p>
                            </a>
                            <a class="nav-link active">
                                <i class= "bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Ijazah</p>
                            </a>
                            <a class="nav-link">
                                <i class= "bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link">
                                <i class= "bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Jumlah Anak</p>
                            </a>
                            <a class="nav-link">
                                <i class= "bx bx-phone check-nav-icon mt-2"></i>
                                <i class= "bx bx-plus-medical check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Nama Sekolah/Universitas <code>*</code></label>
                                                    <input type="text" class="form-control" id="nama_pendidikan" name="nama_pendidikan" value="{{old('nama_pendidikan')}}" required autofocus
                                                        placeholder="Nama Sekolah/Universitas">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('nama_pendidikan', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Gelar <code>*</code></label>
                                                    <select class="form-control select select2" name="gelar_ijazah" id="gelar_ijazah" required>
                                                        <option value="">--Pilih Gelar--</option>
                                                        @foreach ($jurusan as $jurusan)
                                                            <option value="{{ $jurusan }}">{{ $jurusan }}</option>
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
                                                    <label for="validationCustom02" class="form-label">Jurusan <code>*</code></label>
                                                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required
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
                                                        <input type="text" class="form-control datepicker" name="tahun_masuk" maxlength="4" placeholder="Tahun Masuk" id="tahun_masuk" required>
                                                        <input type="text" class="form-control datepicker" name="tahun_lulus" maxlength="4" placeholder="Tahun Lulus" id="tahun_lulus" required>
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
                                                    <label for="validationCustom02" class="form-label">Gelar Akademik Panjang</label>
                                                    <input type="text" class="form-control" id="gelar_akademik_panjang" name="gelar_akademik_panjang" value="{{old('gelar_akademik_panjang')}}"
                                                        placeholder="Gelar Akademik Panjang">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('gelar_akademik_panjang', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Gelar Akademik Pendek</label>
                                                    <input type="text" class="form-control" id="gelar_akademik_pendek" name="gelar_akademik_pendek" value="{{ old('gelar_akademik_pendek') }}"
                                                        placeholder="Gelar Akademik Pendek">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('gelar_akademik_pendek', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Gelar Non Akademik Panjang</label>
                                                    <input type="text" class="form-control" id="gelar_non_akademik_panjang" name="gelar_non_akademik_panjang" value="{{old('gelar_non_akademik_panjang')}}"
                                                        placeholder="Gelar Non Akademik Panjang">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('gelar_non_akademik_panjang', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Gelar Non Akademik Pendek</label>
                                                    <input type="text" class="form-control" id="gelar_non_akademik_pendek" name="gelar_non_akademik_pendek" value="{{ old('gelar_non_akademik_pendek') }}"
                                                        placeholder="Gelar Non Akademik Pendek">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('gelar_non_akademik_pendek', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom02" class="form-label">Nama Instansi/Lembaga Penerbit Sertifikat</label>
                                                    <input type="text" class="form-control" id="instansi" name="instansi" value="{{old('instansi')}}"
                                                        placeholder="Nama Instansi/Lembaga Penerbit Sertifikat">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('instansi', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Dokumen SK</label>
                                                    <input class="form-control dok_ijazah" type="file" name="dok_ijazah" id="dok_ijazah">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                    {!! $errors->first('instansi', '<div class="invalid-validasi">:message</div>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-6">
                                                <a href="{{ route('employee.ijazah',['id' => $id]) }}" class="btn btn-secondary waves-effect">Cancel</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-sm-end mt-2 mt-sm-0">
                                                    <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                                                </div>
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
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/alert.js') }}"></script>
<script>
    $(document).ready(function(){
        // valdasi extension
        $('#dok_ijazah').bind('change', function() {
            var file = document.querySelector("#dok_ijazah");
            if (/\.(jpe?g|png|jpg)$/i.test(file.files[0].name) === false) {
                Swal.fire(
                    'Gagal',
                    'Tipe dokumen yang diperbolehkan jpeg, png ,jpg',
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

        $(".datepicker").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
        });
        
        $(".datepicker").change(function(){
            let tahun_masuk = document.getElementById("tahun_masuk").value;
            let tahun_lulus = document.getElementById("tahun_lulus").value;
            if(tahun_lulus < tahun_masuk && tahun_lulus != ''){
                Swal.fire(
                    'Gagal',
                    'Tahun masuk tidak boleh lebih besar dari tahun lulus',
                    'error'
                ).then(function() {
                    document.getElementById("submit").disabled = true;
                })
            }else{
                document.getElementById("submit").disabled = false;
            }
        });
        
        $('#gelar_ijazah').bind('change', function() {
            let gelar_ijazah = document.getElementById("gelar_ijazah").value;
            if(gelar_ijazah === 'SD' || gelar_ijazah === 'SMP' || gelar_ijazah === 'SMA' || gelar_ijazah === 'SMK'){
                document.getElementById("gelar_akademik_panjang").required = false;
                document.getElementById("gelar_akademik_pendek").required = false;
            }else{
                document.getElementById("gelar_akademik_panjang").required = true;
                document.getElementById("gelar_akademik_pendek").required = true;
            }
        });
    });
</script>
@endsection
