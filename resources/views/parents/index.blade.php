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
                <form class="needs-validation" action="{{ route('parents.store') }}" enctype="multipart/form-data"
                    method="POST" novalidate>
                    @csrf
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
                                <a href="{{ route('siswa.create') }}"
                                    class="nav-link @if ($submenu == 'siswa') active @endif">
                                    <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                    <p class="fw-bold mb-4">Data Pribadi</p>
                                </a>
                                <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                    href="{{ route('parents.create') }}">
                                    <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                    {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
                                    <p class="fw-bold mb-4">Orang Tua / Wali</p>
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
                                                <div class="col-12">
                                                    <div
                                                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                        <div class="page-title-left">
                                                            <h4 class="mb-sm-0 font-size-18">{{ $label }}
                                                            </h4>
                                                            <ol class="breadcrumb m-0">
                                                                <li class="breadcrumb-item">{{ ucwords($menu) }}
                                                                </li>
                                                                <li class="breadcrumb-item">
                                                                    {{ ucwords($submenu) }}</li>
                                                            </ol>
                                                        </div>
                                                        <div class="page-title-right">
                                                            <ol class="breadcrumb m-0">
                                                                <a href="{{ route('parents.create') }}" type="button"
                                                                    class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                                                    <i class="mdi mdi-plus me-1"></i> Tambah Orang
                                                                    Tua
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
                                                            <table id="mydata"
                                                                class="table table-striped dt-responsive nowrap w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">No</th>
                                                                        <th class="text-center">NIK</th>
                                                                        <th class="text-center">Nama Orang Tua / Wali
                                                                        </th>
                                                                        <th class="text-center">Nama Anak</th>
                                                                        <th class="text-center">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
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

    <script>
        $(function() {
            $('#mydata').DataTable({
                destroy: true,
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{ route('parents.index') }}',
                },
                columnDefs: [{
                    "className": "text-center",
                    "targets": "_all"
                }],
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'student.nama_lengkap'
                    },
                    {
                        data: 'Opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endsection
