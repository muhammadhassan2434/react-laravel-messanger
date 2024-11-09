<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    protected $fillable = [
        'message_id',
        'name',
        'path',
        'mime',
        'size',
    ];

    public function lastMessage(){
        return $this->belongsTo(Message::class, 'last_message_id');
    }


    public function user1(){
        return $this->belongsTo(User::class, 'user_id1');
    }
    public function user2(){
        return $this->belongsTo(User::class, 'user_id2');
    }
}
