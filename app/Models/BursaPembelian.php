<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BursaPembelian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bursa_pembelians';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(BursaSupplier::class, 'id_supplier');
    }

    // public function produk()
    // {
    //     return $this->belongsTo(BursaProduk::class, 'id_produk');
    // }
}
