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
        $sub_menus = [
            // management
            [
                'sub_menu' => 'Customer Approval',
                'order' => '1',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.customer',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Price Approval',
                'order' => '2',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.price',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Quotation Approval',
                'order' => '3',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.quotation',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'PO Req Approval',
                'order' => '4',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.po',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'PO Supplier Approval',
                'order' => '5',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.supplier',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'SO Approval',
                'order' => '6',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.so',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Produksi Approval',
                'order' => '7',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.production',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Register Penomoran Tabung',
                'order' => '8',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'requestaset.index',
                'menu_id' => '1',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pengurangan Stock',
                'order' => '9',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'app.reducestockapproval',
                'menu_id' => '1',
                'type_menu' => 'view',
            ],
            // report
            [
                'sub_menu' => 'Laporan Penjualan',
                'order' => '10',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'report.reportsales',
                'menu_id' => '2',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Laporan Pembelian',
                'order' => '11',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'report.reportpurchasing',
                'menu_id' => '2',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Laporan Tabung',
                'order' => '12',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'report.tabung',
                'menu_id' => '2',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Laporan Pengiriman',
                'order' => '13',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'report.pengiriman',
                'menu_id' => '2',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Laporan Customer',
                'order' => '14',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'report.customer',
                'menu_id' => '2',
                'type_menu' => 'view',
            ],
            // sales & marketing
            [
                'sub_menu' => 'Pengajuan Pelanggan Baru',
                'order' => '15',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'pengajuan.pelanggan',
                'menu_id' => '3',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pengajuan Harga',
                'order' => '16',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'pengajuan.harga',
                'menu_id' => '3',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Quotation',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'quotation',
                'menu_id' => '3',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'PO/SPK',
                'order' => '18',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'po',
                'menu_id' => '3',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pengajuan Sales Order',
                'order' => '19',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'so.index',
                'menu_id' => '3',
                'type_menu' => 'view',
            ],
            // purchasing
            [
                'sub_menu' => 'Purchase Request',
                'order' => '20',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'purchaserequest.index',
                'menu_id' => '4',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pengajuan Pembelian',
                'order' => '21',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'purchasing.index',
                'menu_id' => '4',
                'type_menu' => 'view',
            ],
            // inventory
            [
                'sub_menu' => 'Penerimaan Barang Vendor',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'receive.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pendataan Barang',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'inventories.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Stok Barang',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'stock.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Penerimaan Tabung Kosong',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'ttbk.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Tabung Pelanggan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'customertube.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Tabung Supplier',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'suppliertube.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Request Pengurangan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'reducestock.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Request Stock Keluar',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'stockout.index',
                'menu_id' => '5',
                'type_menu' => 'view',
            ],
            // produksi
            [
                'sub_menu' => 'Produksi',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'produksi.index',
                'menu_id' => '6',
                'type_menu' => 'view',
            ],
            // pengiriman
            [
                'sub_menu' => 'Persiapan Pengiriman',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'do.persiapan',
                'menu_id' => '7',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pengiriman',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'do.index',
                'menu_id' => '7',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Penarikan Tabung Kosong',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'transaction.index',
                'menu_id' => '7',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Delivery Order Supplier',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'deliveryordersupplier.index',
                'menu_id' => '7',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Tabung Cross Pelanggan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'cross.index',
                'menu_id' => '7',
                'type_menu' => 'view',
            ],
            // finance
            [
                'sub_menu' => 'Invoice Vendor',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'vendorinvoice.index',
                'menu_id' => '8',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Invoice Pelanggan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'invoice.index',
                'menu_id' => '8',
                'type_menu' => 'view',
            ],
            // master
            [
                'sub_menu' => 'Liquid',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'liquid.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Gas',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'kategori.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Tabung',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'product.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Tangki',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'tank.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Aksesoris',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'accessories.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Pelanggan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'pelanggan.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Suplier',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'supplier.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Supir',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'supir.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Mobil',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'mobil.list',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Cabang',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'region.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Rekening',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'rekening.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Divisi',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'division.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Satuan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'satuan.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'Jenis Potongan',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'jenispotongan.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ], [
                'sub_menu' => 'User',
                'order' => '17',
                'icon' => 'fa fa-angle-double-right',
                'route' => 'user.index',
                'menu_id' => '9',
                'type_menu' => 'view',
            ]
        ];
        DB::table('sub_menu')->insert($sub_menus);
    }
}
