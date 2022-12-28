<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokObatModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'uks_stok_obat';
    protected $guarded = [];

    public function obat()
    {
        return $this->belongsTo(ObatModel::class, 'id_obat')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_created')->withTrashed();
    }

    public function perawatan_obat()
    {
        return $this->hasMany(PerawatanModel::class, 'id');
    }
}
