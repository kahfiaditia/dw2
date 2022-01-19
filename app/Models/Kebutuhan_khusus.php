<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kebutuhan_khusus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kebutuhan_khusus';

    protected $guarded = [];
}
