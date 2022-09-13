<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\Siswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithStartRow, WithCustomCsvSettings, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '1' => 'required|unique:siswa,email',
            '2' => 'required|unique:siswa,nik|min:16',
            '3' => 'required|unique:siswa,nisn|min:10',
            '4' => 'required',
            // '5' => 'required',
            // '6' => 'required',
            // '7' => 'required',
            // '8' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.unique' => 'Email sudah terdaftar',
            '2.unique' => 'nik sudah terdaftar',
            '3.unique' => 'nisn sudah terdaftar',
            '4.required' => 'kelas wajib diisi',
            // '5.required' => 'formulir wajib diisi',
            // '6.required' => 'uang pangkal wajib diisi',
            // '7.required' => 'spp wajib diisi',
            // '8.required' => 'kegiatan wajib diisi',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function model(array $row)
    {
        // get class excel
        $clas = Classes::findorfail($row[5]);

        // buat akun
        $user = new User();
        $user->name = strtoupper($row[0]);
        $user->email = strtolower($row[1]);
        $user->password = bcrypt($row[3]);
        $user->email_verified_at = now();
        $user->id_school_level = $clas->id_school_level;
        $user->roles = 'Siswa';
        $user->akses_menu = '1,6';
        $user->akses_submenu = '1,19,20,21';
        $user->aktif = 1;
        $user->save();
        $user_id = $user->id;

        // import siswa
        return new Siswa([
            'nama_lengkap' => strtoupper($row[0]),
            'email' => strtolower($row[1]),
            'nik' => $row[2],
            'nisn' => $row[3],
            'nis' => $row[4],
            'class_id' => $row[5],
            'formulir_id' => $row[6],
            'pangkal_id' => $row[7],
            'spp_id' => $row[8],
            'kegiatan_id' => $row[9],
            'user_id' => $user_id
        ]);
    }
}
