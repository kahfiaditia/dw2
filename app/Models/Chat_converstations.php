<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat_converstations extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_conversations';
    protected $guarded = [];

    public function user_one()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    public function user_two()
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    public function message()
    {
        return $this->hasMany(Chat_message::class, 'conversations_id');
    }
}
