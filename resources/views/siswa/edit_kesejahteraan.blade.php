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
                    <div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a href="{{ route('siswa.create') }}"
                                class="nav-link @if ($submenu == 'siswa') active @endif">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Pribadi</p>
                            </a>
                            <a class="nav-link @if ($submenu == 'orang tua') active @endif"
                                href="{{ route('parents.create') }}">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Orang Tua / Wali</p>
                            </a>
                            <a class="nav-link">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Wali</p>
                            </a>
                            <a href="#" class="nav-link @if ($submenu == 'prestasi') active @endif">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Prestasi</p>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form method="POST"
                                                            action="{{ route('siswa.update_kesejahteraan', $result->id) }}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $result->siswa_id }}">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Jenis
                                                                                Kesejahteraan</label>
                                                                            <select name="jenis_kesejahteraan" id=""
                                                                                required class="form-control">
                                                                                <option value="">-- Pilih Jenis
                                                                                    Kesejahteraan --
                                                                                </option>
                                                                                @foreach ($kesejahteraan as $item)
                                                                                    <option value="{{ $item }}"
                                                                                        @if ($item == $result->jenis_kesejahteraan) selected @endif>
                                                                                        {{ $item }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="exampleInputPassword1">nomor_kartu</label>
                                                                            <input type="text" name="nomor_kartu"
                                                                                class="form-control"
                                                                                value="{{ old('nomor_kartu', $result->nomor_kartu) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="">Nama Kartu</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama_kartu" placeholder="Nama Kartu"
                                                                                value="{{ old('nama_kartu', $result->nama_kartu) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm">Simpan</button>
                                                            </div>
                                                        </form>
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
    </div>
@endsection
