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
            <form class="needs-validation" action="{{ route("employee.update") }}" enctype="multipart/form-data" method="POST" novalidate>
                @csrf
                <?php $id = Crypt::encryptString($item->id); ?>
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
                                <i class= "bx bx-plus-medical check-nav-icon mt-2"></i>
                                <i class= "bx bx-phone check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit & Kontak</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama</th>
                                                            <th>NIK</th>
                                                            <th>NPWP</th>
                                                            <th>Kontak</th>
                                                            <th>Jabatan</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach ($lists as $list)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $list->nama_lengkap }}</td>
                                                                <td>{{ $list->nik }}</td>
                                                                <td>{{ $list->npwp }}</td>
                                                                <td>{{ $list->no_hp }}</td>
                                                                <td>{{ $list->jabatan }}</td>
                                                                <td>
                                                                    <span class="badge badge-pill badge-soft-<?php if($list->aktif === 1){ echo 'success'; }else{ echo 'danger'; }?> font-size-12">
                                                                        @if ($list->aktif === 1)
                                                                            Aktif
                                                                        @else
                                                                            Non Aktif
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <?php $path = Storage::url('karyawan/nik/'.$list->dok_nik); ?>
                                                                    <img src="{{ $path }}">
                                                                    <?php $id = Crypt::encryptString($list->id); ?>
                                                                    <form class="delete-form" action="{{ route('employee.destroy', ['id' => $id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="d-flex gap-3">
                                                                            <a href="{{ route('employee.show',['id' => $id]) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
                                                                            <a href="{{ route('employee.edit',['id' => $id]) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                                            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach --}}
                                                    </tbody>
                                                </table>
                                                <div class="row mt-4">
                                                    <div class="col-sm-6">
                                                        <?php $id = Crypt::encryptString($item->id); ?>
                                                        <a href="{{ url('employee/edit',$id) }}" class="btn btn-secondary waves-effect">Back</a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-end mt-2 mt-sm-0">
                                                            <a href="{{ url('employee/sk',$id) }}" class="btn btn-primary">Next</a>
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
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection
