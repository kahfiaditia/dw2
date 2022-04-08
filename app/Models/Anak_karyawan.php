<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anak_karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anak_karyawan';

    public function anak_karyawan_sekolah_dw()
    {
        return $this->hasMany(Anak_karyawan_sekolah_dw::class, 'anak_id');
    }
}
