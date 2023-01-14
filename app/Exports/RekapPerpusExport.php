<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekapPerpusExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        // querynya
        $list = DB::table('perpus_pinjaman')
            ->select(
                'kode_transaksi',
                'peminjam',
                'jml',
                'tgl_pinjam',
                'tgl_perkiraan_kembali',
                'tgl_kembali',
                'siswa.nama_lengkap as nama_siswa',
                'karyawan.nama_lengkap as nama_karyawan',
                'judul',
                'kode_kategori',
            )
            ->Join('perpus_buku', 'perpus_buku.id', 'perpus_pinjaman.buku_id')
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->leftJoin('siswa', 'siswa.id', 'perpus_pinjaman.siswa_id')
            ->leftJoin('karyawan', 'karyawan.id', 'perpus_pinjaman.karyawan_id')
            ->whereNull('perpus_pinjaman.deleted_at')
            ->orderBy('kode_transaksi');

        $search = $this->data['search_manual'];
        if ($search != null) {
            $list->where(function ($where) use ($search) {
                $where
                    ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('buku', 'like', '%' . $search . '%')
                    ->orWhere('jml', 'like', '%' . $search . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
            });
        } else {
            $kode = $this->data['kode'];
            $nama = $this->data['nama'];
            $buku = $this->data['buku'];
            $jml = $this->data['jml'];
            $tgl_start_pinjam = $this->data['tgl_start_pinjam'];
            $tgl_end_pinjam = $this->data['tgl_end_pinjam'];
            $tgl_start_kembali = $this->data['tgl_start_kembali'];
            $tgl_end_kembali = $this->data['tgl_end_kembali'];

            if ($kode != null) {
                $list->where('kode_transaksi', '=', $kode);
            }
            if ($nama != null) {
                $list->where(function ($query) use ($nama) {
                    $query->where('siswa.nama_lengkap', 'LIKE', '%' . $nama . '%')
                        ->orwhere('karyawan.nama_lengkap', 'LIKE', '%' . $nama . '%');
                });
            }
            if ($buku != null) {
                $list->where('judul', 'LIKE', '%' . $buku . '%');
            }
            if ($jml != null) {
                $list->where('jml', '=', $jml);
            }
            if ($tgl_end_pinjam != null) {
                $list->whereBetween('tgl_pinjam', [$tgl_start_pinjam, $tgl_end_pinjam]);
            }
            if ($tgl_end_kembali != null) {
                $list->whereBetween('tgl_kembali', [$tgl_start_kembali, $tgl_end_kembali]);
            }
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Peminjam',
            'Siswa',
            'Tanggal Pinjam',
            'Estimasi Kembali',
            'Tanggal Kembali',
            'Buku',
            'Jumlah',
        ];
    }

    public function map($list): array
    {
        if ($list->peminjam == 'Siswa') {
            $nama = $list->nama_siswa;
        } else {
            $nama = $list->nama_karyawan;
        }
        return [
            $list->kode_transaksi,
            $list->peminjam,
            $nama,
            $list->tgl_pinjam,
            $list->tgl_perkiraan_kembali,
            $list->tgl_kembali,
            $list->kode_kategori . '-' . $list->judul,
            $list->jml,
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
