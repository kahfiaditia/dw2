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

    public function schools_class()
    {
        return $this->belongsTo(School_class::class, 'school_class_id');
    }

    public function schools_level()
    {
        return $this->belongsTo(School_level::class, 'school_level_id');
    }
}
