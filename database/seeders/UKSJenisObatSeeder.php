<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UKSJenisObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('uks_jenis_obat')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $agama = [
            [
                'jenis_obat' => 'Obat Cair',
            ], [
                'jenis_obat' => 'Tablet',
            ], [
                'jenis_obat' => 'Kapsul',
            ], [
                'jenis_obat' => 'Obat Oles',
            ], [
                'jenis_obat' => 'Suppositoria',
            ], [
                'jenis_obat' => 'Obat Tetes',
            ], [
                'jenis_obat' => 'Inhaler',
            ], [
                'jenis_obat' => 'Obat Suntik',
            ], [
                'jenis_obat' => 'Implan atau Obat Tempel',
            ]
        ];
        DB::table('uks_jenis_obat')->insert($agama);
    }
}
