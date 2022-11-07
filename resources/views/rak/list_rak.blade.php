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
                                @if (in_array('12', $session_menu))
                                    <a href="{{ route('rak.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Rak
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
                                        <th>Rak</th>
                                        <th>Tingkatan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $list->rak }}</td>
                                            <td>{{ $list->tingkatan }}</td>
                                            <td>
                                                <?php $id = Crypt::encryptString($list->id); ?>
                                                <form class="delete-form" action="{{ route('rak.destroy', $id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('13', $session_menu))
                                                            <a href="{{ route('rak.edit', $id) }}" class="text-success"><i
                                                                    class="mdi mdi-pencil font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('14', $session_menu))
                                                            <a href class="text-danger delete_confirm"><i
                                                                    class="mdi mdi-delete font-size-18"></i></a>
                                                        @endif
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
