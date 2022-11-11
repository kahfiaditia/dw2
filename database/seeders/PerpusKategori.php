<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerpusKategori extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('perpus_kategori_buku')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $perpus_kategori = [
            [
                'kode_kategori' => 'UM',
                'kategori' => 'UMUM',
            ], [
                'kode_kategori' => 'AG',
                'kategori' => 'AGAMA',
            ], [
                'kode_kategori' => 'NV',
                'kategori' => 'NOVEL',
            ], [
                'kode_kategori' => 'FP',
                'kategori' => 'FILSAFAT & PSIKOLOGI ',
            ], [
                'kode_kategori' => 'BS',
                'kategori' => 'BAHASA',
            ], [
                'kode_kategori' => 'CK',
                'kategori' => 'BUKU CERITA & KOMIK',
            ], [
                'kode_kategori' => 'SM',
                'kategori' => 'SAINS & MTK',
            ], [
                'kode_kategori' => 'SO',
                'kategori' => 'SOSIAL',
            ], [
                'kode_kategori' => 'SG',
                'kategori' => 'SEJARAH & GEOGRAFI',
            ], [
                'kode_kategori' => 'TE',
                'kategori' => 'TEKNOLOGI',
            ], [
                'kode_kategori' => 'SR',
                'kategori' => 'SENI & REKREASI',
            ], [
                'kode_kategori' => 'SD',
                'kategori' => 'SD',
            ], [
                'kode_kategori' => 'SMP',
                'kategori' => 'SMP',
            ], [
                'kode_kategori' => 'SMK',
                'kategori' => 'SMK',
            ]
        ];
        DB::table('perpus_kategori_buku')->insert($perpus_kategori);
    }
}
