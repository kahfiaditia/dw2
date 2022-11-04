@extends('layouts.main')
@section('container')

    <body class="InvBarang">
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
                <form class="needs-validation" action="{{ route('inventaris.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Ruang <code>*</code></label>
                                                <select class="form-control select select2 ruang" name="ruang" required
                                                    id="ruang">
                                                    <option value="">--Pilih Ruangan--</option>
                                                    @foreach ($ruangs as $ruang)
                                                        <option value="{{ $ruang->id }}">{{ $ruang->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('ruang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>Keterangan <code>*</code></label>
                                                <select class="form-control select select2 status" name="status"
                                                    id="keterangan" required>
                                                    <option value="">--Pilih Keterangan--</option>
                                                    <option value="Baik"> BAIK</option>
                                                    <option value="Rusak"> RUSAK</option>
                                                    <option value="SPEK TIDAK LAYAK"> SPEK TDK LAYAK</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('keterangan', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="mb-2">
                                                    <label>Nama Barang <code>*</code></label>
                                                    <input type="text" class="form-control" id="nama"
                                                        placeholder="Nama Barang">
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                            </div>
                                            {!! $errors->first('tgl_pinjam', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="pemilik">Pemilik <code>*</code></label>
                                                <select name="pemilik" id="pemilik"
                                                    class="form-control select select2 pemilik" required>
                                                    <option value="">-- Pemilik --</option>
                                                    <option value="Yayasan"> YAYASAN</option>
                                                    <option value="TK"> TK</option>
                                                    <option value="SD"> SD</option>
                                                    <option value="SMP"> SMP</option>
                                                    <option value="SMK"> SMK</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>No Inventaris <code>*</code></label>
                                                <input type="text" class="form-control" style="text-transform:uppercase"
                                                    id="no_inv" placeholder="No Inventaris" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>ID Barang <code>*</code></label>
                                                <input type="text" class="form-control" style="text-transform:uppercase"
                                                    id="idbarang" placeholder="ID Barang" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-mb-2">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="tableBarang()">Tambah
                                                Barang</a>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tableBarang">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center" style="width: 10%">Ruang</th>
                                                        <th class="text-center" style="width: 10%">Keterangan</th>
                                                        <th class="text-center" style="width: 20%">Nama</th>
                                                        <th class="text-center" style="width: 20%">No Inventaris</th>
                                                        <th class="text-center" style="width: 20%">ID Barang</th>
                                                        <th class="text-center" style="width: 10%">Pemilik</th>
                                                        <th class="text-center" style="width: 10%">Action</th>
                                                        <th class="text-center" hidden>ruang_id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a class="btn btn-secondary" type="submit" id="batal">Batal</a>
                                            <a class="btn btn-primary" type="submit" style="float: right"
                                                id="save">Simpan</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </form>
                <br>
            </div>
        </div>
    </body>

    <script>
        function tableBarang() {
            var ruang = document.getElementById('ruang').value;
            console.log(ruang);
            var keterangan = document.getElementById('keterangan').value;
            console.log(keterangan);
            var nama = document.getElementById('nama').value;
            console.log(nama);
            var no_inv = document.getElementById('no_inv').value;
            console.log(no_inv);
            var idbarang = document.getElementById('idbarang').value;
            console.log(idbarang);
            var pemilik = document.getElementById('pemilik').value;
            console.log(pemilik);
            var ruang = document.getElementById("ruang");
            var text = ruang.options[ruang.selectedIndex].text;

            var button = onclick = document.getElementById('no_inv').value = '';
            onclick = document.getElementById('idbarang').value = '';

            $("#tableBarang tr:last").after(`
                        <tr>
                            <td class="text-left">${text}</td>
                            <td class="text-left" hidden>${ruang}</td>
                            <td class="text-left">${keterangan}</td>
                            <td class="text-left">${nama}</td>
                            <td class="text-left">${no_inv}</td>
                            <td class="text-left">${idbarang}</td>
                            <td class="text-left">${pemilik}</td>
                            <td>
                                <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                            </td>
                        </tr>
                    `)
        }

        //fungsi hapus
        $("#tableBarang").on('click', '.delete-record', function() {
            $(this).parent().parent().remove()
        })

        //value null setelah di klik
        $('#no_inv').val("")
    </script>
@endsection
