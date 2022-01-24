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
                            <a class="nav-link active">
                                <i class= "bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link">
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
                                        <h4 class="card-title mb-4">SK Pengangkatan</h4>
                                        <div class="row">
                                            <form class="needs-validation" action="{{ route("employee.store_sk") }}" enctype="multipart/form-data" method="POST" novalidate>
                                                @csrf
                                                <?php $id = Crypt::encryptString($item->id); ?>
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">No SK</label>
                                                            <input type="text" class="form-control" id="no_sk" name="no_sk" value="{{ old('no_sk') }}"
                                                                placeholder="No SK">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('no_sk', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label>Tanggal SK</label>
                                                            <div class="input-group" id="datepicker2">
                                                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="tgl_sk" value="{{ old('tgl_sk') }}"
                                                                    data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" required
                                                                    data-date-autoclose="true" >
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                <div class="invalid-feedback">
                                                                    Data wajib diisi.
                                                                </div>
                                                            </div>
                                                            {!! $errors->first('tgl_sk', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label for="validationCustom02" class="form-label">Jabatan</label>
                                                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required
                                                                placeholder="Jabatan">
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                            {!! $errors->first('jabatan', '<div class="invalid-validasi">:message</div>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="formFile" class="form-label">Dokumen SK</label>
                                                            <input class="form-control dok_sk" type="file" name="dok_sk" id="dok_sk" required>
                                                            <div class="invalid-feedback">
                                                                Data wajib diisi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 align-self-center">
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
                                                            <th>No</th>
                                                            <th>No SK</th>
                                                            <th>Tanggal SK</th>
                                                            <th>Jabatan</th>
                                                            <th>Dokumen SK</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($child as $list)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $list->no_sk }}</td>
                                                                <td>{{ $list->tgl_sk }}</td>
                                                                <td>{{ $list->jabatan }}</td>
                                                                <td>
                                                                    <a href="javascript:void(0)" data-id="{{ $list->dok_sk.'|sk|sk' }}" id="get_data" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                                        <i class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat Dokumen
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <?php $id = Crypt::encryptString($list->id); ?>
                                                                    <form class="delete-form" action="{{ route('employee.destroy_sk', ['id' => $id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="d-flex gap-3">
                                                                            <a href="javascript:void(0)" data-id="{{ $id }}" class="text-success" id="get_data_edit" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-edit">
                                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                                            </a>
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
<!-- modal -->
<div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dynamic-content-edit"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dynamic-content"></div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/alert.js') }}"></script>
<script>
    $(document).ready(function() {
        // valdasi extension
        $('#dok_sk').bind('change', function() {
            var file = document.querySelector("#dok_sk");
            if (/\.(jpe?g|png|jpg)$/i.test(file.files[0].name) === false) {
                Swal.fire(
                    'Gagal',
                    'Tipe dokumen yang diperbolehkan jpeg, png ,jpg',
                    'error'
                ).then(function() {})
                document.getElementById('dok_sk').value = null;
            } else {
                var size = this.files[0].size / 1000;
                if (size > 2000) {
                    Swal.fire(
                        'Gagal',
                        'Maksimal ukuran 2 MB',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_sk').value = null;
                }
            }
        });
        $(document).on('click', '#get_data', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
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
                    $('#dynamic-content').html(url); // load response
                    $('#modal-loader').hide(); // hide ajax loader
                })
                .fail(function(err) {
                    $('#dynamic-content').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });
        });
        $(document).on('click', '#get_data_edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // it will get id of clicked row
            console.log(id)
            $('#dynamic-content-edit').html(''); // leave it blank before ajax call
            $('#modal-loader').show(); // load ajax loader
            var url = "{{ route('employee.edit_sk') }}"
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id
                }
            })
            .done(function(url) {
                $('#dynamic-content-edit').html(url); // load response
                $('#modal-loader').hide(); // hide ajax loader
            })
            .fail(function(err) {
                $('#dynamic-content').html(
                    '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                );
                $('#modal-loader').hide();
            });
        });
    });
    $('.delete_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Data',
            text: 'Ingin menghapus data?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });
</script>
@endsection
