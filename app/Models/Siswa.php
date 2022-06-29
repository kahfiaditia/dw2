<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';

    protected $guarded = [];

    public function parents()
    {
        return $this->hasMany(Parents::class, 'siswa_id');
    }

    public function religion()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function special_need()
    {
        return $this->belongsTo(Kebutuhan_khusus::class, 'kebutuhan_khusus_id')->withTrashed();
    }

    public function periodic_student()
    {
        return $this->hasOne(Priodik_siswa::class, 'siswa_id');
    }

    public function performances()
    {
        return $this->hasMany(Prestasi::class, 'siswa_id');
    }

    public function beasiswa()
    {
        return $this->hasMany(Beasiswa::class, 'siswa_id');
    }

    public function kesejahteraan()
    {
        return $this->hasMany(Kesejahteraan_siswa::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
