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
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout-tabs">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-data-tab" data-bs-toggle="pill" href="#v-pills-data"
                                role="tab" aria-controls="v-pills-data" aria-selected="true">
                                <i class="bx bx-user d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Data Karyawan</p>
                            </a>
                            <a class="nav-link" id="v-pills-ijazah-tab" data-bs-toggle="pill" href="#v-pills-ijazah"
                                role="tab" aria-controls="v-pills-ijazah" aria-selected="false">
                                <i class="bx bx-book-content d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Ijazah + Sertifikat</p>
                            </a>
                            <a class="nav-link" id="v-pills-sk-tab" data-bs-toggle="pill" href="#v-pills-sk"
                                role="tab" aria-controls="v-pills-sk" aria-selected="false">
                                <i class="bx bx-food-menu d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">SK Pengangkatan</p>
                            </a>
                            <a class="nav-link" id="v-pills-anak-tab" data-bs-toggle="pill" href="#v-pills-anak"
                                role="tab" aria-controls="v-pills-anak" aria-selected="true">
                                <i class="bx bx-group d-block check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Jumlah Anak</p>
                            </a>
                            <a class="nav-link" id="v-pills-riwayat-tab" data-bs-toggle="pill" href="#v-pills-riwayat"
                                role="tab" aria-controls="v-pills-riwayat" aria-selected="true">
                                <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
                                <i class="bx bx-phone check-nav-icon mt-2"></i>
                                <p class="fw-bold mb-4">Riwayat Penyakit & Kontak</p>
                            </a>
                        </div>
                    </div>
                    <?php
                    function hitung_umur($tanggal_lahir)
                    {
                        $birthDate = new DateTime($tanggal_lahir);
                        $today = new DateTime('today');
                        if ($birthDate > $today) {
                            exit('0 tahun 0 bulan 0 hari');
                        }
                        $y = $today->diff($birthDate)->y;
                        $m = $today->diff($birthDate)->m;
                        $d = $today->diff($birthDate)->d;
                        return $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';
                    }
                    ?>
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-data" role="tabpanel"
                                        aria-labelledby="v-pills-data-tab">
                                        <div class="d-flex">
                                            @if ($item->foto)
                                                <div class="flex-shrink-0 me-4">
                                                    <img src="{{ Storage::url('karyawan/foto/' . $item->foto) }}" alt=""
                                                        class="avatar-sm rounded">
                                                </div>
                                            @endif
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-15">{{ $item->nama_lengkap }}</h5>
                                                <p class="text-muted">
                                                    {{ $item->tempat_lahir . ', ' . date('d F Y', strtotime($item->tgl_lahir)) }}
                                                    ({{ hitung_umur($item->tgl_lahir) }})
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Email</h5>
                                                    <p class="text-muted mb-0">{{ $item->user->email }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Roles</h5>
                                                    <p class="text-muted mb-0">{{ $item->user->roles }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">No Kontak dan Whatsapp</h5>
                                                    <p class="text-muted mb-0">{{ $item->npwp }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">No KTP</h5>
                                                    <p class="text-muted mb-0">{{ $item->nik }}</p>
                                                    @if ($item->dok_nik)
                                                        <a href="javascript:void(0)"
                                                            data-id="{{ $item->dok_nik . '|nik|karyawan' }}"
                                                            id="get_data" data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-lg">
                                                            <i
                                                                class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                            Dokumen
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Kartu keluarga</h5>
                                                    <p class="text-muted mb-0">{{ $item->kk }}</p>
                                                    @if ($item->dok_kk)
                                                        <a href="javascript:void(0)"
                                                            data-id="{{ $item->dok_kk . '|kk|karyawan' }}" id="get_data"
                                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                            <i
                                                                class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                            Dokumen
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">NPWP</h5>
                                                    <p class="text-muted mb-0">{{ $item->npwp }}</p>
                                                    @if ($item->dok_npwp)
                                                        <a href="javascript:void(0)"
                                                            data-id="{{ $item->dok_npwp . '|npwp|karyawan' }}"
                                                            id="get_data" data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-lg">
                                                            <i
                                                                class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                            Dokumen
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">No BPJS Kesehatan</h5>
                                                    <p class="text-muted mb-0">{{ $item->bpjs_kesehatan }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">No BPJS Ketenagakerjaan</h5>
                                                    <p class="text-muted mb-0">{{ $item->bpjs_ketenagakerjaan }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Agama</h5>
                                                    <p class="text-muted mb-0">{{ $item->agama->agama }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Golongan Darah</h5>
                                                    <p class="text-muted mb-0">{{ $item->golongan_darah }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Nama Pasangan</h5>
                                                    <p class="text-muted mb-0">{{ $item->nama_pasangan }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">No Kontak Pasangan</h5>
                                                    <p class="text-muted mb-0">{{ $item->no_pasangan }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="font-size-15 mt-4">Alamat KTP :</h5>
                                        <p class="text-muted">
                                            {{ $item->alamat_asal .
                                                ', RT. ' .
                                                $item->rt_asal .
                                                ', RW. ' .
                                                $item->rw_asal .
                                                ', Dusun. ' .
                                                $item->dusun_asal .
                                                ', Kel.  ' .
                                                $item->kelurahan_asal .
                                                ', Kec. ' .
                                                $item->kecamatan_asal }}<br>
                                            {{ 'Kota. ' . $item->kota_asal . ', Provinsi. ' . $item->provinsi_asal . ', Kode Pos. ' . $item->kodepos_asal }}
                                        </p>
                                        <h5 class="font-size-15 mt-4">Alamat di Tangerang :</h5>
                                        <p class="text-muted">
                                            {{ $item->alamat .
                                                ', RT. ' .
                                                $item->rt .
                                                ', RW. ' .
                                                $item->rw .
                                                ', Dusun. ' .
                                                $item->dusun .
                                                ', Kel.  ' .
                                                $item->kelurahan .
                                                ', Kec. ' .
                                                $item->kecamatan }}<br>
                                            {{ 'Kota: ' . $item->kota . ', Provinsi: ' . $item->provinsi . ', Kode Pos: ' . $item->kodepos }}
                                        </p>
                                        <div class="row task-dates">
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Jabatan</h5>
                                                    <p class="text-muted mb-0">{{ $item->jabatan }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Tanggal Masuk Kerja</h5>
                                                    <p class="text-muted mb-0">
                                                        {{ date('d F Y', strtotime($item->masuk_kerja)) }}
                                                        ({{ hitung_umur($item->masuk_kerja) }})</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <div class="mt-4">
                                                    <h5 class="font-size-14">Status Aktif</h5>
                                                    <input type="checkbox" id="switch1" switch="none" name="aktif" disabled
                                                        {{ $item->aktif === '1' ? 'checked' : '' }} />
                                                    <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-ijazah" role="tabpanel"
                                        aria-labelledby="v-pills-ijazah-tab">
                                        @if (count($ijazah) > 0)
                                            <?php $no = 01; ?>
                                            @foreach ($ijazah as $item)
                                                <?php $no++; ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="HeadingIjazah<?php echo $no; ?>">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOneIjazah<?php echo $no; ?>"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOneIjazah<?php echo $no; ?>">
                                                            {{ $item->type }}
                                                            @if ($item->type == 'Akademik')
                                                                {{ ' - ' . $item->gelar_ijazah }}
                                                            @endif
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOneIjazah<?php echo $no; ?>"
                                                        class="accordion-collapse collapse show"
                                                        aria-labelledby="HeadingIjazah<?php echo $no; ?>"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="text-muted">
                                                                <div class="col-12">
                                                                    <?php
                                                                    $query_ijazah = DB::table('ijazah_karyawan')
                                                                        ->where('karyawan_id', $item->karyawan_id)
                                                                        ->where('gelar_ijazah', $item->gelar_ijazah)
                                                                        ->get();
                                                                    ?>
                                                                    <table id=""
                                                                        class="table table-striped dt-responsive nowrap w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Nama Sekolah/<br> Universitas/<br>
                                                                                    Instansi
                                                                                </th>
                                                                                <th>Tahun Pendidikan</th>
                                                                                <th>Jenis</th>
                                                                                <th>Akademik</th>
                                                                                <th>Dokumen Ijazah</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($query_ijazah as $list)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $list->type === 'Akademik' ? $list->nama_pendidikan : $list->instansi }}
                                                                                    </td>
                                                                                    <td>{{ $list->tahun_masuk ? $list->tahun_masuk . ' s/d ' . $list->tahun_lulus : '' }}
                                                                                    </td>
                                                                                    <td>{{ $list->type }}</td>
                                                                                    <td>{{ $list->type === 'Akademik' ? $list->gelar_akademik_pendek : $list->gelar_non_akademik_pendek }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($list->dok_ijazah)
                                                                                            <a href="javascript:void(0)"
                                                                                                data-id="{{ $list->dok_ijazah . '|ijazah|ijazah' }}"
                                                                                                id="get_data"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target=".bs-example-modal-lg">
                                                                                                <i
                                                                                                    class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                                                Dokumen
                                                                                            </a>
                                                                                        @endif
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
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                <a class="alert-link">Belum isi Ijazah</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-sk" role="tabpanel"
                                        aria-labelledby="v-pills-sk-tab">
                                        @if (count($sk) > 0)
                                            <table id="" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No SK</th>
                                                        <th>Tanggal SK</th>
                                                        <th>Jabatan</th>
                                                        <th>Dokumen SK</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sk as $list)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $list->no_sk }}</td>
                                                            <td>{{ date('d F Y', strtotime($list->tgl_sk)) }}</td>
                                                            <td>{{ $list->jabatan }}</td>
                                                            <td>
                                                                @if ($list->dok_sk)
                                                                    <a href="javascript:void(0)"
                                                                        data-id="{{ $list->dok_sk . '|sk|sk' }}"
                                                                        id="get_data" data-bs-toggle="modal"
                                                                        data-bs-target=".bs-example-modal-lg">
                                                                        <i
                                                                            class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                                        Dokumen
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                <a class="alert-link">Belum isi SK Pengangkatan</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-anak" role="tabpanel"
                                        aria-labelledby="v-pills-anak-tab">
                                        @if (count($child) > 0 and count($school) > 0)
                                            <div class="mt-4">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOneAnak">
                                                            <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseOneAnak"
                                                                aria-expanded="true" aria-controls="collapseOneAnak">
                                                                Anak Karyawan
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOneAnak" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOneAnak"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="text-muted">
                                                                    <div class="col-12">
                                                                        <table id=""
                                                                            class="table table-striped dt-responsive nowrap w-100">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Anak Ke</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Usia</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($child as $list)
                                                                                    <tr>
                                                                                        <td>{{ $list->anak_ke }}</td>
                                                                                        <td>{{ $list->nama }}</td>
                                                                                        <td>{{ $list->usia }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwoAnak">
                                                            <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseTwoAnak"
                                                                aria-expanded="false" aria-controls="collapseTwoAnak">
                                                                Anak Karyawan Sekolah di Dharmawidya
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwoAnak" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingTwoAnak"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="text-muted">
                                                                    <div class="col-12">
                                                                        <table id=""
                                                                            class="table table-striped dt-responsive nowrap w-100">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Nama</th>
                                                                                    <th>Jenjang</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($school as $list)
                                                                                    <tr>
                                                                                        <td>{{ $list->anak_karyawans->nama }}
                                                                                        </td>
                                                                                        <td>{{ $list->jenjang }}</td>
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
                                            </div>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                <a class="alert-link">Belum isi Jumlah Anak</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-riwayat" role="tabpanel"
                                        aria-labelledby="v-pills-riwayat-tab">
                                        @if (count($riwayat) > 0 and count($kontak) > 0)
                                            <div class="mt-4">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOneKontak">
                                                            <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOneKontak" aria-expanded="true"
                                                                aria-controls="collapseOneKontak">
                                                                Riwayat Penyakit
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOneKontak"
                                                            class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOneKontak"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="text-muted">
                                                                    <div class="col-12">
                                                                        <div class="table-rep-plugin">
                                                                            <div class="table-responsive mb-0"
                                                                                data-pattern="priority-columns">
                                                                                <table id="tech-companies-1"
                                                                                    class="table table-striped">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>No</th>
                                                                                            <th>Penyakit</th>
                                                                                            <th>Keterangan</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($riwayat as $list)
                                                                                            <tr>
                                                                                                <td>{{ $loop->iteration }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <label
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="{{ $list->penyakit }}">
                                                                                                        @if (strlen($list->penyakit) > 25)
                                                                                                            {{ substr($list->penyakit, 0, 25) . '..' }}
                                                                                                        @else
                                                                                                            {{ $list->penyakit }}
                                                                                                        @endif
                                                                                                    </label>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <label
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="{{ $list->keterangan }}">
                                                                                                        @if (strlen($list->keterangan) > 70)
                                                                                                            {{ substr($list->keterangan, 0, 70) . '..' }}
                                                                                                        @else
                                                                                                            {{ $list->keterangan }}
                                                                                                        @endif
                                                                                                    </label>
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
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwoKontak">
                                                            <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseTwoKontak" aria-expanded="false"
                                                                aria-controls="collapseTwoKontak">
                                                                Kontak
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwoKontak"
                                                            class="accordion-collapse collapse show"
                                                            aria-labelledby="headingTwoKontak"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="text-muted">
                                                                    <div class="col-12">
                                                                        <div class="table-rep-plugin">
                                                                            <div class="table-responsive mb-0"
                                                                                data-pattern="priority-columns">
                                                                                <table id="tech-companies-1"
                                                                                    class="table table-striped">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>No</th>
                                                                                            <th>Nama</th>
                                                                                            <th>No HP</th>
                                                                                            <th>Keterangan</th>
                                                                                            <th>Tipe</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($kontak as $list)
                                                                                            <tr>
                                                                                                <td>{{ $loop->iteration }}
                                                                                                </td>
                                                                                                <td>{{ $list->nama }}
                                                                                                </td>
                                                                                                <td>{{ $list->no_hp }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <label
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="{{ $list->keterangan }}">
                                                                                                        @if (strlen($list->keterangan) > 25)
                                                                                                            {{ substr($list->keterangan, 0, 25) . '..' }}
                                                                                                        @else
                                                                                                            {{ $list->keterangan }}
                                                                                                        @endif
                                                                                                    </label>
                                                                                                </td>
                                                                                                <td>{{ $list->tipe }}
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
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                <a class="alert-link">Belum isi Riwayat dan Kontak</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dynamic-content"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#get_data', function(e) {
                e.preventDefault();
                var id = $(this).data('id'); // it will get id of clicked row
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                var url = "{{ route('employee.dokumen') }}"
                $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        }
                    })
                    .done(function(url) {
                        $('#dynamic-content').html(url); // load response
                        $('#modal-loader').hide(); // hide ajax loader
                    })
                    .fail(function(err) {
                        $('#dynamic-content').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });
            });
        });
    </script>
@endsection
