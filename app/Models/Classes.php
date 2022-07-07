<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'classes';
    protected $guarded = [];

    public function school_level()
    {
        return $this->belongsTo(School_level::class, 'id_school_level');
    }

    public function school_class()
    {
        return $this->belongsTo(school_class::class, 'class_id');
    }
}
