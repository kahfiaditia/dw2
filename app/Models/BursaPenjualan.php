<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BursaPenjualan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bursa_penjualans';
    protected $guarded = [];

    public function satuan()
    {
        return $this->belongsTo(BursaSatuan::class, 'id_satuan');
    }
}
