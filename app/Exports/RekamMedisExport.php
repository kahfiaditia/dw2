<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekamMedisExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        // querynya
        $list = DB::table('uks_perawatan')
            ->select(
                'uks_perawatan.kode_perawatan',
                'uks_perawatan.tgl',
                'uks_perawatan.gejala',
                'uks_perawatan.masuk',
                'uks_perawatan.keluar',
                'siswa.nama_lengkap',
                'kategori',
                'uks_obat.obat',
                'jenis_obat',
                'uks_perawatan.qty',
            )
            ->Join('siswa', 'siswa.id', 'uks_perawatan.id_siswa')
            ->Join('uks_obat', 'uks_obat.id', 'uks_perawatan.id_obat')
            ->Join('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->Join('uks_kategori', 'uks_kategori.id', 'uks_obat.id_kategori')
            ->whereNull('uks_perawatan.deleted_at')
            ->orderBy('kode_perawatan');

        $search = $this->data['search_manual'];
        if ($search != null) {
            $list->where(function ($where) use ($search) {
                $where
                    ->orWhere('uks_perawatan.kode_perawatan', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('gejala', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('obat', 'like', '%' . $search . '%')
                    ->orWhere('qty', 'like', '%' . $search . '%')
                    ->orWhere('uks_perawatan.tgl', 'like', '%' . $search . '%');
            });
        } else {
            $kode = $this->data['kode'];
            $siswa = $this->data['siswa'];
            $gejala = $this->data['gejala'];
            $kategori = $this->data['kategori'];
            $obat = $this->data['obat'];
            $qty = $this->data['qty'];
            $tgl_start = $this->data['tgl_start'];
            $tgl_end = $this->data['tgl_end'];

            if ($kode != null) {
                $list->where('uks_perawatan.kode_perawatan', '=', $kode);
            }
            if ($siswa != null) {
                $list->where('siswa.nama_lengkap', 'LIKE', '%' . $siswa . '%');
            }
            if ($gejala != null) {
                $list->where('uks_perawatan.gejala', 'LIKE', '%' . $gejala . '%');
            }
            if ($kategori != null) {
                $list->where('kategori', '=', $kategori);
            }
            if ($obat != null) {
                $list->where('uks_obat.obat', '=', $obat);
            }
            if ($qty != null) {
                $list->where('uks_perawatan.qty', '=', $qty);
            }
            if ($tgl_end != null) {
                $list->whereBetween('uks_perawatan.tgl', [$tgl_start, $tgl_end]);
            }
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'Kode Perawatan',
            'Siswa',
            'Gejala',
            'Kategori',
            'Obat',
            'Jumlah',
            'Tanggal',
            'Masuk',
            'Keluar',
        ];
    }

    public function map($list): array
    {
        return [
            $list->kode_perawatan,
            $list->tgl,
            $list->gejala,
            $list->kategori,
            $list->obat,
            $list->qty,
            $list->tgl,
            $list->masuk,
            $list->keluar,
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
