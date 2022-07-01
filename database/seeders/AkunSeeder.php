<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'ini akun Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Admin',
                'aktif' => '1',
                'akses_menu' => '1,2,3,4,5,6,7,8,9,10,11',
                'akses_submenu' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42',
            ],
            [
                'name' => 'ini akun Karyawan',
                'email' => 'karyawan@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Karyawan',
                'aktif' => '1',
                'akses_menu' => '1,2',
                'akses_submenu' => '1,2,3,4,6',
            ],
            [
                'name' => 'ini akun Siswa',
                'email' => 'siswa@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Siswa',
                'aktif' => '1',
                'akses_menu' => '1,6',
                'akses_submenu' => '1,19,20,21',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
