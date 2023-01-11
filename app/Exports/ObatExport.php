<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ObatExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $data = DB::table('uks_obat')
            ->select(
                'obat',
                'kategori',
                'jenis_obat',
            )
            ->selectRaw('ifnull(stok,0) as stok')
            ->leftJoin('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->leftJoin('uks_kategori', 'uks_kategori.id', 'uks_obat.id_kategori')
            ->whereNull('uks_obat.deleted_at')
            ->orderBy('uks_obat.obat', 'ASC');
        return $data;
    }

    public function headings(): array
    {
        return [
            'Obat',
            'Kategori',
            'Jenis',
            'Stok',
        ];
    }

    public function map($data): array
    {
        if ($data->stok > 0) {
            $stok = $data->stok;
        } else {
            $stok = 0;
        }
        return [
            $data->obat,
            $data->kategori,
            $data->jenis_obat,
            number_format($data->stok),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
