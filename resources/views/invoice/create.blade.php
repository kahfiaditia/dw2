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
            <form class="needs-validation" action="{{ route('invoice.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Tahun <code>*</code></label>
                                            <select class="form-control select select2" name="year" id="year"
                                                required>
                                                <option value="">--Pilih Tahun--</option>
                                                @for ($i = 2022; $i <= date('Y') + 1; $i++)
                                                    <option value='{{ $i }}'
                                                        {{ $i == date('Y') ? 'selected' : '' }}>
                                                        {{ $i }}
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
                                            <select class="form-control select select2" name="month" id="month"
                                                required>
                                                <option value="">--Pilih Bulan--</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value='{{ $i }}'
                                                        {{ $i == date('m') ? 'selected' : '' }}>
                                                        {{ date('F', strtotime('2022-' . $i . '-17')) }}
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
                                            <label for="">Jenjang <code>*</code></label>
                                            <select class="form-control select select2" name="class_id" id="class_id"
                                                required>
                                                <option value="">--Pilih Jenjang--</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">
                                                        {{ $class->jenjang }}
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
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Siswa <code>*</code></label>
                                            <select class="form-control select select2" name="siswa_id" id="siswa_id"
                                                required>
                                                <option value="">--Pilih Siswa--</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}">
                                                        {{ $student->nik . ' - ' . $student->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('siswa_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" class="form-control rupiah" name="class_id" readonly
                                                placeholder="Kelas">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('class_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Biaya</label>
                                            <input type="text" class="form-control rupiah" name="amount" readonly
                                                placeholder="Biaya">
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
                                        <a href="{{ route('invoice.index') }}"
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
    </script>
@endsection
