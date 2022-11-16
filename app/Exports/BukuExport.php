<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BukuExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        // querynya
        $buku = DB::table('perpus_buku')
            ->select(
                'perpus_buku.*',
                'kategori',
                'nama_penerbit',
                'rak',
            )
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->Join('perpus_penerbit', 'perpus_penerbit.id', 'perpus_buku.penerbit_id')
            ->leftJoin('perpus_rak', 'perpus_rak.id', 'perpus_buku.rak_id')
            ->whereNull('perpus_buku.deleted_at')
            ->orderBy('perpus_buku.id', 'DESC');

        $search = $this->data['search_manual'];
        if ($search != null) {
            $buku->where(function ($where) use ($search) {
                $where
                    ->orWhere('kode_buku', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('nama_penerbit', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('rak', 'like', '%' . $search . '%')
                    ->orWhere('jml_buku', 'like', '%' . $search . '%')
                    ->orWhere('stock_master', 'like', '%' . $search . '%');
            });
        } else {
            $kode = $this->data['kode'];
            $judul = $this->data['judul'];
            $pengarang = $this->data['pengarang'];
            $penerbit = $this->data['penerbit'];
            $kategori = $this->data['kategori'];
            $jml_start = $this->data['jml_start'];
            $jml_end = $this->data['jml_end'];
            $stock_start = $this->data['stock_start'];
            $stock_end = $this->data['stock_end'];
            $rak = $this->data['rak'];

            if ($kode != null) {
                $buku->where('kode_buku', '=', $kode);
            }
            if ($judul != null) {
                $buku->where('judul', '=', $judul);
            }
            if ($pengarang != null) {
                $buku->where('pengarang', '=', $pengarang);
            }
            if ($penerbit != null) {
                $buku->where('nama_penerbit', '=', $penerbit);
            }
            if ($kategori != null) {
                $buku->where('kategori', '=', $kategori);
            }
            if ($rak != null) {
                $buku->where('rak', '=', $rak);
            }
            if ($jml_end != null) {
                $buku->whereRaw('jml_buku BETWEEN ' . $jml_start . ' AND ' . $jml_end . '');
            }
            if ($stock_end != null) {
                $buku->whereRaw('stock_master BETWEEN ' . $stock_start . ' AND ' . $stock_end . '');
            }
        }
        return $buku;
    }

    public function headings(): array
    {
        return [
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Penerbit',
            'Kategori',
            'Rak',
            'Jumlah Tersedia',
            'Jumlah Stock',
        ];
    }

    public function map($list): array
    {
        return [
            $list->kode_buku,
            $list->judul,
            $list->pengarang,
            $list->nama_penerbit,
            $list->kategori,
            $list->rak,
            $list->jml_buku,
            $list->stock_master,
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
