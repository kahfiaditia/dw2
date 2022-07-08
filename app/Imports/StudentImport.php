<?php

namespace App\Imports;

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
            '2' => 'required|unique:siswa,nik',
            '3' => 'required|unique:siswa,nisn'
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.unique' => 'Email sudah terdaftar',
            '2.unique' => 'nik sudah terdaftar',
            '3.unique' => 'nisn sudah terdaftar'
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
        $user = new User();
        $user->name = $row[0];
        $user->email = $row[1];
        $user->password = \Hash::make($row[2]);
        $user->roles = 'Siswa';
        $user->aktif = 1;
        $user->save();
        $user_id = $user->id;

        return new Siswa([
            'nama_lengkap' => $row[0],
            'email' => $row[1],
            'nik' => $row[2],
            'nisn' => $row[3],
            'class_id' => $row[4],
            'user_id' => $user_id
        ]);
    }
}
