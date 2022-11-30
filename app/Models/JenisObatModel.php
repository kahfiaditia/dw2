<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisObatModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'uks_jenis_obat';
    protected $guarded = [];
}
