<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('agama')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $agama = [
            [
                'agama' => 'Islam',
                'aktif' => '1',
            ], [
                'agama' => 'Protestan',
                'aktif' => '1',
            ], [
                'agama' => 'Katolik',
                'aktif' => '1',
            ], [
                'agama' => 'Hindu',
                'aktif' => '1',
            ], [
                'agama' => 'Buddha',
                'aktif' => '1',
            ], [
                'agama' => 'Khonghucu',
                'aktif' => '1',
            ]
        ];
        DB::table('agama')->insert($agama);
    }
}
