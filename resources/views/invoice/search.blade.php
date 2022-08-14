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
                                            <label for="">NIS</label>
                                            <input type="text" class="form-control input-mask" name="nis"
                                                data-inputmask="'mask': 'AA-99-99999'" value="{{ $students->nis }}"
                                                id="nisn" readonly placeholder="NIS">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">NISN</label>
                                            <input type="text" class="form-control" name="nisn"
                                                value="{{ $students->nisn }}" id="nisn" readonly placeholder="NISN">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="">NIK</label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ $students->nik }}" id="nik" readonly placeholder="NIK">
                                            @error('nik')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
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
                                                            <input type="hidden" name="PaymentIdFormulir"
                                                                value="{{ $students->formulir_id }}">
                                                            {{ number_format($students->uang_formulir ? $students->uang_formulir->amount : 0) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($students->uang_formulir)
                                                                @if ($invoice_tahunan->formulir == $students->uang_formulir->amount)
                                                                    <?php
                                                                    $readonly = 'readonly';
                                                                    $placeholder = 'Lunas';
                                                                    ?>
                                                                @else
                                                                    <?php
                                                                    $readonly = '';
                                                                    $placeholder = 'Bayar';
                                                                    ?>
                                                                @endif
                                                            @else
                                                                <?php
                                                                $readonly = 'readonly';
                                                                $placeholder = 'Bayar';
                                                                ?>
                                                            @endif
                                                            <input type="text" class="form-control rupiah"
                                                                maxlength="10" {{ $readonly }} id="rupiah0"
                                                                oninput="numberFormat(0);rupiahFormat(0);"
                                                                placeholder="{{ $placeholder }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center">2</th>
                                                        <td valign="middle">
                                                            {{ $students->uang_pangkal ? $students->uang_pangkal->bills->bills : '' }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="PaymentIdPangkal"
                                                                value="{{ $students->pangkal_id }}">
                                                            {{ number_format($students->uang_pangkal ? $students->uang_pangkal->amount : 0) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($students->uang_pangkal)
                                                                @if ($invoice_tahunan->pangkal == $students->uang_pangkal->amount)
                                                                    <?php $readonly = 'readonly'; ?>
                                                                @else
                                                                    <?php $readonly = ''; ?>
                                                                @endif
                                                            @else
                                                                <?php
                                                                $readonly = 'readonly';
                                                                $placeholder = 'Bayar';
                                                                ?>
                                                            @endif
                                                            <input type="text" class="form-control rupiah"
                                                                {{ $readonly }} maxlength="10" id="rupiah1"
                                                                oninput="numberFormat(1);rupiahFormat(1);"
                                                                placeholder="Bayar">
                                                        </td>
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
                                                        <th class="text-center">Checklist
                                                            <input type="checkbox" class="checkAll"
                                                                onchange="checkAll(this)" name="chk[]">
                                                        </th>
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
                                                                        value="{{ $item }}" disabled
                                                                        onchange="checkChoice(this);" class="bulan">
                                                                @else
                                                                    <input type="checkbox" name="bulan[]"
                                                                        value="{{ $item }}"
                                                                        onchange="checkChoice(this);" class="bulan">
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
                                                        <th class="text-center">Checklist
                                                            <input type="checkbox" onchange="checkUangKegiatan(this)"
                                                                name="chk[]">
                                                        </th>
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
                                                                        value="{{ $item }}" disabled
                                                                        onchange="uangKegiatanChoice(this);"
                                                                        class="kegiatan">
                                                                @else
                                                                    <input type="checkbox" name="kegiatan[]"
                                                                        value="{{ $item }}"
                                                                        onchange="uangKegiatanChoice(this);"
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
                                    {{-- total tagihan --}}
                                    <div class="col-md-3">
                                        <h4 class="card-title mb-4">Total Tagihan</h4>
                                        <div class="table-responsive">
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
                                                                class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                        <td valign="middle">
                                                            {{ $students->uang_formulir ? $students->uang_formulir->bills->bills : '' }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="UangFormulir" id="UangFormulir"
                                                                value="{{ $students->uang_formulir ? $students->uang_formulir->amount : 0 }}">
                                                            {{ number_format($students->uang_formulir ? $students->uang_formulir->amount : 0) }}
                                                        </td>
                                                        <td valign="middle" class="text-center">
                                                            @if ($students->uang_formulir)
                                                                @if ($invoice_tahunan->formulir == $students->uang_formulir->amount)
                                                                    <span
                                                                        class="badge badge-pill badge-soft-success font-size-12">
                                                                        <i class="bx bx bx-check-circle"></i>
                                                                        Lunas
                                                                    </span>
                                                                @elseif($invoice_tahunan->formulir > 0)
                                                                    <span
                                                                        class="badge badge-pill badge-soft-info font-size-12">
                                                                        <i class="bx bx bx-money"></i>
                                                                        {{ number_format($invoice_tahunan->formulir) }}
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                        <td valign="middle">{{ $students->uang_pangkal->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="UangPangkal" id="UangPangkal"
                                                                value="{{ $students->uang_pangkal->amount }}">
                                                            {{ number_format($students->uang_pangkal->amount) }}
                                                        </td>
                                                        <td valign="middle" class="text-center">
                                                            @if ($invoice_tahunan->pangkal == $students->uang_pangkal->amount)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_tahunan->pangkal > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-info font-size-12">
                                                                    <i class="bx bx bx-money"></i>
                                                                    {{ number_format($invoice_tahunan->pangkal) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle font-size-18"></i></th>
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
                                                        <td valign="middle" class="text-center">
                                                            @if ($invoice_bulanan->uang_spp == $students->spp->amount * 12)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_bulanan->uang_spp > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-info font-size-12">
                                                                    <i class="bx bx bx-money"></i>
                                                                    {{ number_format($invoice_bulanan->uang_spp) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th valign="middle" class="text-center"><i
                                                                class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                        <td valign="middle">{{ $students->kegiatan->bills->bills }}
                                                        </td>
                                                        <td valign="middle" style="text-align: right;">
                                                            <input type="hidden" name="Kegiatan_id"
                                                                value="{{ $students->kegiatan->id }}">
                                                            <input type="hidden" name="UangKegiatan" id="UangKegiatan"
                                                                value="{{ $students->kegiatan->amount / 10 }}">
                                                            @ {{ number_format($students->kegiatan->amount / 10) }}
                                                            ({{ number_format($students->kegiatan->amount) }})
                                                        </td>
                                                        <td valign="middle" class="text-center">
                                                            @if ($invoice_kegiatan->uang_kegiatan == $students->kegiatan->amount)
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    <i class="bx bx bx-check-circle"></i>
                                                                    Lunas
                                                                </span>
                                                            @elseif($invoice_kegiatan->uang_kegiatan > 0)
                                                                <span
                                                                    class="badge badge-pill badge-soft-info font-size-12">
                                                                    <i class="bx bx bx-money"></i>
                                                                    {{ number_format($invoice_kegiatan->uang_kegiatan) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div hidden>
                                            <div hidden>
                                                <input type="text" name="studentsId"
                                                    value="{{ Crypt::encryptString($students->id) }}">
                                                <input type="text" name="classId"
                                                    value="{{ Crypt::encryptString($students->class_id) }}">
                                            </div>
                                            <div hidden>
                                                <hr><label>formulir</label><br>
                                                <input type="text" name="hiddenFormulir" id="hiddenFormulir" value=0>
                                            </div>
                                            <div hidden>
                                                <hr><label>pangkal</label><br>
                                                <input type="text" name="hiddenPangkal" id="hiddenPangkal" value=0>
                                            </div>
                                            <div>
                                                <hr><label>spp</label><br>
                                                <input type="text" name="hiddentotal" id="hiddentotal" value=0>
                                                <input type="text" name="hiddenSpp" id="hiddenSpp" value=0>
                                            </div>
                                            <div>
                                                <hr><label>total yg sudah dibayarkan spp</label><br>
                                                <input type="text" name="hiddenInvoiceBulan" id="hiddenInvoiceBulan"
                                                    value="{{ $invoice_bulanan->count_bulan }}">
                                            </div>
                                            <div hidden>
                                                <hr><label>kegiatan</label><br>
                                                <input type="text" name="hiddentotalKegiatan" id="hiddentotalKegiatan"
                                                    value=0>
                                                <input type="text" name="hiddenKegiatan" id="hiddenKegiatan" value=0>
                                            </div>
                                            <div hidden>
                                                <hr><label>total yg sudah dibayarkan kegiatan</label><br>
                                                <input type="text" name="hiddenInvoiceKegiatan"
                                                    id="hiddenInvoiceKegiatan"
                                                    value="{{ $invoice_kegiatan->count_kegiatan }}">
                                            </div>
                                            <div hidden>
                                                <hr><label>diskon pembayaran</label><br>
                                                <input type="text" name="hiddendiskonPembayaran"
                                                    id="hiddendiskonPembayaran" value=0>
                                            </div>
                                            <div>
                                                <hr><label>diskon Prestasi</label><br>
                                                @if ($prestasi)
                                                    <?php
                                                    $data_prestasi = $prestasi->diskon->diskon_bln ? $prestasi->diskon->diskon_bln . '|bln|' . $prestasi->id : $prestasi->diskon->diskon_persentase . '|persen|' . $prestasi->id;
                                                    $idPrestasi = $prestasi->id;
                                                    ?>
                                                @else
                                                    <?php
                                                    $data_prestasi = null;
                                                    $idPrestasi = null;
                                                    ?>
                                                @endif
                                                <input type="text" name="hiddendiskonPrestasi"
                                                    id="hiddendiskonPrestasi" value={{ $data_prestasi }}>
                                                <br>id diskon prestasi
                                                <input type="text" name="idPrestasi" value="{{ $idPrestasi }}">
                                                <br>value diskon prestasi
                                                <input type="text" name="valueDiskonPrestasi" id="valueDiskonPrestasi"
                                                    value=0>
                                            </div>
                                            <div>
                                                <input type="text" name="grand_total" id="grand_total" value=0>
                                            </div>
                                        </div>
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
                                                                <div id="totalFormulir">0</div>
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
                                                                <div id="totalPangkal">0</div>
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
                                                                <div id="totalSpp">0</div>
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
                                                                <div id="totalKegiatan">0</div>
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
                                                                <div id="totalDiskonPembayaran">0</div>
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
                                                                <div id="totalDiskonPrestasi">0</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <h3>Grand Total</h3>
                                                        </th>
                                                        <td style="text-align: right;">
                                                            <h3>
                                                                <div id="GrandTotal">0</div>
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
                                        <a href="{{ route('invoice.create') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right" disabled
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
        var _array_bln = <?= json_encode($diskon) ?>

        $(document).ready(function() {
            spp = document.getElementById("SPP").value;
            hiddendiskonPrestasi = document.getElementById("hiddendiskonPrestasi").value;
            split = hiddendiskonPrestasi.split("|");
            let diskon = split[0]; // diskon_bln atau diskon_persentase
            let type = split[1]; // type bln atau persentase
            if (type == 'bln') {
                var checkboxes = document.getElementsByClassName('bulan');
                if (checkboxes) {
                    jml_bln = 0;
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                            if (jml_bln < diskon) {
                                checkboxes[i].checked = true;
                                jml_bln++;
                            } else {
                                checkboxes[i].disabled = true;
                            }
                        }
                    }
                    if (jml_bln == diskon) {
                        if (jml_bln > 0) {
                            jmlSpp = jml_bln * spp;
                            diskonPrestasi = jmlSpp;
                            diskon = jml_bln;
                        } else {
                            jmlSpp = 0;
                            diskonPrestasi = 0;
                            diskon = 0;
                        }
                    } else {
                        jmlSpp = 0;
                        diskonPrestasi = 0;
                        diskon = 0;
                        Swal.fire(
                            'Gagal',
                            'Diskon Prestasi Melebihi SPP yang harus dibayar harap rubah Diskon Prestasi terlebih dahulu.',
                            'error'
                        ).then(function() {
                            window.location = '/invoice/create'
                        })
                    }
                    document.getElementById("hiddentotal").value = eval(diskon);
                    document.getElementById("hiddenSpp").value = eval(diskonPrestasi);
                    document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID')
                        .format(jmlSpp);
                    document.getElementById("valueDiskonPrestasi").value = eval(diskonPrestasi);
                    document.getElementById("totalDiskonPrestasi").innerHTML = new Intl.NumberFormat('id-ID')
                        .format(
                            diskonPrestasi);
                    document.getElementsByClassName("checkAll")[0].style.display = 'none';
                }
            }
            grandTotal()
        });

        // radio button diskon pembayaran
        function checkRadioButtonDiskonPembayaran() {
            var getSelectedValue = document.querySelector('input[name="formRadios"]:checked');
            if (getSelectedValue != null) {
                id_diskon = getSelectedValue.value;
                $.ajax({
                    type: "POST",
                    url: '{{ route('diskon.get_diskon') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_diskon
                    },
                    success: response => {
                        var checkboxes = document.getElementsByClassName('bulan');
                        spp = document.getElementById("SPP").value;
                        hiddenInvoiceBulan = document.getElementById("hiddenInvoiceBulan").value;
                        jml_diskon = 0;
                        if (checkboxes) {
                            for (var i = 0; i < checkboxes.length; i++) {
                                if (checkboxes[i].type == 'checkbox') {
                                    checkboxes[i].checked = false;
                                }
                            }
                            hiddentotal = parseInt(checkboxes.length) - parseInt(hiddenInvoiceBulan);
                            if ((hiddentotal - response.data.jml_bln_byr) >= 0) {
                                for (var i = 0; i < checkboxes.length; i++) {
                                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                                        if (jml_diskon < response.data.jml_bln_byr) {
                                            checkboxes[i].checked = true;
                                            jml_diskon++;
                                        }
                                    }
                                }
                                hiddentotal = jml_diskon;
                                if (hiddentotal > 0) {
                                    jmlSpp = hiddentotal * spp;
                                    totalPembayaran = jmlSpp;
                                } else {
                                    jmlSpp = 0;
                                    totalPembayaran = 0;
                                }
                                document.getElementById("hiddentotal").value = eval(hiddentotal);
                                document.getElementById("hiddenSpp").value = eval(jmlSpp);
                                document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID')
                                    .format(jmlSpp);

                                if (response.data.diskon_persentase > 0) {
                                    diskonPembayaran = (response.data.diskon_persentase / 100) * jmlSpp
                                    document.getElementById("hiddendiskonPembayaran").value = eval(
                                        diskonPembayaran);
                                    document.getElementById("totalDiskonPembayaran").innerHTML = new Intl
                                        .NumberFormat('id-ID')
                                        .format(diskonPembayaran);
                                } else if (response.data.diskon_bln > 0) {
                                    diskonPembayaran = spp * response.data.diskon_bln
                                    document.getElementById("hiddendiskonPembayaran").value = eval(
                                        diskonPembayaran);
                                    document.getElementById("totalDiskonPembayaran").innerHTML = new Intl
                                        .NumberFormat('id-ID')
                                        .format(diskonPembayaran);
                                } else {
                                    document.getElementById("hiddendiskonPembayaran").value = 0;
                                    document.getElementById("totalDiskonPembayaran").innerHTML = 0;
                                }
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    'Diskon Pembayaran Langsung tidak bisa dipilih',
                                    'error'
                                ).then(function() {
                                    $('input[type="radio"]').prop('checked', false);
                                })
                                document.getElementById("hiddentotal").value = 0;
                                document.getElementById("hiddenSpp").value = 0;
                                document.getElementById("totalSpp").innerHTML = 0;
                                document.getElementById("hiddendiskonPembayaran").value = 0;
                                document.getElementById("totalDiskonPembayaran").innerHTML = 0;
                            }
                            grandTotal();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            }
        }

        for (let index = 0; index < 2; index++) {
            function numberFormat(baris) {
                return document.getElementById('rupiah' + baris).value = document.getElementById('rupiah' + baris).value
                    .replace(/[^0-9.]/g, '').replace(/(\*?)\*/g, '$1')
            }

            function rupiahFormat(baris) {
                let rupiahInput = document.getElementById('rupiah' + baris)
                let rupiahReplace = rupiahInput.value.replaceAll('.', '')
                let rupiahValue = new Intl.NumberFormat('id-ID').format(rupiahReplace)
                if (baris == 0) {
                    if (eval(rupiahReplace) > eval(document.getElementById("UangFormulir").value)) {
                        rupiahValue = new Intl.NumberFormat('id-ID').format(document.getElementById("UangFormulir")
                            .value)
                        document.getElementById("totalFormulir").innerHTML = rupiahValue;
                        document.getElementById("hiddenFormulir").value = document.getElementById("UangFormulir")
                            .value
                    } else {
                        document.getElementById("totalFormulir").innerHTML = rupiahValue;
                        document.getElementById("hiddenFormulir").value = rupiahReplace;
                    }
                } else if (baris == 1) {
                    if (eval(rupiahReplace) > eval(document.getElementById("UangPangkal").value)) {
                        rupiahValue = new Intl.NumberFormat('id-ID').format(document.getElementById("UangPangkal")
                            .value)
                        document.getElementById("totalPangkal").innerHTML = rupiahValue;
                        document.getElementById("hiddenPangkal").value = document.getElementById("UangPangkal")
                            .value;
                    } else {
                        document.getElementById("totalPangkal").innerHTML = rupiahValue;
                        document.getElementById("hiddenPangkal").value = rupiahReplace;
                    }
                }
                grandTotal();
                return rupiahInput.value = rupiahValue
            }
        }

        function checkAll(ele) {
            var checkboxes = document.getElementsByClassName('bulan');
            spp = document.getElementById("SPP").value;
            hiddenInvoiceBulan = document.getElementById("hiddenInvoiceBulan").value;
            if (ele.checked) {
                hiddentotal = parseInt(checkboxes.length) - parseInt(hiddenInvoiceBulan);
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
                if (hiddentotal > 0) {
                    jmlSpp = hiddentotal * spp;
                    totalPembayaran = jmlSpp;
                } else {
                    jmlSpp = 0;
                    totalPembayaran = 0;
                }
                document.getElementById("hiddentotal").value = eval(hiddentotal);
                document.getElementById("hiddenSpp").value = eval(jmlSpp);
                document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID').format(jmlSpp);

                var itmDisk = _array_bln.find(el => el.jml_bln_byr == hiddentotal)
                if (itmDisk) {
                    // membuat radio button terpilih
                    document.getElementById("formRadios" + hiddentotal).checked = true;
                    checkRadioButtonDiskonPembayaran()
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
                document.getElementById("hiddentotal").value = 0;
                document.getElementById("hiddenSpp").value = 0;
                document.getElementById("totalSpp").innerHTML = 0;
                // clear radio button
                document.getElementById("hiddendiskonPembayaran").value = 0;
                document.getElementById("totalDiskonPembayaran").innerHTML = 0;
                $('input[type="radio"]').prop('checked', false);
            }
            grandTotal();
        }

        function checkChoice(whichbox) {
            valueDiskonPrestasi = document.getElementById("valueDiskonPrestasi").value;
            if (valueDiskonPrestasi > 0) {
                var checkboxes = document.getElementsByClassName('bulan');
                if (checkboxes) {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                            checkboxes[i].checked = true;
                        }
                    }
                }
            } else {
                hiddentotal = document.getElementById("hiddentotal").value;
                spp = document.getElementById("SPP").value;
                with(whichbox) {
                    if (whichbox.checked == false) {
                        hiddentotal = eval(hiddentotal) - 1;
                    } else {
                        hiddentotal = eval(hiddentotal) + 1;
                    }
                    jmlSpp = hiddentotal * spp;
                    document.getElementById("hiddentotal").value = eval(hiddentotal);
                    document.getElementById("hiddenSpp").value = eval(jmlSpp);
                    document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID').format(jmlSpp);

                    var itmDisk = _array_bln.find(el => el.jml_bln_byr == hiddentotal)
                    if (itmDisk) {
                        // membuat radio button terpilih
                        document.getElementById("formRadios" + hiddentotal).checked = true;
                        checkRadioButtonDiskonPembayaran()
                    } else {
                        // clear radio button
                        document.getElementById("hiddendiskonPembayaran").value = 0;
                        document.getElementById("totalDiskonPembayaran").innerHTML = 0;
                        $('input[type="radio"]').prop('checked', false);
                        document.getElementById("totalDiskonPrestasi").innerHTML = 0;
                    }
                }
            }
            grandTotal();
        }

        function checkUangKegiatan(ele) {
            var checkboxes = document.getElementsByClassName('kegiatan');
            uangKegiatan = document.getElementById("UangKegiatan").value;
            hiddenInvoiceKegiatan = document.getElementById("hiddenInvoiceKegiatan").value;
            if (ele.checked) {
                hiddentotal = parseInt(checkboxes.length) - parseInt(hiddenInvoiceKegiatan);
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
                if (hiddentotal > 0) {
                    jmlKegiatan = hiddentotal * uangKegiatan;
                    totalPembayaran = jmlKegiatan;
                } else {
                    jmlKegiatan = 0;
                    totalPembayaran = 0;
                }

                document.getElementById("hiddentotalKegiatan").value = eval(hiddentotal);
                document.getElementById("hiddenKegiatan").value = eval(jmlKegiatan);
                document.getElementById("totalKegiatan").innerHTML = new Intl.NumberFormat('id-ID').format(jmlKegiatan);
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
                document.getElementById("hiddentotalKegiatan").value = 0;
                document.getElementById("hiddenKegiatan").value = 0;
                document.getElementById("totalKegiatan").innerHTML = 0;
            }
            grandTotal();
        }

        function uangKegiatanChoice(whichbox) {
            hiddentotalKegiatan = document.getElementById("hiddentotalKegiatan").value;
            uangKegiatan = document.getElementById("UangKegiatan").value;
            with(whichbox) {
                if (whichbox.checked == false) {
                    hiddentotal = eval(hiddentotalKegiatan) - 1;
                } else {
                    hiddentotal = eval(hiddentotalKegiatan) + 1;
                }
                jmlKegiatan = hiddentotal * uangKegiatan;
                document.getElementById("hiddentotalKegiatan").value = eval(hiddentotal);
                document.getElementById("hiddenKegiatan").value = eval(jmlKegiatan);
                document.getElementById("totalKegiatan").innerHTML = new Intl.NumberFormat('id-ID').format(
                    jmlKegiatan);
            }
            grandTotal();
        }

        function grandTotal() {
            if (document.getElementById("hiddenSpp").value > 0) {
                hiddenSpp = document.getElementById("hiddenSpp").value;
                diskonPrestasi = document.getElementById("valueDiskonPrestasi").value;
            } else {
                hiddenSpp = 0;
                diskonPrestasi = 0;
            }
            if (document.getElementById("hiddenKegiatan").value > 0) {
                hiddenKegiatan = document.getElementById("hiddenKegiatan").value;
            } else {
                hiddenKegiatan = 0;
            }
            if (document.getElementById("hiddenPangkal").value > 0) {
                hiddenPangkal = document.getElementById("hiddenPangkal").value;
            } else {
                hiddenPangkal = 0;
            }
            if (document.getElementById("hiddenFormulir").value > 0) {
                hiddenFormulir = document.getElementById("hiddenFormulir").value;
            } else {
                hiddenFormulir = 0;
            }
            if (document.getElementById("hiddendiskonPembayaran").value > 0) {
                hiddendiskonPembayaran = document.getElementById("hiddendiskonPembayaran").value;
            } else {
                hiddendiskonPembayaran = 0;
            }

            GrandTotal = parseFloat(hiddenSpp) + parseFloat(hiddenKegiatan) + parseFloat(hiddenPangkal) + parseFloat(
                hiddenFormulir) - parseFloat(hiddendiskonPembayaran) - parseFloat(diskonPrestasi);
            document.getElementById("GrandTotal").innerHTML = new Intl.NumberFormat('id-ID').format(GrandTotal);
            document.getElementById("grand_total").value = parseFloat(GrandTotal);

            if (hiddenSpp > 0 || hiddenKegiatan > 0 || hiddenPangkal > 0 || hiddenFormulir > 0 || hiddendiskonPembayaran >
                0 || diskonPrestasi > 0) {
                document.getElementById("submit").disabled = false;
            } else {
                document.getElementById("submit").disabled = true;
            }
        }
    </script>
@endsection
