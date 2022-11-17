<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_pinjaman extends Model
{
    use HasFactory;
    protected $table = 'inv_pinjaman';
    protected $guarded = [];

    public function karyawan()
    {
        return $this->belongsTo(Employee::class, 'id_karyawan');
    }

    public function barang()
    {
        return $this->belongsTo(Inventaris::class, 'id_barang');
    }
}
