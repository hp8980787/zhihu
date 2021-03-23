<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['to_user_id', 'from_user_id', 'body'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');

    }
}
