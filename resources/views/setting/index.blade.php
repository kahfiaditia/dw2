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
                                @if (count($settings) < 1)
                                    <a href="{{ route('setting.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Setting Website
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
                                        <th>Maintenance</th>
                                        <th>Provinsi Sekolah</th>
                                        <th>Hari Peminjaman Buku</th>
                                        <th>Limit Jumlah Peminjaman Buku</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($settings as $setting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($setting->maintenance == 1) {
                                                    echo 'success';
                                                } else {
                                                    echo 'info';
                                                } ?> font-size-12">
                                                    @if ($setting->maintenance == 1)
                                                        ON
                                                    @else
                                                        OFF
                                                    @endif
                                                </span>
                                            </td>
                                            <td>{{ $setting->provinsi_sekolah }}</td>
                                            <td>{{ $setting->library_loan_day }}</td>
                                            <td>{{ $setting->library_loan_validation }}</td>
                                            <td>
                                                <a href="{{ route('setting.edit', Crypt::encryptString($setting->id)) }}"
                                                    class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
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
