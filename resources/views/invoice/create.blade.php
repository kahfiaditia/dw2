@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route('invoice.pencarian_siswa') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if (session()->has('logError'))
                                        <div class="p-2">
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('logError') }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="false" aria-controls="collapseOne">
                                                    Pencarian Manual
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                style="">
                                                <div class="accordion-body">
                                                    <div class="text-muted">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="">Jenjang </label>
                                                                    <select class="form-control select select2 classes"
                                                                        name="jenjang" id="jenjang">
                                                                        <option value="">--Pilih Jenjang--</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="">Siswa </label>
                                                                    <select class="form-control select select2 siswa"
                                                                        name="siswa_id" id="siswa_id">
                                                                        <option value="">--Pilih Siswa--</option>
                                                                    </select>
                                                                </div>
                                                            </div>
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
                                                    Pencarian NISN
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="text-muted">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="">NISN</label>
                                                                    <input type="text" class="form-control"
                                                                        name="nisn" placeholder="NISN">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="">NIK/NIS</label>
                                                                    <input type="text" class="form-control"
                                                                        name="nik" placeholder="NIK/NIS">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('invoice.index') }}"
                                            class="btn btn-secondary waves-effect">Kembali</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".year").change(function() {
                $('#bills_id').val("").trigger('change')
                $('#siswa').val("").trigger('change')
                $('#jenjang').val("").trigger('change')
                $('#class_siswa').val("")
                $('#amount').val("")
            });

            $(".month").change(function() {
                $('#bills_id').val("").trigger('change')
                $('#siswa').val("").trigger('change')
                $('#jenjang').val("").trigger('change')
                $('#class_siswa').val("")
                $('#amount').val("")
            });

            $.ajax({
                type: "POST",
                url: '{{ route('invoice.get_jenjang') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response.data, function(i, item) {
                        $('.classes').append(
                            `<option value="${item.id}">${item.level+' '+item.classes+' '+item.jurusan+' '+item.type}</option>`
                        )
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            $(".classes").change(function() {
                let class_jenjang = $(this).val();
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('invoice.get_siswa') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_jenjang
                    },
                    success: response => {
                        $('.siswa').append(`<option value="">-- Pilih Siswa --</option>`)
                        $.each(response.data, function(i, item) {
                            $('.siswa').append(
                                `<option value="${item.id}">${item.nama_lengkap}</option>`
                            )
                        })
                        $('#siswa').val("").trigger('change')
                        $('#class_siswa').val("")
                        $('#amount').val("")
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        });
    </script>
@endsection
