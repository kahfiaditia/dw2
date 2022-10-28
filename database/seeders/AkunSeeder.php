<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $user = [
            [
                'name' => 'ini akun Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Admin',
                'aktif' => '1',
                'email_verified_at' => Carbon::now(),
                'akses_menu' => '1,2,3,4,5,6,7,8,9,10,11',
                'akses_submenu' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26',
            ],
            [
                'name' => 'ini akun Administrator',
                'email' => 'administrator@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Administrator',
                'aktif' => '1',
                'email_verified_at' => Carbon::now(),
                'akses_menu' => '1,2,3,6,10,13,14,15,16',
                'akses_submenu' => '1,6,2,3,4,5,7,8,9,10,56,19,20,21,22,35,36,37,38,45,46,47,11,12,13,14,43,44,23,24,25,26,31,32,33,34,15,16,17,18,48,49,50,51,39,40,41,42,52,53,54,55,27,28,29,30,57,70,71,72,73,58,59,60,61,66,67,68,69,74,75,76,77,78,79,62,63,64,65',
            ],
            [
                'name' => 'ini akun Karyawan',
                'email' => 'karyawan@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Karyawan',
                'aktif' => '1',
                'email_verified_at' => Carbon::now(),
                'akses_menu' => '1,2',
                'akses_submenu' => '1,2,3,4,6',
            ],
            [
                'name' => 'ini akun Siswa',
                'email' => 'siswa@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Siswa',
                'aktif' => '1',
                'email_verified_at' => Carbon::now(),
                'akses_menu' => '1,6',
                'akses_submenu' => '1,19,20,21',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
