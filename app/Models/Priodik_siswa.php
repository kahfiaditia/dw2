<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priodik_siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'priodik_siswa';

    public function student()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
