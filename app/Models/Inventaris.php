<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    public $table = 'inv_inventaris';
    protected $guarded = [''];

    public function ruang()
    {
        return $this->belongsTo(Inv_Ruangan::class, 'id_ruangan');
    }
}
