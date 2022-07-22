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
            <form class="needs-validation" action="{{ route('payment.update', Crypt::encryptString($payment->id)) }}"
                method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Tahun <code>*</code></label>
                                            <select class="form-control select select2" name="tahun" id="tahun"
                                                required>
                                                <option value="">--Pilih Tahun--</option>
                                                @for ($i = 2022; $i <= date('Y') + 1; $i++)
                                                    <option value='{{ $i }}'
                                                        {{ $payment->year == $i ? 'selected' : '' }}>
                                                        {{ $i . ' s/d ' . $i + 1 }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('tahun')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Junjangan <code>*</code></label>
                                            <select class="form-control select select2 school_level_id"
                                                name="school_level_id" id="school_level_id" required>
                                                <option value="">--Pilih Junjangan--</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}" data-id="{{ $class->level }}"
                                                        {{ $class->id == $payment->school_level_id ? 'selected' : '' }}>
                                                        {{ $class->level }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('school_level_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Kelas <code>*</code></label>
                                            <select class="form-control select select2 class_id" name="class_id"
                                                id="class_id" required>
                                                <option value="">--Pilih Kelas--</option>
                                                @foreach ($kelas as $kls)
                                                    <option value="{{ $kls->id }}"
                                                        {{ $kls->id == $payment->school_class_id ? 'selected' : '' }}>
                                                        {{ $kls->classes }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('class_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Pembayaran <code>*</code></label>
                                            <select class="form-control select select2" name="bills_id" id="bills_id"
                                                required>
                                                <option value="">--Pilih Pembayaran--</option>
                                                @foreach ($bills as $bill)
                                                    <option value="{{ $bill->id }}"
                                                        {{ $bill->id == $payment->bills_id ? 'selected' : '' }}>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Biaya <code>*</code></label>
                                            <input type="text" class="form-control rupiah" name="amount" id="rupiah"
                                                oninput="numberFormat(this.value);rupiahFormat(this.value);"
                                                placeholder="Biaya" required
                                                value="{{ number_format($payment->amount, 0, ',', '.') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('amount')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('payment.index') }}"
                                            class="btn btn-secondary waves-effect">Kembali</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
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
        function numberFormat(value) {
            return document.getElementById('rupiah').value = value.replace(/[^0-9.]/g, '').replace(/(\*?)\*/g,
                '$1')
        }

        function rupiahFormat(value) {
            let rupiahInput = document.getElementById('rupiah')
            let rupiahReplace = rupiahInput.value.replaceAll('.', '')
            let rupiahValue = new Intl.NumberFormat('id-ID').format(rupiahReplace)
            return rupiahInput.value = rupiahValue
        }

        $(document).ready(function() {
            data_jenjang = $('#school_level_id option:selected').attr('data-id');
            if (data_jenjang == 'KB' || data_jenjang == 'TK') {
                document.getElementById("class_id").required = false;
            } else {
                document.getElementById("class_id").required = true;
            }

            $(".school_level_id").change(function() {
                let school_level_id = $(this).val();
                data_id_jenjang = this.querySelector(':checked').getAttribute('data-id');
                if (data_id_jenjang == 'KB' || data_id_jenjang == 'TK') {
                    document.getElementById("class_id").required = false;
                } else {
                    document.getElementById("class_id").required = true;
                }
                $(".class_id option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('payment.get_class_payment') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        school_level_id
                    },
                    success: response => {
                        console.log(response)
                        $('.class_id').append(`<option value="">-- Pilih Kelas --</option>`)
                        $.each(response.message, function(i, item) {
                            $('.class_id').append(
                                `<option value="${item.id}">${item.classes}</option>`
                            )
                        })
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        });
    </script>
@endsection
