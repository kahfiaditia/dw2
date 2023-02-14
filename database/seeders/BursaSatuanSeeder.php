<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BursaSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bursa_satuans')->insert([
            [
                'nama' => 'KILOGRAM',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'ONS',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'PCS',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'BATANG',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'PAKET',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'LEMBAR',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'LITER',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'GRAM',
                'status' => '1',
                'user_created' => '2',
            ], [
                'nama' => 'BUNGKUS',
                'status' => '1',
                'user_created' => '2',
            ]
        ]);
    }
}
