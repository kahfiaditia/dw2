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

    public function kelas()
    {
        return $this->belongsTo(School_class::class, 'id_siswa');
    }

    public function kelas_level()
    {
        return $this->belongsTo(School_level::class, 'id_siswa');
    }

    public function uks_obat()
    {
        return $this->belongsTo(ObatModel::class, 'id_obat');
    }

    public function stok_obat()
    {
        return $this->belongsTo(StokObatModel::class, 'id_stok_obat');
    }

    // public function data_obat()
    // {

    //     return DB::table('uks_perawatan')
    //         ->leftJoin('uks_stok_obat', 'uks_stok_obat.id_obat', '=', 'uks_perawatan.id_stok_obat')
    //         ->leftJoin('uks_obat', 'uks_obat.id', '=', 'uks_perawatan.id_obat')
    //         ->get();
    // }

    // public function jenis_obat()
    // {
    //     return $this->belongsTo(JenisObatModel::class, 'id_obat')->withTrashed();
    // }

    // public function stok_obat()
    // {
    //     return $this->belongsTo(StokObatModel::class, 'id_obat')->withTrashed();
    // }
}
