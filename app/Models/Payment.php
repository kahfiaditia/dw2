<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'payment';
    protected $guarded = [];

    public function bills()
    {
        return $this->belongsTo(Bills::class, 'bills_id')->withTrashed();
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id')->withTrashed();
    }
}
