<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BursaProduk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bursa_produks';
    protected $guarded = [];
}
