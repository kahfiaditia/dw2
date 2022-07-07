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
            <form class="needs-validation" action="{{ route('classes.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Jenjang <code>*</code></label>
                                            <select class="form-control select select2 jenjang" name="jenjang"
                                                id="jenjang" required>
                                                <option value="">--Pilih Jenjang--</option>
                                                @foreach ($jurusan as $jur)
                                                    <option value="{{ $jur->id }}" data-id="{{ $jur->level }}">
                                                        {{ $jur->level }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('jenjang')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <select class="form-control select select2 kelas" name="kelas" id="kelas">
                                                <option value="">--Pilih Kelas--</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('kelas')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Jurusan</label>
                                            <input type="text" class="form-control" name="jurusan" placeholder="Jurusan"
                                                value="{{ old('jurusan') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('jurusan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Type <code>1 atau 2</code></label>
                                            <input type="text" class="form-control" name="type" placeholder="Type"
                                                value="{{ old('type') }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            @error('type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('classes.index') }}"
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
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".jenjang").change(function() {
                let jenjang = $(this).val();
                data_id_jenjang = this.querySelector(':checked').getAttribute('data-id');
                if (data_id_jenjang == 'KB' || data_id_jenjang == 'TK') {
                    document.getElementById("kelas").required = false;
                } else {
                    document.getElementById("kelas").required = true;
                }
                $(".kelas option").remove();
                $.ajax({
                    type: "POST",
                    url: '{{ route('classes.get_school_class') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        jenjang
                    },
                    success: response => {
                        $('.kelas').append(`<option value="">-- Pilih Kelas --</option>`)
                        $.each(response.message, function(i, item) {
                            $('.kelas').append(
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
