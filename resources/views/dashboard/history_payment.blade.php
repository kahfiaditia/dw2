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
                                            <label for="">NISN</label>
                                            <input type="text" class="form-control" name="nisn"
                                                value="{{ $students->nisn }}" id="nisn" readonly placeholder="NISN">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">NIK</label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ $students->nik }}" id="nik" readonly placeholder="NIK">
                                            @error('nik')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="text" class="form-control" name="siswa" id="siswa"
                                                value="{{ $students->nama_lengkap .
                                                    ' [' .
                                                    $students->classes_student->school_level->level .
                                                    ' ' .
                                                    $students->classes_student->school_class->classes .
                                                    ' ' .
                                                    $students->classes_student->jurusan .
                                                    '.' .
                                                    $students->classes_student->type .
                                                    ']' }}"
                                                readonly placeholder="Siswa">
                                            @error('siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Tahun Ajaran</label>
                                            <div class="input-daterange input-group" id="datepicker6">
                                                <input type="text" class="form-control" name="tahun_ajaran_start"
                                                    readonly value="{{ $students->spp->year }}" placeholder="Start Date">
                                                <input type="text" class="form-control" name="tahun_ajaran_end" readonly
                                                    value="{{ $students->spp->year_end }}" placeholder="End Date">
                                            </div>
                                            @error('tahun_ajaran_end')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title mb-4">Total Tagihan</h4>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 13%">#</th>
                                                        <th>Pembayaran</th>
                                                        <th class="text-center">Biaya</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle text-primary font-size-18"></i>
                                                        </th>
                                                        <td valign="middle">{{ $students->uang_formulir->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="UangFormulir" id="UangFormulir"
                                                                value="{{ $students->uang_formulir->amount }}">
                                                            {{ number_format($students->uang_formulir->amount) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($invoice_tahunan->formulir == $students->uang_formulir->amount)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_tahunan->formulir > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-danger font-size-12">
                                                                    {{ number_format($invoice_tahunan->formulir) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle text-primary font-size-18"></i>
                                                        </th>
                                                        <td valign="middle">{{ $students->uang_pangkal->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="UangPangkal" id="UangPangkal"
                                                                value="{{ $students->uang_pangkal->amount }}">
                                                            {{ number_format($students->uang_pangkal->amount) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($invoice_tahunan->pangkal == $students->uang_pangkal->amount)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_tahunan->pangkal > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-danger font-size-12">
                                                                    <i class="bx bx bx-minus-circle"></i>
                                                                    {{ number_format($invoice_tahunan->pangkal) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle text-primary font-size-18"></i>
                                                        </th>
                                                        <td valign="middle">{{ $students->spp->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="SPP_id"
                                                                value="{{ $students->spp->id }}">
                                                            <input type="hidden" name="SPP" id="SPP"
                                                                value="{{ $students->spp->amount }}">
                                                            @ {{ number_format($students->spp->amount) }}
                                                            ({{ number_format($students->spp->amount * 12) }})
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($invoice_bulanan->uang_spp == $students->spp->amount * 12)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_bulanan->uang_spp > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-danger font-size-12">
                                                                    <i class="bx bx bx-minus-circle"></i>
                                                                    {{ number_format($invoice_bulanan->uang_spp) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle text-primary font-size-18"></i>
                                                        </th>
                                                        <td valign="middle">{{ $students->kegiatan->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="Kegiatan_id"
                                                                value="{{ $students->kegiatan->id }}">
                                                            <input type="hidden" name="UangKegiatan" id="UangKegiatan"
                                                                value="{{ $students->kegiatan->amount }}">
                                                            @ {{ number_format($students->kegiatan->amount) }}
                                                            ({{ number_format($students->kegiatan->amount * 12) }})
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($invoice_bulanan->uang_kegiatan == $students->kegiatan->amount * 12)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_bulanan->uang_kegiatan > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-danger font-size-12">
                                                                    <i class="bx bx bx-minus-circle"></i>
                                                                    {{ number_format($invoice_bulanan->uang_kegiatan) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center" colspan="2">
                                                            <b>Total</b></td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <?php
                                                            $uang_formulir = $students->uang_formulir->amount;
                                                            $uang_pangkal = $students->uang_pangkal->amount;
                                                            $spp = $students->spp->amount * 12;
                                                            $kegiatan = $students->kegiatan->amount * 12;
                                                            ?>
                                                            <b>{{ number_format($uang_formulir + $uang_pangkal + $spp + $kegiatan) }}</b>
                                                        </td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="card-title mb-4">Bulanan</h4>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 13%">#</th>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $array_bulan = explode(',', $invoice_bulanan->bulan); ?>
                                                    <?php $no = 1;
                                                    $bulan = ['6', '7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5']; ?>
                                                    @foreach ($bulan as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <th>{{ date('F', mktime(0, 0, 0, $item, 10)) }}</th>
                                                            <td class="text-center">
                                                                @if (in_array($item, $array_bulan))
                                                                    <div class="event-timeline-dot">
                                                                        <i style="color:#34c38f;"
                                                                            class="bx bx-check-double font-size-18 font-size-24"></i>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="card-title mb-4">History Pembayaran</h4>
                                        <div data-simplebar="init" style="max-height: 610px;">
                                            <div class="simplebar-wrapper" style="margin: 0px;">
                                                <div class="simplebar-height-auto-observer-wrapper">
                                                    <div class="simplebar-height-auto-observer"></div>
                                                </div>
                                                <div class="simplebar-mask">
                                                    <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                                        <div class="simplebar-content-wrapper"
                                                            style="height: auto; overflow: hidden scroll;">
                                                            <div class="simplebar-content" style="padding: 0px;">
                                                                <ul class="verti-timeline list-unstyled">
                                                                    @foreach ($invoice as $item)
                                                                        <li class="event-list">
                                                                            <div class="event-timeline-dot">
                                                                                <i
                                                                                    class="bx bx-right-arrow-circle text-success font-size-18"></i>
                                                                            </div>
                                                                            <div class="d-flex">
                                                                                <div class="flex-shrink-0 me-3">
                                                                                    <h5 class="font-size-14">
                                                                                        {{ date('d F Y H:i:s', strtotime($item->created_at)) }}
                                                                                        <i
                                                                                            class="bx bx-right-arrow-alt font-size-16 text-info align-middle ms-2"></i>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="flex-grow-1">
                                                                                    <div>
                                                                                        {{ $item->bills->bills . ' (' . number_format($item->amount) . ')' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="simplebar-placeholder" style="width: auto; height: 481px;">
                                                </div>
                                            </div>
                                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar"
                                                    style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                <div class="simplebar-scrollbar"
                                                    style="height: 199px; transform: translate3d(0px, 0px, 0px); display: block;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('dashboard') }}"
                                            class="btn btn-secondary waves-effect">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
