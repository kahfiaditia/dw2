<!DOCTYPE html>
<html>

<head>
    <title>{{ $item->nama_lengkap . ' - ' . $item->niks }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <?php
    function hitung_umur($tanggal_lahir)
    {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime('today');
        if ($birthDate > $today) {
            exit('0 Tahun 0 Bulan 0 Hari');
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        return $y . ' Tahun ' . $m . ' Bulan ' . $d . ' Hari';
    }
    ?>
    <h1 align="center"><b><u>DHARMA WIDYA</u></b></h1>
    <div align="center">Jl. Iskandar Muda No.90 RT/RW: 001/006 Kec. Neglasari Kota. Tangerang Prov.
        Banten<br>Telp.5581917 Fax.55793862
        <div>
            <hr>
            <p align="justify">Data berikut dikeluarkan melalui aplikasi https://sekolah-dharmawidya.sch.id/ <br>
                pada tanggal {{ date('d F Y') }} Pukul: {{ date('H:i:s') }}</p>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="2">#Biodata</th>
                    </tr>
                    <tr>
                        <th width="30%">Atribut</th>
                        <th width="70%">Isian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NIKS (No Induk Sekolah)</td>
                        <td>{{ $item->niks }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $item->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>{{ $item->tempat_lahir . ', ' . date('d F Y', strtotime($item->tgl_lahir)) }}
                            ({{ hitung_umur($item->tgl_lahir) }})</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $item->user->email }}</td>
                    </tr>
                    <tr>
                        <td>No Kontak dan Whatsapp</td>
                        <td>{{ $item->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>No KTP </td>
                        <td>{{ $item->nik }}</td>
                    </tr>
                    <tr>
                        <td>Kartu Keluarga</td>
                        <td>{{ $item->kk }}</td>
                    </tr>
                    <tr>
                        <td>NPWP</td>
                        <td>{{ $item->npwp }}</td>
                    </tr>
                    <tr>
                        <td>No BPJS Kesehatan</td>
                        <td>{{ $item->bpjs_kesehatan }}</td>
                    </tr>
                    <tr>
                        <td>No BPJS Ketenagakerjaan</td>
                        <td>{{ $item->bpjs_ketenagakerjaan }}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>{{ $item->agama->agama }}</td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td>{{ $item->golongan_darah }}</td>
                    </tr>
                    <tr>
                        <td>Nama Pasangan</td>
                        <td>{{ $item->nama_pasangan }}</td>
                    </tr>
                    <tr>
                        <td>No Kontak Pasangan</td>
                        <td>{{ $item->no_pasangan }}</td>
                    </tr>
                    <tr>
                        <td>Alamat KTP</td>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat di Tangerang</td>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>{{ $item->jabatan . ' - ' . $item->divisi }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Masuk Kerja</td>
                        <td>
                            {{ date('d F Y', strtotime($item->masuk_kerja)) }}<br>
                            ({{ hitung_umur($item->masuk_kerja) }})
                        </td>
                    </tr>
                    <tr>
                        <td>Status Aktif</td>
                        <td>{{ $item->aktif == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Resign</td>
                        <td>{{ $item->tgl_resign }}</td>
                    </tr>
                    <tr>
                        <td>Alasan Resign</td>
                        <td>{{ $item->alasan_resign }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="page-break"></div>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="4">#Ijazah dan Sertifikat</th>
                    </tr>
                </thead>
                @if (count($ijazah) > 0)
                    @foreach ($ijazah as $item)
                        <thead>
                            <tr>
                                <td colspan="4"><b>{{ $item->type . ' - ' . $item->gelar_ijazah }}</b></td>
                            </tr>
                            <tr>
                                @if ($item->type == 'Akademik')
                                    <td width="30%">Nama Sekolah/<br> Universitas
                                    </td>
                                @else
                                    <td width="30%">Nama Instansi/<br> Lembaga Penerbit
                                        Sertifikat</td>
                                @endif
                                <td width="30%">Tahun Pendidikan</td>
                                <td>Jenis</td>
                                <td>Akademik</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_ijazah = DB::table('ijazah_karyawan')
                                ->where('karyawan_id', $item->karyawan_id)
                                ->where('gelar_ijazah', $item->gelar_ijazah)
                                ->get();
                            ?>
                            @foreach ($query_ijazah as $list)
                                <tr>
                                    <td>{{ $list->type === 'Akademik' ? $list->nama_pendidikan : $list->instansi }}
                                    </td>
                                    <td>{{ $list->tahun_masuk ? $list->tahun_masuk . ' s/d ' . $list->tahun_lulus : '' }}
                                    </td>
                                    <td>{{ $list->type }}</td>
                                    <td>{{ $list->type === 'Akademik' ? $list->gelar_akademik_pendek : $list->gelar_non_akademik_pendek }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endforeach
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi Ijazah</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="4">#SK Pengangkatan</th>
                    </tr>
                </thead>
                @if (count($sk) > 0)
                    <thead>
                        <tr>
                            <td width="30%">No SK</th>
                            <td width="30%">Tanggal SK</td>
                            <td colspan="2">Jabatan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sk as $list)
                            <tr>
                                <td>{{ $list->no_sk }}</td>
                                <td>{{ date('d F Y', strtotime($list->tgl_sk)) }}</td>
                                <td colspan="2">{{ $list->jabatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi SK Pengangkatan</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="4">#Jumlah Anak</th>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Anak Karyawan</b></td>
                    </tr>
                </thead>
                @if (count($child) > 0)
                    <thead>
                        <tr>
                            <td width="30%">Anak Ke</th>
                            <td width="30%">Nama</th>
                            <td colspan="2">Usia</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($child as $list)
                            <tr>
                                <td>{{ $list->anak_ke }}</td>
                                <td>{{ $list->nama }}</td>
                                <td colspan="2">{{ $list->usia }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi Anak Karyawan</td>
                        </tr>
                    </tbody>
                @endif
                <thead>
                    <tr>
                        <td colspan="4"><b>Anak Karyawan Sekolah di Dharmawidya</b></td>
                    </tr>
                </thead>
                @if (count($school) > 0)
                    <thead>
                        <tr>
                            <td width="30%">Nama</td>
                            <td colspan="3">Jenjang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($school as $list)
                            <tr>
                                <td>{{ $list->anak_karyawans->nama }}</td>
                                <td colspan="3">{{ $list->jenjang }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi Anak Karyawan Sekolah di Dharmawidya</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            @if (count($ijazah) > 0 and count($sk) > 0 and count($child) > 0 and count($school) > 0)
                <div class="page-break"></div>
            @else
                <br>
            @endif
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="4">#Riwayat Penyakit dan Kontak</th>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Riwayat Penyakit</b></td>
                    </tr>
                </thead>
                @if (count($riwayat) > 0)
                    <thead>
                        <tr>
                            <td width="30%">Penyakit</th>
                            <td colspan="3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $list)
                            <tr>
                                <td>{{ $list->penyakit }}</td>
                                <td colspan="3">{{ $list->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi Riwayat Penyakit</td>
                        </tr>
                    </tbody>
                @endif

                <thead>
                    <tr>
                        <td colspan="4"><b>Kontak</b></td>
                    </tr>
                </thead>
                @if (count($kontak) > 0)
                    <thead>
                        <tr>
                            <td width="30%">Nama</td>
                            <td>No HP</th>
                            <td>Keterangan</th>
                            <td>Tipe</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontak as $list)
                            <tr>
                                <td>{{ $list->nama }}</td>
                                <td>{{ $list->no_hp }} </td>
                                <td>{{ $list->keterangan }}</td>
                                <td>{{ $list->tipe }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Belum isi Kontak</td>
                        </tr>
                    </tbody>
                @endif
            </table>
</body>

</html>
