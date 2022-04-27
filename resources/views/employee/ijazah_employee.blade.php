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
                <?php $id = Crypt::encryptString($item->id); ?>
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
                            <a class="nav-link">
                                <i class="bx bxs-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Karyawan</p>
                            </a>
                            <a class="nav-link active">
                                <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Ijazah + Sertifikat</p>
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
                                <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                <i class="bx bx-phone check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit & Kontak</p>
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
                                                    <div class="page-title-left"></div>
                                                    <?php $id = Crypt::encryptString($item->id); ?>
                                                    <div class="page-title-right">
                                                        <ol class="breadcrumb m-0">
                                                            <a href="{{ route('employee.create_ijazah', ['id' => $id]) }}"
                                                                type="button"
                                                                class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                                                    class="mdi mdi-plus me-1"></i>Tambah Ijazah</a>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="datatable"
                                                    class="table table-striped dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Sekolah/<br> Universitas/<br> Instansi</th>
                                                            <th>Ijazah</th>
                                                            <th>Tahun Pendidikan</th>
                                                            <th>Jenis</th>
                                                            <th>Akademik</th>
                                                            <th>Dokumen Ijazah</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($lists as $list)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $list->type === 'Akademik' ? $list->nama_pendidikan : $list->instansi }}
                                                                </td>
                                                                <td>{{ $list->gelar_ijazah }}</td>
                                                                <td>{{ $list->tahun_masuk ? $list->tahun_masuk . ' s/d ' . $list->tahun_lulus : '' }}
                                                                </td>
                                                                <td>{{ $list->type }}</td>
                                                                <td>{{ $list->type === 'Akademik' ? $list->gelar_akademik_pendek : $list->gelar_non_akademik_pendek }}
                                                                </td>
                                                                <td>
                                                                    @if ($list->dok_ijazah)
                                                                        <a href="javascript:void(0)"
                                                                            data-id="{{ $list->dok_ijazah . '|ijazah|ijazah' }}"
                                                                            id="get_data_dok" data-bs-toggle="modal"
                                                                            data-bs-target=".bs-example-modal-lg-dok">
                                                                            <i
                                                                                class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                            Dokumen
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <?php $id = Crypt::encryptString($list->id); ?>
                                                                    <form class="delete-form"
                                                                        action="{{ route('employee.destroy_ijazah', ['id' => $id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="d-flex gap-3">
                                                                            <a href="javascript:void(0)"
                                                                                data-id="{{ $id }}"
                                                                                class="text-info" id="get_data"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target=".bs-example-modal-lg">
                                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                                            </a>
                                                                            <a href="{{ route('employee.edit_ijazah', ['id' => $id]) }}"
                                                                                class="text-success"><i
                                                                                    class="mdi mdi-pencil font-size-18"></i></a>
                                                                            <button
                                                                                style="margin-top: -10px; margin-left: -10px;"
                                                                                class="btn text-danger delete_confirm"><i
                                                                                    class="mdi mdi-delete font-size-18"></i></button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <?php $id = Crypt::encryptString($item->id); ?>
                                                        <a href="{{ url('employee/edit', $id) }}"
                                                            class="btn btn-secondary waves-effect">Kembali</a>
                                                        <a href="{{ url('employee/sk', $id) }}" style="float: right"
                                                            class="btn btn-primary">Selanjutnya</a>
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
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Lihat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dynamic-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg-dok" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
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
            $(document).on('click', '#get_data', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.show_ijazah') }}"
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
        });

        $(document).on('click', '.delete_confirm', function(event) {
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
        })
    </script>
@endsection
