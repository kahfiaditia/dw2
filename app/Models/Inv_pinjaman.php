<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inv_pinjaman extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'inv_pinjaman';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'nama_peminjam');
    }

    public function barang()
    {
        return $this->belongsTo(Inventaris::class, 'id_barang');
    }
}
