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
                                @if (in_array('87', $session_menu))
                                    <a href="{{ route('inv_pinjaman.create') }}" type="button"
                                        class="float-end btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> Pinjaman Inventaris
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
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium <?php if (isset($_GET['kode'])) {
                                        } else {
                                            echo 'collapsed';
                                        } ?>" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <i class="bx bx-search-alt font-size-18"></i>
                                            <b>Cari & Unduh Data</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse <?php
                                    if (empty($_GET['like']) and (isset($_GET['kode']) or isset($_GET['peminjam']) or isset($_GET['kelas']) or isset($_GET['tgl_start']) or isset($_GET['tgl_end']) or isset($_GET['jml_start']) or isset($_GET['jml_end']) or isset($_GET['type']))) {
                                        if ($_GET['kode'] != null or $_GET['peminjam'] != null or $_GET['kelas'] != null or $_GET['tgl_start'] != null or $_GET['tgl_end'] != null or $_GET['jml_start'] != null or $_GET['jml_end'] != null or $_GET['type'] != null) {
                                            echo 'show';
                                        }
                                    }
                                    if (isset($_GET['like'])) {
                                        if ($_GET['like'] != null) {
                                            echo 'show';
                                        }
                                    } ?>"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                <form>
                                                    <div class="row" id="id_where">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-2 mb-2">
                                                                    <input type="text" name="kode" id="kode"
                                                                        value="{{ isset($_GET['kode']) ? $_GET['kode'] : null }}"
                                                                        class="form-control" placeholder="Kode">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="peminjam" id="peminjam"
                                                                        value="{{ isset($_GET['peminjam']) ? $_GET['peminjam'] : null }}"
                                                                        class="form-control" placeholder="Peminjam">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <input type="text" name="kelas" id="kelas"
                                                                        value="{{ isset($_GET['kelas']) ? $_GET['kelas'] : null }}"
                                                                        class="form-control" placeholder="Kelas">
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                        data-date-autoclose="true" data-provide="datepicker"
                                                                        data-date-container='#datepicker6'>
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_start" id="tgl_start"
                                                                            value="{{ isset($_GET['tgl_start']) ? $_GET['tgl_start'] : null }}"
                                                                            placeholder="Tanggal " />
                                                                        <input type="text" class="form-control"
                                                                            name="tgl_end" id="tgl_end"
                                                                            value="{{ isset($_GET['tgl_end']) ? $_GET['tgl_end'] : null }}"
                                                                            placeholder="Pinjam" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <div class="input-daterange input-group">
                                                                        <input type="text" name="jml_start"
                                                                            id="jml_start"
                                                                            value="{{ isset($_GET['jml_start']) ? $_GET['jml_start'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                        <input type="text" name="jml_end" id="jml_end"
                                                                            onkeyup="rangeJml()"
                                                                            value="{{ isset($_GET['jml_end']) ? $_GET['jml_end'] : null }}"
                                                                            class="form-control number-only rangeJml"
                                                                            placeholder="Jumlah">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 mb-2">
                                                                    <select class="form-control select select2 type"
                                                                        style="width: 100%" name="type" id="type">
                                                                        <option value="">--Pilih Type--</option>
                                                                        <option value="Detail"
                                                                            {{ (isset($_GET['type']) and $_GET['type'] == 'Detail') ? 'selected' : null }}>
                                                                            Detail</option>
                                                                        <option value="Summary"
                                                                            {{ (isset($_GET['type']) and $_GET['type'] == 'Summary') ? 'selected' : null }}>
                                                                            Summary</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="id_like" style="display: none">
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="search_manual" id="search_manual"
                                                                value="{{ isset($_GET['search_manual']) ? $_GET['search_manual'] : null }}"
                                                                class="form-control" placeholder="Search">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2 mb-2">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" name="like"
                                                                    type="checkbox" id="like"
                                                                    value="{{ isset($_GET['like']) ? 'search' : 'default' }}"
                                                                    {{ isset($_GET['like']) ? 'checked' : null }}
                                                                    onclick="toggleCheckbox()">
                                                                <label class="form-check-label" for="like">
                                                                    Like semua data
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-10 mb-2">
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Cari</button>
                                                            <a href="{{ route('pinjaman.index') }}"
                                                                class="btn btn-secondary w-md">Batal</a>
                                                            @if (isset($_GET['kode']) or isset($_GET['like']))
                                                                <?php
                                                                $kode = $_GET['kode'];
                                                                $peminjam = $_GET['peminjam'];
                                                                $kelas = $_GET['kelas'];
                                                                $tgl_start = $_GET['tgl_start'];
                                                                $tgl_end = $_GET['tgl_end'];
                                                                $jml_start = $_GET['jml_start'];
                                                                $jml_end = $_GET['jml_end'];
                                                                if (isset($_GET['type'])) {
                                                                    $type = $_GET['type'];
                                                                } else {
                                                                    $type = null;
                                                                }
                                                                $search_manual = $_GET['search_manual'];
                                                                if (isset($_GET['like'])) {
                                                                    $like = $_GET['like'];
                                                                } else {
                                                                    $like = null;
                                                                }
                                                                ?>
                                                                <a href="{{ route(
                                                                    'pinjaman.export_pinjaman_buku',
                                                                    'kode=' .
                                                                        $kode .
                                                                        '&peminjam=' .
                                                                        $peminjam .
                                                                        '&kelas=' .
                                                                        $kelas .
                                                                        '&tgl_start=' .
                                                                        $tgl_start .
                                                                        '&tgl_end=' .
                                                                        $tgl_end .
                                                                        '&jml_start=' .
                                                                        $jml_start .
                                                                        '&jml_end=' .
                                                                        $jml_end .
                                                                        '&type=' .
                                                                        $type .
                                                                        '&search_manual=' .
                                                                        $search_manual .
                                                                        '&like=' .
                                                                        $like .
                                                                        '',
                                                                ) }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Export</a>
                                                            @else
                                                                <a href="{{ route('pinjaman.export_pinjaman_buku') }}"
                                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                                        class="bx bx-cloud-download me-1"></i>Export</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table id="table" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Status Transaksi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $pinjam)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pinjam->kode_transaksi }}</td>
                                            <td>{{ $pinjam->users->name }}</td>
                                            <td>{{ $pinjam->tgl_permintaan }}</td>
                                            <td>{{ $pinjam->tgl_diberikan }}</td>
                                            <td>
                                                {{ $pinjam->status_transaksi }}
                                            </td>
                                            <td>
                                                <?php $id = Crypt::encryptString($pinjam->kode_transaksi); ?>
                                                <form class="delete-form"
                                                    action="{{ route('inv_pinjaman.destroy', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex gap-3">
                                                        @if (in_array('87', $session_menu))
                                                            <a href="{{ route('inv_pinjaman.show', $id) }}"
                                                                class="text-info">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array('88', $session_menu))
                                                            <a href="{{ route('inv_pinjaman.edit', $id) }}"
                                                                class="text-success">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </a>
                                                        @endif
                                                        @if (in_array('90', $session_menu))
                                                            <a href class="text-danger delete_confirm"><i
                                                                    class="mdi mdi-delete font-size-18"></i></a>
                                                        @endif
                                                        @if (in_array('88', $session_menu))
                                                            <a href="{{ route('inv_pinjaman.approve', $id) }}"
                                                                class="text-success">
                                                                <i class="mdi mdi-check-all font-size-18"></i>
                                                            </a>
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
