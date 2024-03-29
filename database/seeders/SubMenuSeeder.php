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
                'submenu' => 'Beranda', 'route_submenu' => 'dashboard', 'type_menu' => 'view', 'menu_id' => '1', 'display_submenu' => '1', 'order_submenu' => null,
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
                'submenu' => 'Menu', 'route_submenu' => 'menu.index', 'type_menu' => 'view', 'menu_id' => '13', 'display_submenu' => '1', 'order_submenu' => '2',
            ], [
                'submenu' => 'Sub Menu', 'route_submenu' => 'submenu.index', 'type_menu' => 'view', 'menu_id' => '13', 'display_submenu' => '1', 'order_submenu' => '3',
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
                'submenu' => 'Rubah Pembayaran Siswa', 'route_submenu' => 'siswa.index', 'type_menu' => 'edit', 'menu_id' => '6', 'display_submenu' => '0', 'order_submenu' => 2,
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
                'submenu' => 'Pinjaman', 'route_submenu' => null, 'type_menu' => 'approve', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => 'ruangan.index', 'type_menu' => 'view', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => 1,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Ruangan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => 'inventaris.index', 'type_menu' => 'view', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => 2,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Data Barang', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman Inventaris', 'route_submenu' => 'inv_pinjaman.index', 'type_menu' => 'view', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => 3,
            ], [
                'submenu' => 'Pinjaman Inventaris', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman Inventaris', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman Inventaris', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pinjaman Inventaris', 'route_submenu' => null, 'type_menu' => 'approve', 'menu_id' => '17', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Obat', 'route_submenu' => 'obat.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 1,
            ], [
                'submenu' => 'Obat', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Obat', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Obat', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tambah Stok', 'route_submenu' => 'stok_obat.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 2,
            ], [
                'submenu' => 'Tambah Stok', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tambah Stok', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Tambah Stok', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Perawatan', 'route_submenu' => 'perawatan.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 3,
            ], [
                'submenu' => 'Perawatan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Perawatan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Perawatan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Opname Stok', 'route_submenu' => 'opname_obat.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 4,
            ], [
                'submenu' => 'Opname Stok', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Opname Stok', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Opname Stok', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Komparasi Stok', 'route_submenu' => 'komparasi', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 5,
            ], [
                'submenu' => 'Komparasi Stok', 'route_submenu' => null, 'type_menu' => 'approve', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Hasil Komparasi Opname', 'route_submenu' => 'komparasi.hasil_komparasi', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => 'uks_kategori.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 0,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Kategori', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Rekap Medis', 'route_submenu' => 'rekam_medis.index', 'type_menu' => 'view', 'menu_id' => '18', 'display_submenu' => '1', 'order_submenu' => 7,
            ], [
                'submenu' => 'Rekap Perpus', 'route_submenu' => 'rekap_perpus.index', 'type_menu' => 'view', 'menu_id' => '16', 'display_submenu' => '1', 'order_submenu' => 7,
            ], [
                'submenu' => 'Barcode Siswa', 'route_submenu' => 'rekap_perpus.index', 'type_menu' => 'edit', 'menu_id' => '6', 'display_submenu' => '1', 'order_submenu' => 3,
            ], [
                'submenu' => 'Jam Pelajaran', 'route_submenu' => 'jam_pelajaran.index', 'type_menu' => 'view', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => 1,
            ], [
                'submenu' => 'Pelajaran', 'route_submenu' => 'pelajaran.index', 'type_menu' => 'view', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => 2,
            ], [
                'submenu' => 'Pelajaran', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pelajaran', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Pelajaran', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Jadwal', 'route_submenu' => 'jadwal.index', 'type_menu' => 'view', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => 3,
            ], [
                'submenu' => 'Jadwal', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Jadwal', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Jadwal', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Absensi', 'route_submenu' => 'absensi.index', 'type_menu' => 'view', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => 4,
            ], [
                'submenu' => 'Absensi', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Absensi', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Absensi', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '19', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Supplier', 'route_submenu' => 'supplier.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 5,
            ], [
                'submenu' => 'Supplier', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Supplier', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Supplier', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Satuan', 'route_submenu' => 'satuan.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Satuan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Satuan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Satuan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Kategori', 'route_submenu' => 'bursa_kategori.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Bursa Kategori', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Kategori', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Kategori', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Produk', 'route_submenu' => 'bursa_produk.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Bursa Produk', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Produk', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Produk', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ],  [
                'submenu' => 'Bursa Pembelian', 'route_submenu' => 'bursa_pembelian.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Bursa Pembelian', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Pembelian', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Pembelian', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Penjualan', 'route_submenu' => 'bursa_penjualan.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Bursa Penjualan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Penjualan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Penjualan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Laporan Penjualan', 'route_submenu' => 'laporan_penjualan.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Laporan Penjualan', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Laporan Penjualan', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Laporan Penjualan', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ],  [
                'submenu' => 'Bursa Opname', 'route_submenu' => 'bursa_opname.index', 'type_menu' => 'view', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => 6,
            ], [
                'submenu' => 'Bursa Opname', 'route_submenu' => null, 'type_menu' => 'insert', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Opname', 'route_submenu' => null, 'type_menu' => 'edit', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ], [
                'submenu' => 'Bursa Opname', 'route_submenu' => null, 'type_menu' => 'delete', 'menu_id' => '20', 'display_submenu' => '1', 'order_submenu' => null,
            ]
        ];
        DB::table('submenu')->insert($sub_menus);
    }
}
