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
        $menus = [
            [
                'menu' => 'Management',
                'order' => '1',
                'icon' => 'fa fa-unlock-alt',
                'flag_menu' => 'management',
            ], [
                'menu' => 'Report',
                'order' => '2',
                'icon' => 'fa fa-book',
                'flag_menu' => 'report',
            ], [
                'menu' => 'Sales & Marketing',
                'order' => '3',
                'icon' => 'fa fa-briefcase',
                'flag_menu' => 'sales',
            ], [
                'menu' => 'Purchasing',
                'order' => '4',
                'icon' => 'fa fa-shopping-cart',
                'flag_menu' => 'purchasing',
            ], [
                'menu' => 'Inventory',
                'order' => '5',
                'icon' => 'fa fa-cubes',
                'flag_menu' => 'inventory',
            ], [
                'menu' => 'Produksi',
                'order' => '6',
                'icon' => 'fa fa-cogs',
                'flag_menu' => 'produksi',
            ], [
                'menu' => 'Pengiriman',
                'order' => '7',
                'icon' => 'fa fa-truck',
                'flag_menu' => 'delivery',
            ], [
                'menu' => 'Finance',
                'order' => '8',
                'icon' => 'fa fa-money',
                'flag_menu' => 'finances',
            ], [
                'menu' => 'Master',
                'order' => '9',
                'icon' => 'fa fa-file',
                'flag_menu' => 'master',
            ]
        ];
        DB::table('menu')->insert($menus);
    }
}
