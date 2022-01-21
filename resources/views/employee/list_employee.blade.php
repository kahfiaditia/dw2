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
                            <a href="{{ route("employee.create") }}" type="button" class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Tambah Karyawan</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>NPWP</th>
                                <th>Kontak</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list->nama_lengkap }}</td>
                                        <td>{{ $list->nik }}</td>
                                        <td>{{ $list->npwp }}</td>
                                        <td>{{ $list->no_hp }}</td>
                                        <td>{{ $list->jabatan }}</td>
                                        <td>
                                            <span class="badge badge-pill badge-soft-<?php if($list->aktif === 1){ echo 'success'; }else{ echo 'danger'; }?> font-size-12">
                                                @if ($list->aktif === 1)
                                                    Aktif
                                                @else
                                                    Non Aktif
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            {{-- <?php $path = Storage::url('karyawan/nik/'.$list->dok_nik); ?>
                                            <img src="{{ $path }}"> --}}
                                            <?php $id = Crypt::encryptString($list->id); ?>
                                            <form class="delete-form" action="{{ route('employee.destroy', ['id' => $id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex gap-3">
                                                    <a href="{{ route('employee.show',['id' => $id]) }}" class="text-info"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    <a href="{{ route('employee.edit',['id' => $id]) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                    <a href class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>
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
