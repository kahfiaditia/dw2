<?php

namespace Database\Seeders;

use Illuminate\Cache\NullStore;
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
                'submenu' => 'Dashboard', 'route_submenu' => 'dashboard', 'type_menu' => 'view', 'menu_id' => '1', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'view', 'menu_id' => '2', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'insert', 'menu_id' => '2', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'edit', 'menu_id' => '2', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Pribadi', 'route_submenu' => 'employee', 'type_menu' => 'delete', 'menu_id' => '2', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Absensi', 'route_submenu' => '', 'type_menu' => 'view', 'menu_id' => '2', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'view', 'menu_id' => '3', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'insert', 'menu_id' => '3', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'edit', 'menu_id' => '3', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Akun', 'route_submenu' => 'akun.index', 'type_menu' => 'delete', 'menu_id' => '3', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '1',
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Agama', 'route_submenu' => 'agama', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '2',
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kodepos', 'route_submenu' => 'kodepos', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'view', 'menu_id' => '6', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'insert', 'menu_id' => '6', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'edit', 'menu_id' => '6', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'delete', 'menu_id' => '6', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '3',
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kebutuhan Khusus', 'route_submenu' => 'needs.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '5',
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tagihan', 'route_submenu' => 'bills.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '4',
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kelas', 'route_submenu' => 'classes.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'view', 'menu_id' => '10', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'insert', 'menu_id' => '10', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'edit', 'menu_id' => '10', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pembayaran', 'route_submenu' => 'invoice.index', 'type_menu' => 'delete', 'menu_id' => '10', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '6',
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Setting Pembayaran', 'route_submenu' => 'payment.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Hak Akses', 'route_submenu' => 'primession.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '9',
            ], [
                'submenu' => 'Hak Akses', 'route_submenu' => 'primession.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Maintenance', 'route_submenu' => 'setting.index', 'type_menu' => 'view', 'menu_id' => '13', 'display_submenu' => '1', 'order_submenu' => '1',
            ], [
                'submenu' => 'Menu', 'route_submenu' => null, 'type_menu' => 'view', 'menu_id' => '13', 'display_submenu' => '1', 'order_submenu' => '2',
            ], [
                'submenu' => 'Sub Menu', 'route_submenu' => null, 'type_menu' => 'view', 'menu_id' => '13', 'display_submenu' => '1', 'order_submenu' => '3',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '7',
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Setting Diskon', 'route_submenu' => 'diskon.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'view', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => '8',
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'insert', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'edit', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Siswa Prestasi', 'route_submenu' => 'prestasi.index', 'type_menu' => 'delete', 'menu_id' => '14', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Rubah Pembayaran Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'edit', 'menu_id' => '6', 'display_submenu' => '0', 'order_submenu' => null,
            ], [
                'submenu' => 'Chat', 'route_submenu' => 'chat.index', 'type_menu' => 'view', 'menu_id' => '15', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => 'kategori.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => '2',
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Rak', 'route_submenu' => 'rak.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => '1',
            ], [
                'submenu' => 'Rak', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Rak', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Rak', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Penerbit', 'route_submenu' => 'penerbit.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => '3',
            ], [
                'submenu' => 'Penerbit', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Penerbit', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Penerbit', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Buku', 'route_submenu' => 'buku.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => '4',
            ], [
                'submenu' => 'Buku', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Buku', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Buku', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman', 'route_submenu' => 'pinjaman.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => '5',
            ], [
                'submenu' => 'Pinjaman', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman Approve', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => 'inventaris.index', 'type_menu' => 'view', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => 'ruangan.index', 'type_menu' => 'view', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ],
        ];
        DB::table('submenu')->insert($sub_menus);
    }
}
