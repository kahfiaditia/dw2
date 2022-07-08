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
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="">Siswa</label>
                                            <input type="text" class="form-control" name="siswa" id="siswa"
                                                value="{{ $students->nama_lengkap }}" readonly placeholder="Siswa">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Checklist
                                                            <input type="checkbox" onchange="checkAll(this)" name="chk[]">
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
                                    <div class="col-md-6">
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
                                                    @foreach ($bills as $item)
                                                        <tr>
                                                            <th class="text-center"><i
                                                                    class="bx bx-right-arrow-circle font-size-18"></i></th>
                                                            <td>{{ $item->bills }}</td>
                                                            <td style="text-align: right;">
                                                                <?php echo $name_item = str_replace(' ', '', $item->bills); ?>
                                                                <input type="text" name="{{ $name_item }}"
                                                                    id="{{ $name_item }}"
                                                                    value="{{ $item->amount }}">
                                                                {{ number_format($item->amount) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="badge badge-pill badge-soft-success font-size-12">
                                                                    Lunas
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div>
                                            <input type="hidden" name="hiddentotal" id="hiddentotal" value=0>
                                            <input type="hidden" name="grandtotal" id="grandtotal" value=0>
                                        </div>
                                        <h1 class="card-title mb-3">Order Summary</h1>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered border-success mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Grand Total :</td>
                                                        <td>$ 1,857</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount : </td>
                                                        <td>- $ 157</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping Charge :</td>
                                                        <td>$ 25</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estimated Tax : </td>
                                                        <td>$ 19.22</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total :</th>
                                                        <th>$ 1744.22</th>
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
    <script type="text/javascript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByClassName('bulan');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
                document.getElementById("hiddentotal").value = eval(checkboxes.length);
                document.getElementById("grandtotal").value = eval(checkboxes.length * spp);
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
                document.getElementById("hiddentotal").value = 0;
                document.getElementById("grandtotal").value = 0;
            }
        }

        function checkChoice(whichbox) {
            hiddentotal = document.getElementById("hiddentotal").value;
            spp = document.getElementById("SPP").value;
            with(whichbox) {
                if (whichbox.checked == false) {
                    hiddentotal = eval(hiddentotal) - 1;
                } else {
                    hiddentotal = eval(hiddentotal) + 1;
                }
                document.getElementById("hiddentotal").value = eval(hiddentotal);
                document.getElementById("grandtotal").value = eval(hiddentotal * spp);
            }
        }
    </script>
@endsection
