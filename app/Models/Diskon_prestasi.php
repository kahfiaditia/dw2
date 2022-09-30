<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon_prestasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'diskon_prestasi';
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id')->withTrashed();
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id')->withTrashed();
    }

    public function invoice_prestasi()
    {
        return $this->hasOne(Invoice::class, 'prestasi_id');
    }
}
