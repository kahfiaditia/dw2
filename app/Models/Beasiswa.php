<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'beasiswa';

    public function students()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
