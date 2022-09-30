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
            <form class="needs-validation" action="{{ route('prestasi.update', Crypt::encryptString($prestasi->id)) }}"
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
                                            <label for="">Diskon Prestasi <code>*</code></label>
                                            <select class="form-control select select2" name="diskon" id="diskon"
                                                required>
                                                <option value="">--Pilih Type Diskon Pembayaran --</option>
                                                @foreach ($diskon as $disc)
                                                    <option value="{{ $disc->id }}"
                                                        {{ $prestasi->diskon_id == $disc->id ? 'selected' : '' }}>
                                                        {{ $disc->diskon }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('diskon', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Stard & End Date <code>*</code></label>
                                            <div class="input-daterange input-group" id="datepicker6"
                                                data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                                data-provide="datepicker" data-date-container="#datepicker6">
                                                <input type="text" class="form-control" name="start_date" required
                                                    value="{{ $prestasi->start_date }}" placeholder="Start Date">
                                                <input type="text" class="form-control" name="end_date" required
                                                    value="{{ $prestasi->end_date }}" placeholder="End Date">
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('end_date', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">NIS</label>
                                            <input type="text" class="form-control input-mask" name="nis"
                                                id="nis" data-inputmask="'mask': 'AA-99-99999'" placeholder="NIS"
                                                value="{{ $prestasi->student->nis }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('nis')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="hidden" id="siswa_id" value="{{ $prestasi->student->id }}">
                                            <select class="form-control select select2 siswa" name="siswa" id="siswa">
                                                <option value="">--Pilih Siswa --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('siswa', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('prestasi.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let siswa_id = document.getElementById("siswa_id").value;
            $.ajax({
                type: "POST",
                url: '{{ route('siswa.dropdown_siswa') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response.data, function(i, item) {
                        if (siswa_id == item.id) {
                            $('.siswa').append(
                                `<option value="${item.id}" data-id="${item.nis}" selected>${item.nama_lengkap}</option>`
                            )
                        } else {
                            $('.siswa').append(
                                `<option value="${item.id}" data-id="${item.nis}">${item.nama_lengkap}</option>`
                            )
                        }
                    })
                },
                error: (err) => {
                    console.log(err);
                },
            });

            $(".siswa").bind('change', function() {
                nis = this.querySelector(':checked').getAttribute('data-id')
                if (nis.length > 4) {
                    document.getElementById("nis").value = nis;
                } else {
                    document.getElementById("nis").value = '';
                }
            })

            $("#nis").bind('change', function() {
                let nis = $(this).val();
                nisBaru = nis.replace(/-/g, '');
                $(".siswa option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('siswa.dropdown_siswa') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: response => {
                        $.each(response.data, function(i, item) {
                            if (nisBaru == item.nis) {
                                $('.siswa').append(
                                    `<option value="${item.id}" selected data-id="${item.nis}">${item.nama_lengkap}</option>`
                                )
                            } else {
                                $('.siswa').append(
                                    `<option value="">-- Pilih Siswa --</option>`)
                                $('.siswa').append(
                                    `<option value="${item.id}" data-id="${item.nis}">${item.nama_lengkap}</option>`
                                )
                            }
                        })
                    },
                    error: (err) => Swal.fire('Error', 'Siswa tidak terdaftar',
                        'error')
                });
            });
        })
    </script>
@endsection
