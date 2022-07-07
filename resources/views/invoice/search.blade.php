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
                                            <label for="">NIS</label>
                                            <input type="text" class="form-control class_siswa" name="class_siswa"
                                                value="{{ $students->nisn }}" id="class_siswa" readonly
                                                placeholder="Kelas">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="text" class="form-control amount" name="amount" id="amount"
                                                value="{{ $students->nama_lengkap }}" readonly placeholder="Biaya">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" class="form-control class_siswa" name="class_siswa"
                                                value="{{ $students->classes_student->school_level->level .
                                                    ' ' .
                                                    $students->classes_student->school_class->classes .
                                                    ' ' .
                                                    $students->classes_student->jurusan .
                                                    ' ' .
                                                    $students->classes_student->type }}"
                                                id="class_siswa" readonly placeholder="Kelas">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Biaya</label>
                                            <input type="text" class="form-control amount" name="amount" id="amount"
                                                value="{{ $students->nama_lengkap }}" readonly placeholder="Biaya">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Checklist</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice as $item)
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Mark</td>
                                                    <td>Otto</td>
                                                    <td>@mdo</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('invoice.create') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
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
        $(document).ready(function() {

        });
    </script>
@endsection
