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
                                @if (in_array('40', $session_menu))
                                    <a href="{{ route('payment.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Setting Pembayaran
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
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Jenjang</th>
                                        <th class="text-center">Kelas</th>
                                        <th class="text-center">Pembayaran</th>
                                        <th class="text-center">Biaya</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->year . ' s/d ' . $item->year_end }}</td>
                                            <td class="text-center">{{ $item->schools_level->level }}</td>
                                            <td class="text-center">
                                                {{ $item->schools_class ? $item->schools_class->classes : '' }}</td>
                                            <td class="text-center">{{ $item->bills->bills }}</td>
                                            <td class="text-center">{{ number_format($item->amount, 0, ',') }}</td>
                                            <td class="text-center">
                                                <form class="delete-form"
                                                    action="{{ route('payment.destroy', Crypt::encryptString($item->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('41', $session_menu))
                                                            <a href="{{ route('payment.edit', Crypt::encryptString($item->id)) }}"
                                                                class="text-success"><i
                                                                    class="mdi mdi-pencil font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('42', $session_menu))
                                                            <a href="" class="text-danger delete_confirm"><i
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
