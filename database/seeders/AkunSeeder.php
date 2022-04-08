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
            ],
            [
                'name' => 'ini akun User (non admin)',
                'email' => 'karyawan@gmail.com',
                'password' => bcrypt('12345'),
                'roles' => 'Karyawan',
                'aktif' => '1',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
