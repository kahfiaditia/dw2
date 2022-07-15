<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bills')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $bills = [
            [
                'bills' => 'Uang Formulir',
                'notes' => 'setiap siswa baru membayar 1x',
                'looping' => null,
            ], [
                'bills' => 'Uang Formulir',
                'notes' => 'setiap siswa baru membayar 1x',
                'looping' => null,
            ], [
                'bills' => 'SPP',
                'notes' => 'pembayaran tiap bulan',
                'looping' => '1',
            ], [
                'bills' => 'Uang Formulir',
                'notes' => 'pembayaran tiap bulan',
                'looping' => '1',
            ]
        ];
        DB::table('bills')->insert($bills);
    }
}
