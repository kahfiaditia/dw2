<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function cron_buku()
    {
        // set kode buku dan barcode
        $buku = Buku::wherenull('barcode')->limit(100)->get();
        foreach ($buku as $item) {
            $item->kode_buku;
            $bar = explode('-', $item->kode_buku);
            $nomor = (int)$bar[1];
            $Nol = "";
            $nilai = 4 - strlen($nomor);
            for ($i = 1; $i <= $nilai; $i++) {
                $Nol = $Nol . "0";
            }
            $kode_buku   = $bar[0] . '-' . $Nol .  $nomor;

            $id = $item->id;
            // $buku = Buku::findOrFail($id);
            // $buku->kode_buku = $kode_buku;
            // $buku->barcode = $kode_buku;
            // $buku->save();
        }
    }
}
