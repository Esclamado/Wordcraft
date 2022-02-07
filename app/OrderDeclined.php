<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDeclined extends Model
{
    protected $table = 'declined_orders';

    protected $fillable = [
        'order_id',
        'user_id',
        'order_code',
        'pickup_point_location',
        'payment_type',
        'payment_details',
        'grand_total',
        'coupon_discount',
        'date_order_placed',
        'viewed',
        'delivery_viewed',
        'payment_status_viewed',
        'commission_calculated',
        'reason',
        'date_declined'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order_declined_details()
    {
        return $this->hasMany('App\OrderDeclinedDetail');
    }
}
