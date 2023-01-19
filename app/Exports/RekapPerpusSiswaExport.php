<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RekapPerpusSiswaExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;

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
                'siswa.barcode as barcode_siswa',
                'siswa.nis as nis_siswa',
                'karyawan.niks as niks_karyawan',
            )
            ->selectRaw("CONCAT(IFNULL(school_level.level,''),' ',IFNULL(school_class.classes,''),' ',IFNULL(classes.jurusan,''),' ',IFNULL(classes.type,'')) as kelas")
            ->Join('perpus_buku', 'perpus_buku.id', 'perpus_pinjaman.buku_id')
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->leftJoin('siswa', 'siswa.id', 'perpus_pinjaman.siswa_id')
            ->leftJoin('classes', 'classes.id', 'siswa.class_id')
            ->leftJoin('school_level', 'school_level.id', 'classes.id_school_level')
            ->leftJoin('school_class', 'school_class.id', 'classes.class_id')
            ->leftJoin('karyawan', 'karyawan.id', 'perpus_pinjaman.karyawan_id')
            ->whereNull('perpus_pinjaman.deleted_at')
            ->orderBy('kode_transaksi');


        $kode = Crypt::decryptString($this->data['kode']);
        $peminjam = $this->data['peminjam'];
        if ($peminjam == 'Siswa') {
            if ($kode != null) {
                $siswa = Siswa::where('barcode', $kode)->first();
                $list->where('perpus_pinjaman.siswa_id', '=', $siswa->id);
            }
        } elseif ($peminjam == 'Karyawan' or $peminjam == 'Guru') {
            if ($kode != null) {
                $karyawan = Employee::where('niks', $kode)->first();
                $list->where('perpus_pinjaman.karyawan_id', '=', $karyawan->id);
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
                'Kode Transaksi',
                'Peminjam',
                'Tanggal Pinjam',
                'Estimasi Kembali',
                'Tanggal Kembali',
                'Buku',
                'Jumlah',
            ]
        ];
    }

    public function map($list): array
    {
        return [
            $list->kode_transaksi,
            $list->peminjam,
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
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        $data = $this->list->get();
        if ($this->data['peminjam'] == 'Siswa') {
            $barcode = $data[0]->barcode_siswa;
            $nama = $data[0]->nama_siswa;
            $nis = $data[0]->nis_siswa;
            $kelas = $data[0]->kelas;
        } else {
            $barcode = $data[0]->niks_karyawan;
            $nama = $data[0]->nama_karyawan;
            $nis = $data[0]->niks_karyawan;
            $kelas = '';
        }
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
