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

        <div class="checkout-tabs">
            <div class="row">
                <div class="col-xl-2 col-sm-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active">
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
                        <a class="nav-link">
                            <i class= "bx bx-group d-block check-nav-icon mt-2"></i>
                            <p class="fw-bold mb-4">Jumlah Anak</p>
                        </a>
                        <a class="nav-link">
                            <i class= "bx bxs-school d-block check-nav-icon mt-2"></i>
                            <p class="fw-bold mb-4">Sekolah di Dharma Widya</p>
                        </a>
                        <a class="nav-link">
                            <i class= "bx bx-plus-medical d-block check-nav-icon mt-2"></i>
                            <p class="fw-bold mb-4">Riwayat Penyakit</p>
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-sm-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                            <div class="card shadow-none border mb-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">No Reg Pendaftaran</label>
                                                <input type="text" class="form-control" id="validationCustom02" name="NoReg"
                                                    placeholder="No Reg Pendaftaran">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="validationCustom02" name="NamaLengkap"
                                                    placeholder="Nama Lengkap">
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
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
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/alert.js') }}"></script>
<script>
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
