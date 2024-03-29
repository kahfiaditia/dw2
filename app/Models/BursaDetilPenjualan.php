<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BursaDetilPenjualan extends Model
{
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(BursaProduk::class, 'id_produk');
    }
}
