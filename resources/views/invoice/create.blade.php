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

            {{-- <form class="needs-validation" action="{{ route('invoice.store') }}" method="POST" novalidate> --}}
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
                                {{-- <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Tahun <code>*</code></label>
                                            <select class="form-control select select2 year" name="year" id="year"
                                                required>
                                                <option value="">--Pilih Tahun--</option>
                                                @for ($i = 2022; $i <= date('Y') + 1; $i++)
                                                    <option value='{{ $i }}'
                                                        {{ $i == date('Y') ? 'selected' : '' }}>
                                                        {{ $i . ' s/d ' . $i + 1 }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('year')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Bulan <code>*</code></label>
                                            <select class="form-control select select2 month" name="month" id="month"
                                                required>
                                                <option value="">--Pilih Bulan--</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value='{{ $i }}'
                                                        {{ $i == date('m') ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('month')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Pembayaran <code>*</code></label>
                                            <select class="form-control select select2 bills_id" name="bills_id"
                                                id="bills_id" required>
                                                <option value="">--Pilih Jenjang--</option>
                                                @foreach ($bills as $bill)
                                                    <option value="{{ $bill->id }}" data-id="{{ $bill->bills }}">
                                                        {{ $bill->bills }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('bills_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" class="form-control class_siswa" name="class_siswa"
                                                id="class_siswa" readonly placeholder="Kelas">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('class_siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Biaya</label>
                                            <input type="text" class="form-control amount" name="amount" id="amount"
                                                readonly placeholder="Biaya">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('amount')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div hidden>
                                    <label for="">payment_value</label>
                                    <input type="text" name="payment_value" id="payment_value">
                                    <label for="">class_id</label>
                                    <input type="text" name="class_id" id="class_id">
                                    <label for="">payment_done</label>
                                    <input type="text" name="payment_done" id="payment_done">
                                </div> --}}
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









            // -----------------------------------------------------------------------------------------------------------------------

            // $(".bills_id").change(function() {
            //     paymentText = this.querySelector(':checked').getAttribute('data-id')
            //     document.getElementById("payment_value").value = paymentText;
            //     $('#siswa').val("").trigger('change')
            //     $('#jenjang').val("").trigger('change')
            //     $('#class_siswa').val("")
            //     $('#amount').val("")
            //     // menampilkan jenjang sekolah
            //     $(".classes option").remove();
            //     $.ajax({
            //         type: "POST",
            //         url: '{{ route('invoice.get_jenjang') }}',
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //         },
            //         success: response => {
            //             $('.classes').append(`<option value="">-- Pilih Jenjang --</option>`)
            //             $.each(response.data, function(i, item) {
            //                 $('.classes').append(
            //                     `<option value="${item.id}">${item.level+' '+item.classes+' '+item.jurusan+' '+item.type}</option>`
            //                 )
            //             })
            //         },
            //         error: (err) => {
            //             console.log(err);
            //         },
            //     });
            // });

            // $(".siswa").change(function() {
            //     let siswa_id = $(this).val();
            //     let jenjang = document.getElementById("jenjang").value;
            //     if (siswa_id) {
            //         // get kelas siswa
            //         $.ajax({
            //             type: "POST",
            //             url: '{{ route('invoice.get_class') }}',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 siswa_id,
            //                 jenjang
            //             },
            //             success: response => {
            //                 document.getElementById("class_siswa").value = response[0].jenjang +
            //                     ' - [ ' + response[0].class + ' ]';
            //                 document.getElementById("class_id").value = response[0].class_id;
            //             },
            //             error: (err) => {
            //                 console.log(err);
            //             },
            //         });

            //         // cek sudah input invoice belum 
            //         let year = document.getElementById("year").value;
            //         let month = document.getElementById("month").value;
            //         let bills_id = document.getElementById("bills_id").value;
            //         let payment_value = document.getElementById("payment_value").value;
            //         $.ajax({
            //             type: "POST",
            //             url: '{{ route('invoice.cek_payment') }}',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 siswa_id,
            //                 jenjang,
            //                 year,
            //                 bills_id,
            //                 month,
            //                 payment_value,
            //             },
            //             success: response => {
            //                 if (response.count > 0) {
            //                     Swal.fire(
            //                         'Gagal',
            //                         'Pembayaran sudah dibayar',
            //                         'error'
            //                     )
            //                     document.getElementById("submit").disabled = true;
            //                     document.getElementById("payment_done").value = true;
            //                 } else {
            //                     document.getElementById("submit").disabled = false;
            //                     document.getElementById("payment_done").value = false;
            //                 }
            //             },
            //             error: (err) => {
            //                 console.log(err);
            //             },
            //         });

            //         // get payment dan cek sudah input setting payment belum 
            //         $.ajax({
            //             type: "POST",
            //             url: '{{ route('invoice.get_payment') }}',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 siswa_id,
            //                 jenjang,
            //                 year,
            //                 bills_id
            //             },
            //             success: response => {
            //                 if (response > 0) {
            //                     document.getElementById("amount").value = setMoney(response);
            //                 } else {
            //                     document.getElementById("amount").value = '';
            //                     document.getElementById("submit").disabled = true;
            //                     payment_done = document.getElementById("payment_done").value;
            //                     if (payment_done == true) {
            //                         document.getElementById("submit").disabled = true;
            //                     }
            //                     Swal.fire(
            //                         'Gagal',
            //                         'Setting biaya belum diinput',
            //                         'error'
            //                     )
            //                 }
            //             },
            //             error: (err) => {
            //                 console.log(err);
            //             },
            //         });
            //     }
            // });
        });
    </script>
@endsection
