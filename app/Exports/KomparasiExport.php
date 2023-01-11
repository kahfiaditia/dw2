<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KomparasiExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $data = DB::table('uks_komparasi')
            ->select(
                'uks_komparasi.*',
                'obat',
                'kategori',
                'jenis_obat',
                'name',
            )
            ->leftJoin('uks_obat', 'uks_obat.id', 'uks_komparasi.id_obat')
            ->leftJoin('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->leftJoin('uks_kategori', 'uks_kategori.id', 'uks_obat.id_kategori')
            ->leftJoin('users', 'users.id', 'uks_komparasi.user_created')
            ->whereNull('uks_obat.deleted_at')
            ->where('kode_komparasi', $this->data['kode'])
            ->orderBy('kode_komparasi', 'ASC');
        return $data;
    }

    public function headings(): array
    {
        return [
            'Kode Komparasi',
            'Tanggal Kompaarasi',
            'User Input',
            'Kode Opname',
            'Kategori',
            'Obat',
            'Jumlah Opname',
            'Jumlah Sistem',
            'Adjust Stok',
            'Keterangan Adjus',
        ];
    }

    public function map($data): array
    {
        if ($data->type_adjust) {
            $ket = 'Selisih';
        } else {
            $ket = 'Sesuai';
        }

        return [
            $data->kode_komparasi,
            $data->tgl_komparasi,
            $data->name,
            $data->kode_opname,
            $data->kategori,
            $data->obat . ' - ' . $data->jenis_obat,
            number_format($data->stok_opname),
            number_format($data->stok_sistem),
            number_format($data->adjust_stok),
            $ket,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
