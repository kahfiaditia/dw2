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
            <form class="needs-validation" action="{{ route('buku.print_barcode') }}" target="_blank" method="POST"
                novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Judul <code>*</code></label>
                                            <input type="text" class="form-control" id="judul" name="judul"
                                                value="{{ $item->judul }}" readonly placeholder="Judul">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Jumlah Print <code>*</code></label>
                                            <div class="input-group">
                                                <input name="jml" id="jml" type="number" class="form-control"
                                                    onkeyup="myFunction()" value="{{ $item->jml_buku }}"
                                                    placeholder="Jumlah Print">
                                                <span class="input-group-text"><i class="mdi mdi-printer"></i><i
                                                        class="mdi mdi-barcode"></i></span>
                                                <input name="jml_max" id="jml_max" type="hidden" class="form-control"
                                                    value="{{ $item->jml_buku }}" placeholder="Jumlah Print">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('buku.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Print</button>
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
        function myFunction() {
            var jml = document.getElementById("jml").value;
            var jml_max = document.getElementById("jml_max").value;
            if (parseInt(jml) > parseInt(jml_max)) {
                Swal.fire(
                    'Gagal',
                    'Print melebihi dari Jumlah Buku',
                    'error'
                )
                document.getElementById("jml").value = jml_max;
            }
        }
        $(document).ready(function() {
            $("#jml").change(function() {
                let jml = $(this).val();
                var jml_max = document.getElementById("jml_max").value;
                if (parseInt(jml) > parseInt(jml_max)) {
                    Swal.fire(
                        'Gagal',
                        'Print melebihi dari Jumlah Buku',
                        'error'
                    )
                    document.getElementById("jml").value = jml_max;
                }
            });
        });
    </script>
@endsection
