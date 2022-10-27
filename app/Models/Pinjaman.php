<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjaman extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'perpus_pinjaman';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id')->withTrashed();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id')->withTrashed();
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id')->withTrashed();
    }
}
