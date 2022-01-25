<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontak_darurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kontak_darurat';
}
