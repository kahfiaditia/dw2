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
                <form class="needs-validation" action="{{ route('siswa.update', 1) }}" enctype="multipart/form-data"
                    method="POST" novalidate>
                    @csrf
                    @method('PATCH')
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
                                <a href="{{ route('siswa.edit', $student_id) }}"
                                    class="nav-link @if ($submenu == 'siswa') active @endif">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Pribadi</p>
                                </a>
                                <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                    href="{{ route('siswa.edit_parents', 1) }}">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                    <p class="fw-bold mb-4">Orang Tua</p>
                                </a>
                                <a class="nav-link">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Wali</p>
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
                                                <div class="col-sm-4">
                                                    <h3>Data Ayah Kandung</h3>
                                                </div>
                                                @if ($father == null)
                                                    <div class="col-md-6" style="margin-top: -2px;">
                                                        <a
                                                            href="{{ route('siswa.add_parent_student', [$student_id, 'Ayah Kandung']) }}"><i
                                                                class="bg-info rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -10%;"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($father != null)
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">NIK</h5>
                                                        <p class="text-muted">{{ $father->nik }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Nama Lengkap</h5>
                                                        <p class="text-muted">{{ $father->name }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Tanggal Lahir</h5>
                                                        <p class="text-muted">
                                                            {{ \Carbon\Carbon::parse($father->tanggal_lahir)->format('d F Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pendidikan</h5>
                                                        <p class="text-muted">
                                                            {{ $father->pendidikan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pekerjaan</h5>
                                                        <p class="text-muted">
                                                            {{ $father->pekerjaan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Penghasilan</h5>
                                                        <p class="text-muted">
                                                            {{ $father->penghasilan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                        <p class="text-muted">
                                                            {{ $father->special_need->nama }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Ayah Kandung</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h3>Data Ibu Kandung</h3>
                                                </div>
                                                @if ($mother == null)
                                                    <div class="col-md-6" style="margin-top: -2px;">
                                                        <a
                                                            href="{{ route('siswa.add_parent_student', [$student_id, 'Ibu Kandung']) }}"><i
                                                                class="bg-info rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px; margin-left: -15%;"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($mother != null)
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">NIK</h5>
                                                        <p class="text-muted">{{ $mother->nik }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Nama Lengkap</h5>
                                                        <p class="text-muted">{{ $mother->name }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Tanggal Lahir</h5>
                                                        <p class="text-muted">
                                                            {{ \Carbon\Carbon::parse($mother->tanggal_lahir)->format('d F Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pendidikan</h5>
                                                        <p class="text-muted">
                                                            {{ $mother->pendidikan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pekerjaan</h5>
                                                        <p class="text-muted">
                                                            {{ $mother->pekerjaan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Penghasilan</h5>
                                                        <p class="text-muted">
                                                            {{ $mother->penghasilan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                        <p class="text-muted">
                                                            {{ $mother->special_need->nama }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Ibu Kandung</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <h3>Data Wali</h3>
                                                </div>
                                                @if ($guardian == null)
                                                    <div class="col-md-6" style="margin-top: -2px;">
                                                        <a
                                                            href="{{ route('siswa.add_parent_student', [$student_id, 'wali']) }}"><i
                                                                class="bg-info rounded mdi mdi-plus text-white font-weight-bold font-size-20"
                                                                style="margin-bottom: 20px; padding-left: 3px; padding-right: 3px;"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($guardian != null)
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">NIK</h5>
                                                        <p class="text-muted">{{ $guardian->nik }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Nama Lengkap</h5>
                                                        <p class="text-muted">{{ $guardian->name }}</p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Tanggal Lahir</h5>
                                                        <p class="text-muted">
                                                            {{ \Carbon\Carbon::parse($guardian->tanggal_lahir)->format('d F Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pendidikan</h5>
                                                        <p class="text-muted">
                                                            {{ $guardian->pendidikan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Pekerjaan</h5>
                                                        <p class="text-muted">
                                                            {{ $guardian->pekerjaan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Penghasilan</h5>
                                                        <p class="text-muted">
                                                            {{ $guardian->penghasilan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 mt-4">
                                                        <h5 class="font-size-14">Berkebutuhan Khusus</h5>
                                                        <p class="text-muted">
                                                            {{ $guardian->special_need->nama }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger" role="alert">
                                                        <a class="alert-link">Tidak Ada Wali</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('siswa.edit', $student_id) }}"
                                                        class="btn btn-secondary waves-effect btn-sm">Kembali</a>
                                                    <button class="btn btn-primary btn-sm" type="submit"
                                                        style="float: right" id="submit">Simpan</button>
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
    <script>
        let url = '{{ route('kodepos.get_villages_by_district', ':district') }}'
        let urlPostalCode = '{{ route('kodepos.get_postal_code_by_village', ':oldVillage') }}'

        let old_district = $("#old_district").val()
        let oldVillage = ''
        let oldPostalCode = $("#old_postal_code").val()

        $(document).ready(function() {
            let district = $("#kecamatan :selected").val()
            url = url.replace(':district', district)

            $.ajax({
                type: 'GET',
                url: url,
                success: response => {
                    $("#kelurahan option").remove()
                    $("#kelurahan").append(`<option value="">-- Pilih Kelurahan --</option>`)
                    $.each(response.data, function(index, item) {
                        if (item.kelurahan == old_district) {
                            oldVillage = item.kelurahan
                            urlPostalCode = urlPostalCode.replace(':oldVillage', oldVillage)
                            next()
                            $("#kelurahan").append(
                                `<option value="${item.kelurahan}" selected>${item.kelurahan}</option>`
                            )
                        } else {
                            $("#kelurahan").append(
                                `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                            )
                        }
                    })
                },
                error: err => console.log(err)
            })

            function next() {
                $.ajax({
                    type: 'GET',
                    url: urlPostalCode,
                    success: response => {
                        $("#kode_pos option").remove()
                        $("#kode_pos").append(`<option value="">-- Pilih Kode Pos --</option>`)
                        $.each(response.data, function(index, item) {
                            if (item.kodepos == oldPostalCode) {
                                $("#kode_pos").append(
                                    `<option value="${item.kodepos}" selected>${item.kodepos}</option>`
                                )
                            } else {
                                $("#kode_pos").append(
                                    `<option value="${item.kodepos}">${item.kodepos}</option>`
                                )
                            }
                        })
                    },
                    error: err => console.log(err)
                })
            }

            $("#kecamatan").bind('change', function() {
                let district = $(this).val()
                url = url.replace(':district', district)

                $.ajax({
                    type: "GET",
                    url: url,
                    success: response => {
                        if (response.status == 200) {
                            $("#kelurahan option").remove()
                            $('#kelurahan').append(
                                `<option value="">-- Pilih Kelurahan --</option>`)
                            $.each(response.data, function(i, item) {
                                $('#kelurahan').append(
                                    `<option value="${item.kelurahan}">${item.kelurahan}</option>`
                                )
                            })
                        } else {
                            Swal.fire(
                                'Gagal',
                                'Gagal mendapatkan data kelurahan',
                                'error'
                            )
                        }
                    },
                    error: err => console.log(err)
                })
            })

            $("#kelurahan").bind('change', function() {
                let village = $(this).val()
                let url = '{{ route('kodepos.get_postal_code_by_village', ':village') }}'
                url = url.replace(':village', village)
                $.ajax({
                    type: "GET",
                    url: url,
                    success: response => {
                        $("#kode_pos option").remove()
                        $('#kode_pos').append(
                            `<option value="">-- Pilih Kode Pos --</option>`)
                        $.each(response.data, function(i, item) {
                            $('#kode_pos').append(
                                `<option value="${item.kodepos}">${item.kodepos}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err)
                    },
                });
            });
        })
    </script>
@endsection
