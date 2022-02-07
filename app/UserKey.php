<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserKey extends Model
{
    protected $table = 'user_keys';

    protected $fillable = [
        'user_id', 'public_key', 'private_key', 'is_active'
    ];
}
