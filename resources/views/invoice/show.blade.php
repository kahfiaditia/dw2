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
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">No Invoice</label>
                                            <input type="text" class="form-control" name="nisn"
                                                value="{{ $invoice->no_invoice }}" id="nisn" readonly
                                                placeholder="NISN">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">Tanggal Pembayaran</label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ $invoice->date_header }}" id="nik" readonly
                                                placeholder="NIK">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">NIS</label>
                                            <input type="text" class="form-control input-mask" name="nis"
                                                data-inputmask="'mask': 'AA-99-99999'" value="{{ $students->nis }}"
                                                id="nisn" readonly placeholder="NIS">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="text" class="form-control" name="siswa" id="siswa"
                                                value="{{ $students->nama_lengkap }}" readonly placeholder="Siswa">
                                            @error('siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" class="form-control" name="siswa" id="siswa"
                                                value="{{ $students->classes_student
                                                    ? $students->classes_student->school_level->level .
                                                        ' ' .
                                                        $students->classes_student->school_class->classes .
                                                        ' ' .
                                                        $students->classes_student->jurusan .
                                                        '.' .
                                                        $students->classes_student->type
                                                    : '' }}"
                                                readonly placeholder="Siswa">
                                            @error('siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">Tahun Ajaran</label>
                                            <div class="input-daterange input-group" id="datepicker6">
                                                <input type="text" class="form-control" name="tahun_ajaran_start"
                                                    readonly value="{{ $students->spp ? $students->spp->year : '' }}"
                                                    placeholder="Start Date">
                                                <input type="text" class="form-control" name="tahun_ajaran_end" readonly
                                                    value="{{ $students->spp ? $students->spp->year_end : '' }}"
                                                    placeholder="End Date">
                                            </div>
                                            @error('tahun_ajaran_end')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <div class="row">
                                    {{-- pembayaran --}}
                                    <div class="col-md-3">
                                        <h4 class="card-title mb-4">Pembayaran</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 14%">#</th>
                                                        <th>Pembayaran</th>
                                                        <th class="text-center">Biaya</th>
                                                        <th class="text-center" style="width: 30%">Bayar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $noid = 0;
                                                    $no_thn = 1;
                                                    ?>
                                                    <tr>
                                                        <th valign="middle" class="text-center">1</th>
                                                        <td valign="middle">
                                                            {{ $students->uang_formulir ? $students->uang_formulir->bills->bills : '' }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            {{ number_format($students->uang_formulir ? $students->uang_formulir->amount : 0) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ number_format($invoice->uang_formulir) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center">2</th>
                                                        <td valign="middle">
                                                            {{ $students->uang_pangkal ? $students->uang_pangkal->bills->bills : '' }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            {{ number_format($students->uang_pangkal ? $students->uang_pangkal->amount : 0) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ number_format($invoice->uang_pangkal) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-4">
                                            <hr>
                                            {{-- diskon prestasi --}}
                                            <h4 class="card-title mb-4 font-size-14 mb-4">Diskon Prestasi :</h4>
                                            @if ($prestasi)
                                                <i
                                                    class="mdi mdi-arrow-right text-primary me-1"></i>{{ $prestasi->diskon->diskon }}
                                                - Diskon
                                                ({{ $prestasi->diskon->diskon_persentase ? $prestasi->diskon->diskon_persentase . '%' : $prestasi->diskon->diskon_bln . ' Bulan' }})
                                            @endif
                                            <hr>
                                            {{-- diskon pembayaran --}}
                                            <h4 class="card-title mb-4 font-size-14 mb-4">Diskon Pembayaran Langsung :</h4>
                                            @foreach ($diskon as $dis)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="formRadios"
                                                        onclick="checkRadioButtonDiskonPembayaran()"
                                                        id="formRadios{{ $dis->jml_bln_byr }}"
                                                        {{ $invoice->diskon_id == $dis->id ? 'checked' : 'disabled' }}
                                                        value="{{ $dis->id }}">
                                                    <label class="form-check-label"
                                                        for="formRadios{{ $dis->jml_bln_byr }}">
                                                        {{ $dis->diskon }}
                                                        - Diskon
                                                        ({{ $dis->diskon_persentase ? $dis->diskon_persentase . '%' : $dis->diskon_bln . ' Bulan' }})
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- uang spp --}}
                                    <div class="col-md-3">
                                        <h4 class="card-title mb-4">Uang SPP</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 13%">#</th>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Pembayaran </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $array_bulan = explode(',', $invoice_bulanan ? $invoice_bulanan->bulan : ''); ?>
                                                    <?php $no = 1;
                                                    $bulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6']; ?>
                                                    @foreach ($bulan as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <th>{{ date('F', mktime(0, 0, 0, $item, 10)) }}</th>
                                                            <td class="text-center">
                                                                @if (in_array($item, $array_bulan))
                                                                    <input type="checkbox" name="bulan[]"
                                                                        value="{{ $item }}" readonly checked
                                                                        onchange="checkChoice(this);" class="bulan">
                                                                @else
                                                                    <input type="checkbox" name="bulan[]"
                                                                        value="{{ $item }}" disabled
                                                                        class="bulan">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                    </div>
                                    {{-- uang kegiatan --}}
                                    <div class="col-md-3">
                                        <h4 class="card-title mb-4">Uang Kegiatan</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 13%">#</th>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Pembayaran </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $array_kegiatan = explode(',', $invoice_kegiatan ? $invoice_kegiatan->kegiatan : ''); ?>
                                                    <?php $no = 1;
                                                    $kegiatan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4']; ?>
                                                    @foreach ($kegiatan as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <th>{{ date('F', mktime(0, 0, 0, $item, 10)) }}</th>
                                                            <td class="text-center">
                                                                @if (in_array($item, $array_kegiatan))
                                                                    <input type="checkbox" name="kegiatan[]"
                                                                        value="{{ $item }}" readonly checked
                                                                        onchange="uangKegiatanChoice(this);"
                                                                        class="kegiatan">
                                                                @else
                                                                    <input type="checkbox" name="kegiatan[]"
                                                                        value="{{ $item }}" disabled
                                                                        class="kegiatan">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="mb-4">Total Pembayaran</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 70%">
                                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                                <i class="bx bx bx-plus"></i>
                                                            </span>
                                                            Uang Formulir
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalFormulir">
                                                                    {{ number_format($invoice->uang_formulir) }}
                                                                </div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                                <i class="bx bx bx-plus"></i>
                                                            </span>
                                                            Uang Pangkal
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalPangkal">
                                                                    {{ number_format($invoice->uang_pangkal) }}</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                                <i class="bx bx bx-plus"></i>
                                                            </span>
                                                            SPP
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalSpp">
                                                                    {{ number_format($invoice->uang_spp) }}</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">
                                                                <i class="bx bx bx-plus"></i>
                                                            </span>
                                                            Uang Kegiatan
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalKegiatan">
                                                                    {{ number_format($invoice->uang_kegiatan) }}
                                                                </div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-pill badge-soft-danger font-size-12">
                                                                <i class="bx bx bx-minus"></i>
                                                            </span>
                                                            <b>Diskon Pembayaran</b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalDiskonPembayaran">
                                                                    {{ number_format($invoice->diskon_pembayaran) }}</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-pill badge-soft-danger font-size-12">
                                                                <i class="bx bx bx-minus"></i>
                                                            </span>
                                                            <b>Diskon Prestasi</b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalDiskonPrestasi">
                                                                    {{ number_format($invoice->diskon_prestasi) }}</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <h3>Grand Total</h3>
                                                        </th>
                                                        <td style="text-align: right;">
                                                            <h3>
                                                                <div id="GrandTotal">
                                                                    {{ number_format($invoice->grand_total) }}</div>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('invoice.index') }}"
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
    <script>
        function checkChoice() {
            var checkboxes = document.getElementsByClassName('bulan');
            if (checkboxes) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
            }
        }

        function uangKegiatanChoice() {
            var checkboxes = document.getElementsByClassName('kegiatan');
            if (checkboxes) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
            }
        }
    </script>
@endsection
