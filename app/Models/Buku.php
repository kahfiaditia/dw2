<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'perpus_buku';
    protected $guarded = [];

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
}
