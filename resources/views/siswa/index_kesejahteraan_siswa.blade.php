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
                                                            <a id="modal_trigger" data-toggle="modal"
                                                                data-target="#exampleModalLong" type="button"
                                                                class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                                                <i class="mdi mdi-plus me-1"></i> Tambah Kesejahteraan
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
                                                                    <th class="text-center">Jenis Kesejahteraan</th>
                                                                    <th class="text-center">Nomor Kartu</th>
                                                                    <th class="text-center">Nama Di Kartu</th>
                                                                    <th class="text-center">Opsi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($kesejahteraan as $item)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $item->jenis_kesejahteraan }}</td>
                                                                        <td class="text-center">
                                                                            {{ $item->nomor_kartu }}</td>
                                                                        <td class="text-center">
                                                                            {{ $item->nama_kartu }}</td>
                                                                        <td class="text-center">
                                                                            <form
                                                                                action="{{ route('siswa.destroy_kesejahteraan', \Crypt::encryptString($item->id)) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <a href="{{ route('siswa.edit_kesejahteraan', \Crypt::encryptString($item->id)) }}"
                                                                                    class="text-success"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="edit"><i
                                                                                        class="mdi mdi-pencil font-size-18"></i></a>
                                                                                <a href="#"
                                                                                    class="text-danger delete_confirm"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="hapus"><i
                                                                                        class="mdi mdi-delete font-size-18"></i></a>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
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
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_performance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Kesejahteraan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('siswa.store_kesejahteraan') }}">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jenis Kesejahteraan</label>
                                        <select name="jenis_kesejahteraan" id="" required class="form-control">
                                            <option value="">-- Pilih Jenis Kesejahteraan --</option>
                                            <option value="PKH">PKH</option>
                                            <option value="PIP">PIP</option>
                                            <option value="Kartu Perlindungan Sosial">Kartu Perlindungan Sosial</option>
                                            <option value="Kartu Keluarga Sejahtera">Kartu Keluarga Sejahtera</option>
                                            <option value="Kartu Kesehatan">Kartu Kesehatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nomor Kartu</label>
                                        <input type="text" name="nomor_kartu" class="form-control"
                                            placeholder="Nomor Kartu" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Nama di Kartu</label>
                                        <input type="text" class="form-control" name="nama_kartu"
                                            placeholder="Nama di kartu" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancel" class="btn btn-secondary btn-sm"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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
            $("#modal_performance").modal('hide')
        })
    </script>
@endsection
