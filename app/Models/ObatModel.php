<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObatModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'uks_obat';
    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsTo(JenisObatModel::class, 'id_jenis_obat')->withTrashed();
    }

    public function perawatan()
    {
        return $this->hasMany(PerawatanModel::class, 'id_obat');
    }
}
