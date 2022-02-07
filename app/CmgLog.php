<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmgLog extends Model
{
    protected $table = 'cmg_logs';

    protected $fillable = [
        'user_id',
        'order_id',
        'activity',
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function order () {
        return $this->belongsTo(Order::class);
    }
}
