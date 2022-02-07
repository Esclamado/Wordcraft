<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderEditDetail extends Model
{
    protected $fillable = [
        'id',
        'order_id',
        'seller_id',
        'product_id',
        'variation',
        'price',
        'tax',
        'shipping_cost',
        'quantity',
        'partial_released_qty',
        'payment_status',
        'is_edit',
        'is_deleted',
        'edit_qty',
        'delivery_status',
        'shipping_type',
        'pickup_point_id',
        'order_type',
        'product_refferal_code',
        'partial_released'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function refund_request()
    {
        return $this->hasOne(RefundRequest::class);
    }
}
