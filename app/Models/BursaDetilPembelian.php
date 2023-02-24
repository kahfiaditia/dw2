<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BursaDetilPembelian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bursa_detil_pembelian';
    protected $guarded = [];

    public function produk()
    {
        return $this->belongsTo(BursaProduk::class, 'id_produk');
    }
}
