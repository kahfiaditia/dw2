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
                <form id="form" class="needs-validation" action="{{ route('inventaris.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label class="form-label">Ruang Penyimpanan <code>*</code></label>
                                                <select class="form-control select select2 ruang" name="ruang"
                                                    id="ruang" required>
                                                    <option value="" required>--Pilih Ruangan--</option>
                                                    @foreach ($ruangs as $ruang)
                                                        <option value="{{ $ruang->id }}">
                                                            {{ $ruang->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('ruang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 keterangan">
                                            <div class="mb-3">
                                                <label>Status <code>*</code></label>
                                                <select class="form-control select select2 status" name="keterangan"
                                                    id="keterangan" required>
                                                    <option value="">--Pilih Status--</option>
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
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <div class="mb-2">
                                                    <label>Nama Barang <code>*</code></label>
                                                    <input type="text" class="form-control" id="nama"
                                                        style="text-transform:uppercase" placeholder="Nama Barang" required>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                            </div>
                                            {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                        <div class="col-md-3 wajib">
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
                                                {!! $errors->first('pemilik', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label for="ketersediaan">Ketersediaan <code>*</code></label>
                                                <select name="ketersediaan" id="ketersediaan"
                                                    class="form-control select select2 ketersediaan" required>
                                                    <option value="">-- Ketersediaan --</option>
                                                    <option value="TERPAKAI"> TERPAKAI</option>
                                                    <option value="TIDAK TERPAKAI"> TIDAK TERPAKAI</option>
                                                    <option value="DAPAT DIPINJAM"> DAPAT DIPINJAMKAN </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('pemilik', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>Deskripsi</label>
                                                <textarea type="text" class="form-control" style="text-transform:uppercase" id="desc" placeholder="Deskripsi"
                                                    style="text-transform:uppercase" required></textarea>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('desc', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row wajib">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label>No Inventaris <code>*</code></label>
                                                <input type="text" class="form-control"
                                                    oninput="this.value = this.value.toUpperCase()" id="no_inv"
                                                    name="no_inv" placeholder="No Inventaris" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('no_inv', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 wajib">
                                            <div class="mb-3">
                                                <label>ID Barang <code>*</code></label>
                                                <input type="text" class="form-control" id="idbarang"
                                                    placeholder="ID Barang" oninput="this.value = this.value.toUpperCase()"
                                                    required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('idbarang', '<div class="invalid-validasi">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3 keterangan">
                                            <div class="mb-3">
                                                <label>Indikasi</label>
                                                <input type="text" class="form-control "
                                                    style="text-transform:uppercase" id="indikasi"
                                                    placeholder="Indikasi Kerusakan"
                                                    oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                                {!! $errors->first('indikasi', '<div class="invalid-validasi">:message</div>') !!}
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
                                                        <th class="text-center" style="width: 10%">Nama</th>
                                                        <th class="text-center" style="width: 10%">No Inventaris</th>
                                                        <th class="text-center" style="width: 10%">ID Barang</th>
                                                        <th class="text-center" style="width: 10%">Ruang</th>
                                                        <th class="text-center" style="width: 10%">Pemilik</th>
                                                        <th class="text-center" style="width: 10%">Status</th>
                                                        <th class="text-center" style="width: 10%">Ketersediaan</th>
                                                        <th class="text-center" style="width: 10%">Indikasi</th>
                                                        <th class="text-center" style="width: 10%">Deskripsi</th>
                                                        <th class="text-center" style="width: 10%">Aksi</th>
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
            var nama = document.getElementById('nama').value;
            var hasilnama = nama.toUpperCase();
            var no_inv = document.getElementById('no_inv').value;
            var hasilno_inv = no_inv.toUpperCase();
            var idbarang = document.getElementById('idbarang').value;
            var hasilidbarang = idbarang.toUpperCase();
            var ruang = document.getElementById('ruang').value;
            var pemilik = document.getElementById('pemilik').value;
            var keterangan = document.getElementById('keterangan').value;
            var indikasi = document.getElementById('indikasi').value;
            var hasilindikasi = indikasi.toUpperCase();
            var ketersediaan = document.getElementById('ketersediaan').value;
            var desc = document.getElementById('desc').value;
            var hasildesc = desc.toUpperCase();


            document.getElementById('no_inv').value = '';
            document.getElementById('idbarang').value = '';
            document.getElementById('indikasi').value = '';

            document.getElementById('no_inv').value = '';
            document.getElementById('idbarang').value = '';


            if (ruang == '' || keterangan == '' || pemilik == '' || hasilnama == '' || ketersediaan == '' ||
                hasilidbarang ==
                '' || hasilno_inv == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1500,
                })

            } else if (keterangan == 'Rusak' && indikasi == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Jika Keterangan "Rusak" \n Filed Indikasi harus diisi',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                $("#tableBarang tr:last").after(`
                        <tr>
                            <td class="text-left">${hasilnama}</td>
                            <td class="text-left">${hasilno_inv}</td>
                            <td class="text-left">${hasilidbarang}</td>
                            <td class="text-left">${ruang}</td>
                            <td class="text-left">${pemilik}</td>
                            <td class="text-left">${keterangan}</td>
                            <td class="text-left">${ketersediaan}</td>
                            <td class="text-left">${hasilindikasi}</td>
                            <td class="text-left">${hasildesc}</td>                       
                            <td>
                                <a class="btn btn-danger btn-sm delete-record" data-id="delete">Delete</a>    
                            </td>
                        </tr>
                    `)
            }
            console.log(hasilno_inv)

        }
        //fungsi hapus
        $("#tableBarang").on('click', '.delete-record', function() {
            $(this).parent().parent().remove()
        })

        function uniqueArray3(hasilno_inv) {
            function onlyUnique(value, index, self) {
                return self.indexOf(value) === index;
            }

            // usage
            var unique = hasilno_inv.filter(onlyUnique); // returns ['a', 1, 2, '1']

            return unique;
        }

        $(document).ready(function() {
            $("#save").on('click', function() {
                let databarang = []

                $("#tableBarang").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        hasilnama = tableData.eq(0).text(),
                        hasilno_inv = tableData.eq(1).text(),
                        hasilidbarang = tableData.eq(2).text(),
                        id = tableData.eq(3).text(),
                        pemilik = tableData.eq(4).text(),
                        keterangan = tableData.eq(5).text(),
                        ketersediaan = tableData.eq(6).text(),
                        hasilindikasi = tableData.eq(7).text(),
                        hasildesc = tableData.eq(8).text()

                    //ini filter data null
                    if (hasilnama != '') {
                        databarang.push({
                            hasilnama,
                            hasilno_inv,
                            hasilidbarang,
                            id,
                            pemilik,
                            keterangan,
                            ketersediaan,
                            hasilindikasi,
                            hasildesc
                        });
                        console.log(databarang)
                    } else if (Array.prototype.contains) {
                        Array.prototype.contains = function(v) {
                            for (var i = 0; i < this.length; i++) {
                                if (this[i] === v) return true;
                            }
                            return false;
                        };

                        Array.prototype.unique = function() {
                            var arr = [];
                            for (var i = 0; i < this.length; i++) {
                                if (!arr.contains(this[i])) {
                                    arr.push(this[i]);
                                }
                            }
                            return arr;
                        }

                        var cekdata = hasilno_inv;
                        var uniques = cekdata.unique();

                        console.log(uniques);

                    }
                })

                jQuery.ajax({
                    type: "POST",
                    url: '{{ route('inventaris.store') }}',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        databarang
                    },
                    success: (response) => {
                        if (response.code === 200) {

                            Swal.fire(
                                'Success',
                                'Data Inventaris Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/inventaris'
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanda * (bintang) dan Buku wajib diisi',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }
                    },
                    error: err => console.log(err)
                });

            });
        })

        $("#batal").on('click', function() {
            // hapus localStorage
            var APP_URL = {!! json_encode(url('/')) !!}
            window.location = APP_URL + '/inventaris'
        })
    </script>
@endsection
