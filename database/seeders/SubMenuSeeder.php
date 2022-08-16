<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('submenu')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $sub_menus = [
            [
                'submenu' => 'Dashboard', 'route_submenu' => 'dashboard', 'type_menu' => 'view', 'menu_id' => '1',
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'view', 'menu_id' => '2',
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'insert', 'menu_id' => '2',
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'edit', 'menu_id' => '2',
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'delete', 'menu_id' => '2',
            ], [
                'submenu' => 'Absensi', 'route_submenu' => '', 'type_menu' => 'view', 'menu_id' => '2',
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'view', 'menu_id' => '3',
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'insert', 'menu_id' => '3',
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'edit', 'menu_id' => '3',
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'delete', 'menu_id' => '3',
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'view', 'menu_id' => '6',
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'insert', 'menu_id' => '6',
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'edit', 'menu_id' => '6',
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'delete', 'menu_id' => '6',
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'view', 'menu_id' => '10',
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'insert', 'menu_id' => '10',
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'edit', 'menu_id' => '10',
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'delete', 'menu_id' => '10',
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Hak Akses', 'route_submenu' => 'primession.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Hak Akses', 'route_submenu' => 'primession.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Maintenance', 'route_submenu' => 'setting.index', 'type_menu' => 'view', 'menu_id' => '13',
            ], [
                'submenu' => 'Menu', 'route_submenu' => null, 'type_menu' => 'view', 'menu_id' => '13',
            ], [
                'submenu' => 'Sub Menu', 'route_submenu' => null, 'type_menu' => 'view', 'menu_id' => '13',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'view', 'menu_id' => '14',
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'insert', 'menu_id' => '14',
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'edit', 'menu_id' => '14',
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'delete', 'menu_id' => '14',
            ], [
                'submenu' => 'Rubah Pembayaran Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'edit', 'menu_id' => '6',
            ]
        ];
        DB::table('submenu')->insert($sub_menus);
    }
}
