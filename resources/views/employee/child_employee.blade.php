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
                <input type="hidden" name="id" value="{{ $id }}">
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
                            <a class="nav-link">
                                <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Ijazah</p>
                            </a>
                            <a class="nav-link">
                                <i class="bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link active">
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
                                            <div class="col-xl-12">
                                                <h4 class="card-title mb-4">Jumlah Anak</h4>
                                                <div class="mt-4">
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button fw-medium" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="true" aria-controls="collapseOne">
                                                                    Anak Karyawan
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                                aria-labelledby="headingOne"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="text-muted">
                                                                        <form class="needs-validation"
                                                                            action="{{ route('employee.store_child') }}"
                                                                            method="POST" novalidate>
                                                                            @csrf
                                                                            <?php $id = Crypt::encryptString($item->id); ?>
                                                                            <input type="hidden" name="karyawan_id"
                                                                                value="{{ $id }}">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="validationCustom02"
                                                                                            class="form-label">Anak Ke
                                                                                            <code>*</code></label>
                                                                                        <input type="number" min="0"
                                                                                            maxlength="2"
                                                                                            class="form-control"
                                                                                            id="anak_ke" name="anak_ke"
                                                                                            value="{{ old('anak_ke') }}"
                                                                                            required placeholder="Anak Ke">
                                                                                        <div class="invalid-feedback">
                                                                                            Data wajib diisi.
                                                                                        </div>
                                                                                        {!! $errors->first('anak_ke', '<div class="invalid-validasi">:message</div>') !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="validationCustom02"
                                                                                            class="form-label">Nama
                                                                                            <code>*</code></label>
                                                                                        <input type="text"
                                                                                            class="form-control" id="nama"
                                                                                            name="nama"
                                                                                            value="{{ old('nama') }}"
                                                                                            required placeholder="Nama">
                                                                                        <div class="invalid-feedback">
                                                                                            Data wajib diisi.
                                                                                        </div>
                                                                                        {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="validationCustom02"
                                                                                            class="form-label">Usia
                                                                                            <code>*</code></label>
                                                                                        <input type="number" min="0"
                                                                                            class="form-control" id="usia"
                                                                                            name="usia"
                                                                                            value="{{ old('usia') }}"
                                                                                            required placeholder="Usia">
                                                                                        <div class="invalid-feedback">
                                                                                            Data wajib diisi.
                                                                                        </div>
                                                                                        {!! $errors->first('usia', '<div class="invalid-validasi">:message</div>') !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 align-self-center">
                                                                                    <div class="d-grid">
                                                                                        <?php
                                                                                        if (count($child) >= 5) {
                                                                                            $style = 'disabled';
                                                                                        } else {
                                                                                            $style = '';
                                                                                        }
                                                                                        ?>
                                                                                        <button class="btn btn-success"
                                                                                            style="margin-top: 10px;"
                                                                                            {{ $style }}
                                                                                            type="submit"
                                                                                            id="submit">Simpan</button>
                                                                                    </div>
                                                                                </div>
                                                                                @if (count($child) >= 5)
                                                                                    <div class="col-md-12">
                                                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                                                            role="alert">
                                                                                            <i
                                                                                                class="mdi mdi-block-helper me-2"></i>
                                                                                            Anak Karyawan maksimal 5
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                        <hr class="mt-2">
                                                                        <div class="col-12">
                                                                            <table id=""
                                                                                class="table table-bordered dt-responsive nowrap w-100">
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
                                                                                            <td>{{ $list->anak_ke }}</td>
                                                                                            <td>{{ $list->nama }}</td>
                                                                                            <td>{{ $list->usia }}</td>
                                                                                            <td>
                                                                                                <?php $id = Crypt::encryptString($list->id); ?>
                                                                                                <form class="delete-form"
                                                                                                    action="{{ route('employee.destroy_anak', ['id' => $id]) }}"
                                                                                                    method="POST">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <div
                                                                                                        class="d-flex gap-3">
                                                                                                        <a href="javascript:void(0)"
                                                                                                            data-id="{{ $id . '|anak|' . $list->karyawan_id }}"
                                                                                                            class="text-success"
                                                                                                            id="get_data_edit"
                                                                                                            data-bs-toggle="modal"
                                                                                                            data-bs-target=".bs-example-modal-lg-edit">
                                                                                                            <i
                                                                                                                class="mdi mdi-pencil font-size-18"></i>
                                                                                                        </a>
                                                                                                        <a href
                                                                                                            class="text-danger delete_confirm"><i
                                                                                                                class="mdi mdi-delete font-size-18"></i></a>
                                                                                                    </div>
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
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingTwo">
                                                                <button class="accordion-button fw-medium" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                                    Anak Karyawan Sekolah di Dharmawidya
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                                aria-labelledby="headingTwo"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="text-muted">
                                                                        <form class="needs-validation"
                                                                            action="{{ route('employee.store_child_dw') }}"
                                                                            method="POST" novalidate>
                                                                            @csrf
                                                                            <?php $id = Crypt::encryptString($item->id); ?>
                                                                            <input type="hidden" name="karyawan_id"
                                                                                value="{{ $id }}">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="validationCustom01"
                                                                                            class="form-label">Anak
                                                                                            Karyawan <code>*</code></label>
                                                                                        <select
                                                                                            class="form-control select select2"
                                                                                            name="anak_karyawan"
                                                                                            id="anak_karyawan">
                                                                                            <option value="">--Pilih Anak
                                                                                                Karyawan--</option>
                                                                                            @foreach ($child as $anak)
                                                                                                <option
                                                                                                    value="{{ $anak->id }}">
                                                                                                    {{ $anak->nama }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <div class="invalid-feedback">
                                                                                            Data wajib diisi.
                                                                                        </div>
                                                                                        {!! $errors->first('anak_karyawan', '<div class="invalid-validasi">:message</div>') !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="validationCustom01"
                                                                                            class="form-label">Jenjang
                                                                                            <code>*</code></label>
                                                                                        <select
                                                                                            class="form-control select select2"
                                                                                            name="jenjang" id="jenjang">
                                                                                            <option value="">--Pilih
                                                                                                Jenjang--</option>
                                                                                            <option value="KB">KB</option>
                                                                                            <option value="TK">TK</option>
                                                                                            <option value="SD">SD</option>
                                                                                            <option value="SMP">SMP</option>
                                                                                            <option value="SMK">SMK</option>
                                                                                        </select>
                                                                                        <div class="invalid-feedback">
                                                                                            Data wajib diisi.
                                                                                        </div>
                                                                                        {!! $errors->first('jenjang', '<div class="invalid-validasi">:message</div>') !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 align-self-center">
                                                                                    <div class="d-grid">
                                                                                        <?php
                                                                                        if (count($school) >= 3) {
                                                                                            $style = 'disabled';
                                                                                        } else {
                                                                                            $style = '';
                                                                                        }
                                                                                        ?>
                                                                                        <button class="btn btn-success"
                                                                                            style="margin-top: 10px;"
                                                                                            {{ $style }}
                                                                                            type="submit"
                                                                                            id="submit">Simpan</button>
                                                                                    </div>
                                                                                </div>
                                                                                @if (count($school) >= 3)
                                                                                    <div class="col-md-12">
                                                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                                                            role="alert">
                                                                                            <i
                                                                                                class="mdi mdi-block-helper me-2"></i>
                                                                                            Anak Karyawan Sekolah di
                                                                                            Dharmawidya maksimal 3
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                        <hr class="mt-2">
                                                                        <div class="col-12">
                                                                            <table id=""
                                                                                class="table table-bordered dt-responsive nowrap w-100">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Nama</th>
                                                                                        <th>Jenjang</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($school as $list)
                                                                                        <tr>
                                                                                            <td>{{ $list->anak_karyawans->nama }}
                                                                                            </td>
                                                                                            <td>{{ $list->jenjang }}</td>
                                                                                            <td>
                                                                                                <?php $id = Crypt::encryptString($list->id); ?>
                                                                                                <form
                                                                                                    class="delete-form"
                                                                                                    action="{{ route('employee.destroy_dw', ['id' => $id]) }}"
                                                                                                    method="POST">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <div
                                                                                                        class="d-flex gap-3">
                                                                                                        <a href="javascript:void(0)"
                                                                                                            data-id="{{ $id . '|dw|' . $list->karyawan_id }}"
                                                                                                            class="text-success"
                                                                                                            id="get_data_edit"
                                                                                                            data-bs-toggle="modal"
                                                                                                            data-bs-target=".bs-example-modal-lg-edit">
                                                                                                            <i
                                                                                                                class="mdi mdi-pencil font-size-18"></i>
                                                                                                        </a>
                                                                                                        <a href
                                                                                                            class="text-danger delete_confirm"><i
                                                                                                                class="mdi mdi-delete font-size-18"></i></a>
                                                                                                    </div>
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
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <?php $id = Crypt::encrypt($item->id); ?>
                                                    <a href="{{ url('employee/sk', $id) }}"
                                                        class="btn btn-secondary waves-effect">Back</a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end mt-2 mt-sm-0">
                                                        <a href="{{ url('employee/riwayat', $id) }}"
                                                            class="btn btn-primary">Next</a>
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
    <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
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
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#get_data_edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content-edit').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.edit_anak') }}"
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
