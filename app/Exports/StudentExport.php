<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $students = DB::table('siswa')
            ->select(
                'siswa.id',
                'nis',
                'nisn',
                'nik',
                'nama_lengkap',
                'email',
            )
            ->selectRaw("CONCAT(IFNULL(school_level.level,''),' ',IFNULL(school_class.classes,''),' ',IFNULL(classes.jurusan,''),' ',IFNULL(classes.type,'')) as kelas")
            ->leftJoin('classes', 'classes.id', 'siswa.class_id')
            ->leftJoin('school_level', 'school_level.id', 'classes.id_school_level')
            ->leftJoin('school_class', 'school_class.id', 'classes.class_id')
            ->whereNull('siswa.deleted_at')
            ->orderBy('siswa.id', 'asc');

        $search = $this->data['search'];
        if ($search != null) {
            $replaced = str_replace(' ', '', $search);
            $students->where(function ($where) use ($search, $replaced) {
                $where
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orwhereRaw(
                        "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                        '%' . $replaced . '%'
                    );
            });
        } else {

            $nis = $this->data['nis'];
            $nisn = $this->data['nisn'];
            $nik = $this->data['nik'];
            $nama = $this->data['nama'];
            $email = $this->data['email'];
            $kelas = $this->data['kelas'];
            if ($nis != null) {
                $students->where('nis', '=', $nis);
            }
            if ($nisn != null) {
                $students->where('nisn', '=', $nisn);
            }
            if ($nik != null) {
                $students->where('nik', '=', $nik);
            }
            if ($nama != null) {
                // $students->where('nama_lengkap', '=', $nama);
                $students->Where('nama_lengkap', 'like', '%' . $nama . '%');
            }
            if ($email != null) {
                $students->where('email', '=', $email);
            }
            if ($kelas != null) {
                $kelas = str_replace(' ', '', $kelas);
                $students->whereRaw(
                    "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                    '%' . $kelas . '%'
                );
            }
        }
        return $students;
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'NIK',
            'Nama',
            'Email',
            'Kelas',
        ];
    }

    public function map($students): array
    {
        return [
            $students->nis,
            $students->nisn,
            "'" . $students->nik,
            $students->nama_lengkap,
            $students->email,
            $students->kelas,
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
