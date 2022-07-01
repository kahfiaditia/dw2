<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menu')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $menus = [
            [
                'menu' => 'Beranda',
                'icon' => 'bx bxs-dashboard',
                'sub_menu' => '0',
                'order_menu' => '1',
            ], [
                'menu' => 'Data',
                'icon' => 'bx bx-group',
                'sub_menu' => '1',
                'order_menu' => '2',
            ], [
                'menu' => 'Akun',
                'icon' => 'bx bx-group',
                'sub_menu' => '0',
                'order_menu' => '4',
            ], [
                'menu' => 'Agama',
                'icon' => 'bx bx-list-ul',
                'sub_menu' => '0',
                'order_menu' => '5',
            ], [
                'menu' => 'Kodepos',
                'icon' => 'bx bx-directions',
                'sub_menu' => '0',
                'order_menu' => '6',
            ], [
                'menu' => 'Siswa',
                'icon' => 'bx bx-group',
                'sub_menu' => '0',
                'order_menu' => '3',
            ], [
                'menu' => 'Kebutuhan Khusus',
                'icon' => 'bx bx-accessibility',
                'sub_menu' => '0',
                'order_menu' => '7',
            ], [
                'menu' => 'Tagihan',
                'icon' => 'bx bx-receipt',
                'sub_menu' => '0',
                'order_menu' => '9',
            ], [
                'menu' => 'Kelas',
                'icon' => 'bx bxs-school',
                'sub_menu' => '0',
                'order_menu' => '8',
            ], [
                'menu' => 'Pembayaran',
                'icon' => 'bx bx-wallet',
                'sub_menu' => '0',
                'order_menu' => '11',
            ], [
                'menu' => 'Setting Pembayaran',
                'icon' => 'bx bx-wallet-alt',
                'sub_menu' => '0',
                'order_menu' => '10',
            ]
        ];
        DB::table('menu')->insert($menus);
    }
}
