<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conservation extends Model
{
    protected $fillable = [
        'user_id1',
        'user_id2',
        'last_message_id'
    ];
}
