<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class KomparasiExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;

        // querynya
        $list = DB::table('uks_komparasi')
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
        $this->list = $list;
    }

    public function query()
    {
        return $this->list;
    }

    public function headings(): array
    {
        return [
            ['Kode Komparasi'],
            ['Tanggal Kompaarasi'],
            ['User Input'],
            [''],
            [
                'Kode Opname',
                'Kategori',
                'Obat',
                'Jumlah Opname',
                'Jumlah Sistem',
                'Adjust Stok',
                'Keterangan Adjust',
            ]
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

    public function registerEvents(): array
    {
        $data = $this->list->get();
        $kode_komparasi = $data[0]->kode_komparasi;
        $tgl_komparasi = $data[0]->tgl_komparasi;
        $name = $data[0]->name;

        $cellHeader      = 'A5:J5';
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellHeader, $kode_komparasi, $tgl_komparasi, $name) {
                $event->sheet->getDelegate()->getStyle('A1:A3')
                    ->getFont()
                    ->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellHeader)
                    ->getFont()
                    ->setBold(true);
                $event->sheet->setCellValue('B1', $kode_komparasi);
                $event->sheet->setCellValue('B2', $tgl_komparasi);
                $event->sheet->setCellValue('B3', $name);
            },
        ];
    }
}
