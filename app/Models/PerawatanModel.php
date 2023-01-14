<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PerawatanModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'uks_perawatan';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa')->withTrashed();
    }

    public function uks_obat()
    {
        return $this->belongsTo(ObatModel::class, 'id_obat');
    }

    public function stok_obat()
    {
        return $this->belongsTo(StokObatModel::class, 'id_stok_obat');
    }
}
