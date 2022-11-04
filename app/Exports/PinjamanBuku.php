<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PinjamanBuku implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $pin = DB::table('perpus_pinjaman')
            ->select(
                'perpus_pinjaman.id',
                'kode_transaksi',
                'peminjam',
                'siswa.nama_lengkap as siswa',
                'karyawan.nama_lengkap as karyawan',
                'tgl_pinjam',
                'tgl_perkiraan_kembali',
                'tgl_kembali',
                'judul',
            )
            ->selectRaw('SUM(jml) as jml')
            ->selectRaw("CONCAT(IFNULL(school_level.level,''),' ',IFNULL(school_class.classes,''),' ',IFNULL(classes.jurusan,''),' ',IFNULL(classes.type,'')) as kelas")
            ->leftJoin('siswa', 'siswa.id', 'perpus_pinjaman.siswa_id')
            ->leftJoin('karyawan', 'karyawan.id', 'perpus_pinjaman.karyawan_id')
            ->leftJoin('classes', 'classes.id', 'siswa.class_id')
            ->leftJoin('school_level', 'school_level.id', 'classes.id_school_level')
            ->leftJoin('school_class', 'school_class.id', 'classes.class_id')
            ->leftJoin('perpus_buku', 'perpus_buku.id', 'perpus_pinjaman.buku_id')
            ->whereNull('perpus_pinjaman.deleted_at')
            ->orderBy('perpus_pinjaman.id', 'DESC');

        $search = $this->data['search_manual'];
        if ($search != null) {
            $replaced = str_replace(' ', '', $search);
            $pin->where(function ($where) use ($search, $replaced) {
                $where
                    ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('peminjam', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                    ->orwhereRaw(
                        "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                        '%' . $replaced . '%'
                    )
                    ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
            });
            $pin->groupBy('kode_transaksi');
        } else {
            $kode = $this->data['kode'];
            $peminjam = $this->data['peminjam'];
            $kelas = $this->data['kelas'];
            $tgl_start = $this->data['tgl_start'];
            $tgl_end = $this->data['tgl_end'];
            $jml_start = $this->data['jml_start'];
            $jml_end = $this->data['jml_end'];
            $type = $this->data['type'];

            if ($kode != null) {
                $pin->where('kode_transaksi', '=', $kode);
            }
            if ($peminjam != null) {
                $pin->where('siswa.nama_lengkap', '=', $peminjam)
                    ->orwhere('karyawan.nama_lengkap', '=', $peminjam);
            }
            if ($kelas != null) {
                $kelas = str_replace(' ', '', $kelas);
                $pin->whereRaw(
                    "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                    '%' . $kelas . '%'
                );
            }
            if ($tgl_end != null) {
                $pin->whereBetween('tgl_pinjam', [$tgl_start, $tgl_end]);
            }
            if ($jml_end != null) {
                $pin->havingRaw("SUM(jml) >= '$jml_start' and SUM(jml) <= '$jml_end'");
            }
            if ($type != null) {
                if ($type == 'Summary') {
                    $pin->groupBy('kode_transaksi');
                }
                if ($type == 'Detail') {
                    $pin->groupBy('perpus_pinjaman.id');
                }
            } else {
                $pin->groupBy('kode_transaksi');
            }
        }
        return $pin;
    }

    public function headings(): array
    {
        if ($this->data['type'] == 'Detail') {
            return [
                'Kode Transaksi',
                'Peminjam',
                'Buku',
                'Tgl Pinjam',
                'Tgl Perkiraan Kembali',
                'Tgl kembali',
                'Jumlah',
            ];
        } else {
            return [
                'Kode Transaksi',
                'Peminjam',
                'Kelas',
                'Tgl Pinjam',
                'Tgl Perkiraan Kembali',
                'Tgl kembali',
                'Jumlah',
            ];
        }
    }

    public function map($pin): array
    {
        if ($pin->peminjam == 'Siswa') {
            $nama = $pin->siswa;
        } else {
            $nama = $pin->karyawan;
        }
        return [
            $pin->kode_transaksi,
            $nama,
            $pin->tgl_pinjam,
            $pin->tgl_perkiraan_kembali,
            $pin->tgl_kembali,
            $pin->jml,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
