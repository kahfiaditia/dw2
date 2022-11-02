<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventaris = [
            [
                'nama' => 'CPU',
                'nomor_inventaris' => 'A07/003/SD/III/15',
                'idbarang' => 'YPDW/PC/METTA/29',
                'ruangan' => 'LAB METTA',
                'qty' => '1',
                'status' => 'Baik',
                'indikasi' => '',
                'pemilik' => 'Yayasan',
                'desc' => 'CPU Speknya blm tau',
                'user_created' => '2',
            ],
        ];
        DB::table('inventaris')->insert($inventaris);
    }
}
