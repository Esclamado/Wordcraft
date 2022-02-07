<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDeclinedDetail extends Model
{
    protected $table = 'order_declined_details';

    protected $fillable = [
        'order_declined_id',
        'order_id',
        'product_id',
        'variation',
        'price',
        'tax',
        'shipping_cost',
        'quantity',
        'payment_status',
        'delivery_status',
        'shipping_type',
        'pickup_point_id',
        'order_type',
        'product_referral_code',
    ];

    public function order_declined()
    {
        return $this->belongsTo('App\OrderDeclined');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
