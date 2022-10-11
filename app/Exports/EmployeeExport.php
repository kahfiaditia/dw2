<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function query()
    {
        $employee = DB::table('karyawan')
            ->select(
                'karyawan.id',
                'nama_lengkap',
                'email',
                'nik',
                'npwp',
                'no_hp',
                'jabatan',
                'karyawan.aktif',
            )
            ->Join('users', 'users.id', 'karyawan.user_id')
            ->whereNull('karyawan.deleted_at')
            ->orderBy('karyawan.id', 'asc');

        $like = $this->data['like'];
        $search = $this->data['search'];
        $nama = $this->data['nama'];
        $email = $this->data['email'];
        $nik = $this->data['nik'];
        $npwp = $this->data['npwp'];
        $kontak = $this->data['kontak'];
        $jabatan = $this->data['jabatan'];
        $stat = $this->data['stat'];

        if ($search != null) {
            $employee->where(function ($where) use ($search) {
                if ($search) {
                    if (strtolower($search) == 'aktif') {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                }
                $where
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('npwp', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('karyawan.aktif', '=', $status);
            });
        } else {
            if ($nama != null) {
                $employee->where('nama_lengkap', '=', $nama);
            }
            if ($email != null) {
                $employee->where('email', '=', $email);
            }
            if ($nik != null) {
                $employee->where('nik', '=', $nik);
            }
            if ($npwp != null) {
                $employee->where('npwp', '=', $npwp);
            }
            if ($kontak != null) {
                $employee->where('no_hp', '=', $kontak);
            }
            if ($jabatan != null) {
                $employee->where('jabatan', '=', $jabatan);
            }
            if ($stat != null) {
                if (strtolower($stat) == 'aktif') {
                    $stat = 1;
                } else {
                    $stat = 0;
                }
                $employee->where('karyawan.aktif', '=', $stat);
            }
        }
        return $employee;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'NIK',
            'NPWP',
            'Kontak',
            'Jabatan',
            'Status',
        ];
    }

    public function map($employee): array
    {
        if ($employee->aktif == 1) {
            $status = 'Aktif';
        } else {
            $status = 'Non Aktif';
        }
        return [
            $employee->nama_lengkap,
            $employee->email,
            "'" . $employee->nik,
            $employee->npwp,
            $employee->no_hp,
            $employee->jabatan,
            $status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
