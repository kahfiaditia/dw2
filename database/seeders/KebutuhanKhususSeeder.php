<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KebutuhanKhususSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kebutuhan_khusus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $kebutuhan_khusus = [
            [
                'kode' => '01',
                'nama' => 'Tidak',
            ], [
                'kode' => '02',
                'nama' => 'Netra (A)',
            ], [
                'kode' => '03',
                'nama' => 'Rungu (B)',
            ], [
                'kode' => '04',
                'nama' => 'Grahita Ringan (C)',
            ], [
                'kode' => '05',
                'nama' => 'Grahita Sedang (C1)',
            ], [
                'kode' => '06',
                'nama' => 'Daksa Ringan (D)',
            ], [
                'kode' => '07',
                'nama' => 'Daksa Sedang (D1)',
            ], [
                'kode' => '08',
                'nama' => 'Laras E',
            ], [
                'kode' => '09',
                'nama' => 'Wicara (F)',
            ], [
                'kode' => '10',
                'nama' => 'Tuna ganda (G)',
            ], [
                'kode' => '11',
                'nama' => 'Hiper aktif (H)',
            ], [
                'kode' => '12',
                'nama' => 'Cerdas Istimewa (I)',
            ], [
                'kode' => '13',
                'nama' => 'Bakat Istimewa (J)',
            ], [
                'kode' => '14',
                'nama' => 'Kesulitan Belajra (K)',
            ], [
                'kode' => '15',
                'nama' => 'Narkoba (N)',
            ], [
                'kode' => '16',
                'nama' => 'Indigo (O)',
            ], [
                'kode' => '17',
                'nama' => 'Down Sindrome (P)',
            ], [
                'kode' => '18',
                'nama' => 'Autis (Q)',
            ]
        ];
        DB::table('kebutuhan_khusus')->insert($kebutuhan_khusus);
    }
}
