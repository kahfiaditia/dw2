<!DOCTYPE html>
<html>

<head>
    <title>{{ $siswa->nama_lengkap . ' - ' . $siswa->nis }}</title>
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
                        <th width="50%">Atribut</th>
                        <th width="50%">Isian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NIS (No Induk Sekolah)</td>
                        <td>{{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>{{ $siswa->nik }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $siswa->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>
                            @if ($siswa->classes_student)
                                @if ($siswa->classes_student->school_class)
                                    <?php $class = $siswa->classes_student->school_class->classes; ?>
                                @else
                                    <?php $class = ''; ?>
                                @endif
                                {{ $siswa->classes_student->school_level->level . ' ' . $class . ' ' . $siswa->classes_student->jurusan . '.' . $siswa->classes_student->type }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $siswa->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>
                            @if ($siswa->tempat_lahir)
                                {{ $siswa->tempat_lahir . ', ' }}
                            @endif
                            @if ($siswa->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}<br>
                                ({{ hitung_umur($siswa->tanggal_lahir) }})
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>{{ $siswa->religion ? $siswa->religion->agama : '' }}</td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td>{{ $siswa->golongan_darah }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Akta Lahir </td>
                        <td>{{ $siswa->no_registrasi_akta_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Kartu Keluarga</td>
                        <td>{{ $siswa->no_kk }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $siswa->email }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Handphone</td>
                        <td>{{ $siswa->no_handphone }}</td>
                    </tr>
                    <tr>
                        <td>Kewarganegaraan</td>
                        <td>{{ $siswa->kewarganegaraan }}</td>
                    </tr>
                    <tr>
                        <td>Nama Negara</td>
                        <td>{{ $siswa->nama_negara }}</td>
                    </tr>
                    <tr>
                        <td>Berkebutuhan Khusus</td>
                        <td>{{ $siswa->special_need ? $siswa->special_need->kode . ') ' . $siswa->special_need->nama : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat Tinggal</td>
                        <td>{{ $siswa->tempat_tinggal }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Jalan</td>
                        <td>{{ $siswa->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Dusun</td>
                        <td>{{ $siswa->dusun }}</td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td>{{ $siswa->village }}</td>
                    </tr>
                    <tr>
                        <td>Kelurahan</td>
                        <td>{{ $siswa->district }}</td>
                    </tr>
                    <tr>
                        <td>RT/RW </td>
                        <td>{{ $siswa->rt }}{{ $siswa->rw ? '/' . $siswa->rw : '' }}</td>
                    </tr>
                    <tr>
                        <td>Kode Pos</td>
                        <td>{{ $siswa->postal_code }}</td>
                    </tr>
                    <tr>
                        <td>Moda Transportasi</td>
                        <td>{{ $siswa->transportation }}</td>
                    </tr>
                    <tr>
                        <td>Anak Keberapa</td>
                        <td>{{ $siswa->child_order }}</td>
                    </tr>
                    <tr>
                        <td>Sudah Punya KIP </td>
                        <td>{{ $siswa->is_have_kip }}</td>
                    </tr>
                    <tr>
                        <td>Tetap Menerima KIP</td>
                        <td>{{ $siswa->is_receive_kip }}</td>
                    </tr>
                    <tr>
                        <td>Alasan Menolak KIP</td>
                        <td>{{ $siswa->reason_reject_kip }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="8">#Orang Tuan atau Wali</th>
                    </tr>
                </thead>
                @if (count($ortu) > 0)
                    <thead>
                        <tr>
                            <td>Type</th>
                            <td>NIK</td>
                            <td>Nama</td>
                            <td width="15%">Tanggal Lahir</td>
                            <td>Pendidikan</td>
                            <td>Pekerjaan</td>
                            <td>Penghasilan</td>
                            <td width="15%">Berkebutuhan Khusus</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ortu as $list)
                            <tr>
                                <td>{{ $list->type }}</td>
                                <td>{{ $list->nik }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($list->tanggal_lahir)->format('d M Y') }}</td>
                                <td>{{ $list->pendidikan }}</td>
                                <td>{{ $list->pekerjaan }}</td>
                                <td>{{ $list->penghasilan }}</td>
                                <td>{{ $list->special_need->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="8">Belum isi Orang Tuan atau Wali</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="7">#Priodik</th>
                    </tr>
                </thead>
                @if ($siswa->periodic_student)
                    <thead>
                        <tr>
                            <td width="10%">Tinggi Badan</th>
                            <td width="15%">Berat Badan</td>
                            <td width="15%">Lingkar Kepala</td>
                            <td width="20%">Jarak tempat tinggal ke sekolah</td>
                            <td width="10%">Sebutkan (KM)</td>
                            <td width="17%">Waktu tempuh ke sekolah</td>
                            <td>Jumlah saudara kandung </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                {{ $siswa->periodic_student->tinggi_badan . ' Cm' }}</td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->berat_badan . ' Kg' }}</td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->lingkar_kepala . ' Cm' }}</td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->jarak_tempat_tinggal_ke_sekolah }}</td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->in_km . ' Km' }}</td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->waktu_tempuh_jam . ' Jam ' . $siswa->periodic_student->waktu_tempuh_menit . ' Menit' }}
                            </td>
                            <td class="text-center">
                                {{ $siswa->periodic_student->jumlah_saudara_kandung }}</td>
                        </tr>
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="7">Belum isi Priodik</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            @if (count($ortu) > 0 and $siswa->periodic_student)
                <div class="page-break"></div>
            @else
                <br>
            @endif
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="7">#Prestasi</th>
                    </tr>
                </thead>
                @if (count($siswa->performances) > 0)
                    <thead>
                        <tr>
                            <td width="10%">Jenis Beasiswa</th>
                            <td width="15%">Tingkat</td>
                            <td width="15%">Nama Prestasi</td>
                            <td width="30%">Tahun Prestasi</td>
                            <td width="17%">Penyelenggara</td>
                            <td colspan="2">Peringkat </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa->performances as $performance)
                            <tr>
                                <td class="text-center">
                                    {{ $performance->jenis_prestasi }}</td>
                                <td class="text-center">
                                    {{ $performance->tingkat_prestasi }}</td>
                                <td class="text-center">
                                    {{ $performance->nama_prestasi }}</td>
                                <td class="text-center">
                                    {{ $performance->tahun_prestasi }}</td>
                                <td class="text-center">
                                    {{ $performance->penyelenggara }}</td>
                                <td class="text-center" colspan="2">
                                    {{ $performance->peringkat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="7">Belum isi Prestasi</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="7">#Beasiswa</th>
                    </tr>
                </thead>
                @if (count($siswa->beasiswa) > 0)
                    <thead>
                        <tr>
                            <td width="15%">Jenis Beasiswa</th>
                            <td width="25%">Keterangan</td>
                            <td width="30%">Tahun Mulai</td>
                            <td colspan="4">Tahun Selesai </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa->beasiswa as $scholarship)
                            <tr>
                                <td class="text-center">
                                    {{ $scholarship->jenis_beasiswa }}</td>
                                <td class="text-center">
                                    {{ $scholarship->keterangan }}</td>
                                <td class="text-center">
                                    {{ $scholarship->tahun_mulai }}</td>
                                <td class="text-center" colspan="4">
                                    {{ $scholarship->tahun_selesai }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="7">Belum isi Beasiswa</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <br>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th colspan="7">#Kesejahteraan Siswa</th>
                    </tr>
                </thead>
                @if (count($siswa->beasiswa) > 0)
                    <thead>
                        <tr>
                            <td width="20%">Jenis Kesejahteraan</th>
                            <td width="20%">Nomor Kartu</td>
                            <td colspan="5">Nama Di Kartu </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa->kesejahteraan as $item)
                            <tr>
                                <td class="text-center">
                                    {{ $item->jenis_kesejahteraan }}</td>
                                <td class="text-center">
                                    {{ $item->nomor_kartu }}</td>
                                <td class="text-center" colspan="5">
                                    {{ $item->nama_kartu }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="7">Belum isi Kesejahteraan Siswa</td>
                        </tr>
                    </tbody>
                @endif
            </table>
</body>

</html>
