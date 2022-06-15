<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestasi';
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
