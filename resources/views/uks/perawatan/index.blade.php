@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
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
                                @if (in_array('101', $session_menu))
                                    <a href="{{ route('perawatan.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Perawatan
                                    </a>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Perawatan</th>
                                        <th>Siswa</th>
                                        <th>Jenjang</th>
                                        <th>Gejala</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perawatan as $nama)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $nama->kode_perawatan }}</td>
                                            <td>{{ $nama->siswa->nama_lengkap }}</td>
                                            <td>{{ $nama->siswa->classes_student->school_level->level .
                                                ' ' .
                                                ($nama->siswa->classes_student->school_class ? $nama->siswa->classes_student->school_class->classes : '') .
                                                ' ' .
                                                $nama->siswa->classes_student->jurusan .
                                                ' ' .
                                                $nama->siswa->classes_student->type }}
                                            </td>
                                            <td>{{ $nama->gejala }}</td>
                                            <td>{{ $nama->masuk }}</td>
                                            <td>{{ $nama->keluar }}</td>
                                            <td>
                                                <?php $id = Crypt::encryptString($nama->kode_perawatan); ?>
                                                <form class="delete-form" action="{{ route('perawatan.destroy', $id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('100', $session_menu))
                                                            <a href="{{ route('perawatan.show', $id) }}" class="text-info"
                                                                title="View">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </a>
                                                        @endif

                                                        <?php if($nama->keluar == NULL) {?>
                                                        @if (in_array('103', $session_menu))
                                                            <a href class="text-danger delete_confirm" title="Hapus"><i
                                                                    class="mdi mdi-delete font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('102', $session_menu))
                                                            <a href="{{ route('perawatan.edit', $id) }}"
                                                                class="text-success" title="Edit"><i
                                                                    class="mdi mdi-pencil font-size-18"></i></a>
                                                        @endif

                                                        @if (in_array('102', $session_menu))
                                                            <a href="{{ route('perawatan.kembali_keluar', $id) }}"
                                                                class="text-warning" title="Siswa Keluar UKS"><i
                                                                    class="mdi mdi-orbit-variant font-size-18"></i></a>
                                                        @endif
                                                        <?php } ?>
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
@endsection
