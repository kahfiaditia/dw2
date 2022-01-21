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
                            <a class="nav-link">
                                <i class= "bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Ijazah</p>
                            </a>
                            <a class="nav-link">
                                <i class= "bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link active">
                                <i class= "bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Jumlah Anak</p>
                            </a>
                            <a class="nav-link">
                                <i class= "bx bx-plus-medical d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-<?php echo $column; ?> col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                <div class="card shadow-none border mb-0">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Anak</h4>
                                        <div class="row">
                                            <form class="needs-validation" action="{{ route("employee.store_sk") }}" enctype="multipart/form-data" method="POST" novalidate>
                                                @csrf
                                                <?php $id = Crypt::encryptString($item->id); ?>
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Anak Ke</label>
                                                            <select class="form-control select select2 alamat-sama" name="anak_ke" id="anak_ke" required>
                                                                <option value="">--Pilih Anak Ke--</option>
                                                                @for ($x = 1; $x <= 10; $x++)
                                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                                @endfor
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required
                                                                placeholder="Nama">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Usia</label>
                                                            <select class="form-control select select2 alamat-sama" name="usia" id="usia" required>
                                                                <option value="">--Pilih Usia--</option>
                                                                @for ($x = 1; $x <= 30; $x++)
                                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                                @endfor
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 align-self-center">
                                                        <div class="d-grid">
                                                            <?php
                                                            if (count($child) >= 10){
                                                                $style = "disabled";
                                                            }else{
                                                                $style = "";
                                                            }
                                                            ?>
                                                            <button class="btn btn-success" style="margin-top: 10px;" {{ $style }} type="submit" id="submit">Simpan</button>
                                                        </div>
                                                    </div>
                                                    @if (count($child) >= 10)
                                                        <div class="col-md-12">
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <i class="mdi mdi-block-helper me-2"></i>
                                                                SK Pengangkatan maksimal 10
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                            <hr class="mt-2">
                                            <div class="col-12">
                                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Anak Ke</th>
                                                            <th>Nama</th>
                                                            <th>Usia</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($child as $list)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $list->no_sk }}</td>
                                                                <td>{{ $list->tgl_sk }}</td>
                                                                <td>
                                                                    <?php $id = Crypt::encryptString($list->id); ?>
                                                                    <form class="delete-form" action="{{ route('employee.destroy_sk', ['id' => $id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="d-flex gap-3">
                                                                            <a href="{{ route('employee.edit',['id' => $id]) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                                            <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="row mt-4">
                                                    <div class="col-sm-6">
                                                        <?php $id = Crypt::encryptString($item->id); ?>
                                                        <a href="{{ url('employee/ijazah',$id) }}" class="btn btn-secondary waves-effect">Back</a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-end mt-2 mt-sm-0">
                                                            <a href="{{ url('employee/child',$id) }}" class="btn btn-primary">Next</a>
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
