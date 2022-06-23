<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kesejahteraan_siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kesejahteraan_siswa';

    protected $guarded = [];

    public function students()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
