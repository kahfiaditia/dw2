<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekamMedisSiswaExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;

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
                'siswa.barcode',
                'siswa.nis',
            )
            ->selectRaw("CONCAT(IFNULL(school_level.level,''),' ',IFNULL(school_class.classes,''),' ',IFNULL(classes.jurusan,''),' ',IFNULL(classes.type,'')) as kelas")
            ->Join('siswa', 'siswa.id', 'uks_perawatan.id_siswa')
            ->leftJoin('classes', 'classes.id', 'siswa.class_id')
            ->leftJoin('school_level', 'school_level.id', 'classes.id_school_level')
            ->leftJoin('school_class', 'school_class.id', 'classes.class_id')
            ->Join('uks_obat', 'uks_obat.id', 'uks_perawatan.id_obat')
            ->Join('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->Join('uks_kategori', 'uks_kategori.id', 'uks_obat.id_kategori')
            ->whereNull('uks_perawatan.deleted_at')
            ->orderBy('kode_perawatan');

        $kode = Crypt::decryptString($this->data['kode']);
        $siswa = Siswa::where('barcode', $kode)->first();
        $peminjam = $this->data['peminjam'];
        if ($peminjam == 'Siswa') {
            if ($kode != null) {
                $list->where('uks_perawatan.id_siswa', '=', $siswa->id);
            }
        }
        $this->list = $list;
    }

    public function query()
    {
        return $this->list;
    }

    public function headings(): array
    {
        return [
            ['ID Barcode'],
            ['NIS/NIKS'],
            ['Nama'],
            ['Kelas'],
            [''],
            [
                'Kode Perawatan',
                'Gejala',
                'Kategori',
                'Obat',
                'Jumlah',
                'Tanggal',
                'Masuk',
                'Keluar',
            ]
        ];
    }

    public function map($list): array
    {
        return [
            $list->kode_perawatan,
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
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        $data = $this->list->get();
        $barcode = $data[0]->barcode;
        $nama = $data[0]->nama_lengkap;
        $nis = $data[0]->nis;
        $kelas = $data[0]->kelas;
        $cellHeader = 'A6:I6';

        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellHeader, $barcode, $nama, $nis, $kelas) {
                $event->sheet->getDelegate()->getStyle('A1:A5')
                    ->getFont()
                    ->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellHeader)
                    ->getFont()
                    ->setBold(true);
                $event->sheet->setCellValue('B1', $barcode);
                $event->sheet->setCellValue('B2', $nama);
                $event->sheet->setCellValue('B3', $nis);
                $event->sheet->setCellValue('B4', $kelas);
            },
        ];
    }
}
