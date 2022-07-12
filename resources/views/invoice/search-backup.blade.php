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
                                            <label for="">NIK/NIS</label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ $students->nik }}" id="nik" readonly
                                                placeholder="NIK/NIS">
                                            @error('nik')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="text" class="form-control" name="siswa" id="siswa"
                                                value="{{ $students->nama_lengkap }}" readonly placeholder="Siswa">
                                            @error('siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" class="form-control class_siswa" name="kelas_siswa"
                                                value="{{ $students->classes_student->school_level->level .
                                                    ' ' .
                                                    $students->classes_student->school_class->classes .
                                                    ' ' .
                                                    $students->classes_student->jurusan .
                                                    ' ' .
                                                    $students->classes_student->type }}"
                                                id="class_siswa" readonly placeholder="Kelas">
                                            @error('kelas_siswa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Tahun Ajaran</label>
                                            <div class="input-daterange input-group" id="datepicker6">
                                                <input type="text" class="form-control" name="tahun_ajaran_start"
                                                    readonly value="{{ $payment_bulanan[0]->year }}"
                                                    placeholder="Start Date">
                                                <input type="text" class="form-control" name="tahun_ajaran_end" readonly
                                                    value="{{ $payment_bulanan[0]->year_end }}" placeholder="End Date">
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
                                        <input type="hidden" id="count_payment_tahunan"
                                            value="{{ count($payment_tahunan) }}">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Pembayaran</th>
                                                        <th class="text-center">Biaya</th>
                                                        <th class="text-center">Bayar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $noid = 0;
                                                    $no_thn = 1;
                                                    ?>
                                                    @foreach ($payment_tahunan as $item)
                                                        <tr>
                                                            <th valign="middle" class="text-center">{{ $no_thn++ }}
                                                            </th>
                                                            <td valign="middle">{{ $item->bills }}</td>
                                                            <td valign="middle" style="text-align: right;">
                                                                <input type="hidden" name="id<?php echo $noid; ?>"
                                                                    value="{{ $item->id . '|' . $item->school_class_id }}">
                                                                {{ number_format($item->amount) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" class="form-control rupiah"
                                                                    id="rupiah<?php echo $noid; ?>" name="bayar"
                                                                    oninput="numberFormat({{ $noid }});rupiahFormat({{ $noid }});"
                                                                    placeholder="Bayar">
                                                                <?php $noid++; ?>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Checklist
                                                            <input type="checkbox" onchange="checkAll(this)"
                                                                name="chk[]">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    $bulan = ['6', '7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5']; ?>
                                                    @foreach ($bulan as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <th>{{ date('F', mktime(0, 0, 0, $item, 10)) }}</th>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="bulan[]"
                                                                    value="{{ $item }}"
                                                                    onchange="checkChoice(this);" class="bulan">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Pembayaran</th>
                                                        <th class="text-center">Biaya</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- tahunan --}}
                                                    @foreach ($payment_tahunan as $item)
                                                        <tr>
                                                            <th valign="middle" class="text-center"><i
                                                                    class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                            <td valign="middle">{{ $item->bills }}</td>
                                                            <td valign="middle" style="text-align: right;">
                                                                <?php $name_item = str_replace(' ', '', $item->bills); ?>
                                                                <input type="hidden" name="{{ $name_item }}"
                                                                    id="{{ $name_item }}"
                                                                    value="{{ $item->amount }}">
                                                                {{ number_format($item->amount) }}
                                                            </td>
                                                            <td valign="middle" class="text-center">
                                                                @if ($name_item == 'UangFormulir')
                                                                    @if ($item->amount == $uang_formulir)
                                                                        <span
                                                                            class="badge badge-pill badge-soft-success font-size-12">
                                                                            Lunas
                                                                        </span>
                                                                    @endif
                                                                @elseif ($name_item == 'UangPangkal')
                                                                    @if ($item->amount == $uang_pangkal)
                                                                        <span
                                                                            class="badge badge-pill badge-soft-success font-size-12">
                                                                            Lunas
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-pill badge-soft-danger font-size-12">
                                                                            {{ number_format($uang_pangkal) }}
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    {{-- bulanan --}}
                                                    <?php $blnid = 0; ?>
                                                    @foreach ($payment_bulanan as $item)
                                                        <tr>
                                                            <th class="text-center"><i
                                                                    class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                            <td>{{ $item->bills }}</td>
                                                            <td style="text-align: right;">
                                                                <?php $name_item = str_replace(' ', '', $item->bills); ?>
                                                                <input type="text" name="{{ $name_item }}"
                                                                    id="{{ $name_item }}"
                                                                    value="{{ $item->amount }}">
                                                                <input type="text" name="blnid<?php echo $blnid; ?>"
                                                                    value="{{ $item->id . '|' . $item->school_class_id }}">
                                                                @
                                                                {{ number_format($item->amount) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    Lunas
                                                                </span> --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div hidden>
                                            <input type="text" name="studentsId"
                                                value="{{ Crypt::encryptString($students->id) }}">
                                            <input type="text" name="hiddentotal" id="hiddentotal" value=0>
                                            <input type="text" name="hiddenFormulir" id="hiddenFormulir" value=0>
                                            <input type="text" name="hiddenPangkal" id="hiddenPangkal" value=0>
                                            <input type="text" name="hiddenSpp" id="hiddenSpp" value=0>
                                            <input type="text" name="hiddenKegiatan" id="hiddenKegiatan" value=0>
                                        </div>
                                        <h3 class="mb-3">Total Pembayaran</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Uang Formulir</td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalFormulir">0</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Uang Pangkal</td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalPangkal">0</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>SPP</td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalSpp">0</div>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Uang Kegiatan</td>
                                                        <td style="text-align: right;">
                                                            <h5>
                                                                <div id="totalKegiatan">0</div>
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
        count_payment_tahunan = document.getElementById("count_payment_tahunan").value;
        for (let index = 0; index < count_payment_tahunan; index++) {
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
            uangKegiatan = document.getElementById("UangKegiatan").value;
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
                hiddentotal = checkboxes.length;
                jmlSpp = hiddentotal * spp;
                jmlKegiatan = hiddentotal * uangKegiatan;
                totalPembayaran = jmlSpp + jmlKegiatan;
                document.getElementById("hiddentotal").value = eval(hiddentotal);
                document.getElementById("hiddenSpp").value = eval(jmlSpp);
                document.getElementById("hiddenKegiatan").value = eval(jmlKegiatan);
                document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID').format(jmlSpp);
                document.getElementById("totalKegiatan").innerHTML = new Intl.NumberFormat('id-ID').format(jmlKegiatan);
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
                document.getElementById("hiddentotal").value = 0;
                document.getElementById("hiddenSpp").value = 0;
                document.getElementById("hiddenKegiatan").value = 0;
                document.getElementById("totalSpp").innerHTML = 0;
                document.getElementById("totalKegiatan").innerHTML = 0;
            }
            grandTotal();
        }

        function checkChoice(whichbox) {
            hiddentotal = document.getElementById("hiddentotal").value;
            spp = document.getElementById("SPP").value;
            uangKegiatan = document.getElementById("UangKegiatan").value;
            with(whichbox) {
                if (whichbox.checked == false) {
                    hiddentotal = eval(hiddentotal) - 1;
                } else {
                    hiddentotal = eval(hiddentotal) + 1;
                }
                jmlSpp = hiddentotal * spp;
                jmlKegiatan = hiddentotal * uangKegiatan;
                document.getElementById("hiddentotal").value = eval(hiddentotal);
                document.getElementById("hiddenSpp").value = eval(jmlSpp);
                document.getElementById("hiddenKegiatan").value = eval(jmlKegiatan);
                document.getElementById("totalSpp").innerHTML = new Intl.NumberFormat('id-ID').format(jmlSpp);
                document.getElementById("totalKegiatan").innerHTML = new Intl.NumberFormat('id-ID').format(
                    jmlKegiatan);
            }
            grandTotal();
        }

        function grandTotal() {
            if (document.getElementById("hiddenSpp").value > 0) {
                hiddenSpp = document.getElementById("hiddenSpp").value;
            } else {
                hiddenSpp = 0;
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
            GrandTotal = parseInt(hiddenSpp) + parseInt(hiddenKegiatan) + parseInt(hiddenPangkal) + parseInt(
                hiddenFormulir);
            document.getElementById("GrandTotal").innerHTML = new Intl.NumberFormat('id-ID').format(GrandTotal);
        }
    </script>
@endsection
