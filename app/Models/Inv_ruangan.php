<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inv_ruangan extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'inv_ruangan';
    protected $guarded = [''];
}
