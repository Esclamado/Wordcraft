<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    protected $table = 'order_notes';

    protected $fillable = [
        'order_id', 'user_id', 'type', 'message'
    ];

    public function order () {
        return $this->belongsTo('App\Order');
    }

    public function user () {
        return $this->belongsTo('App\User');
    }

    public function latest($column = 'created_at') {
        return $this->orderBy($column, 'desc');
    }
}
